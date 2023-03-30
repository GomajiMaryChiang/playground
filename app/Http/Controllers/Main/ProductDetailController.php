<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use App\Services\JsonldService;
use App\Services\MetaService;
use App\Services\ProductService;
use Config;
use Mobile_Detect;

class ProductDetailController extends Controller
{
    protected $apiService;
    protected $eventService;
    protected $jsonldService;
    protected $metaService;
    protected $productService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, EventService $eventService, JsonldService $jsonldService, MetaService $metaService, ProductService $productService)
    {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
        $this->jsonldService = $jsonldService;
        $this->metaService = $metaService;
        $this->productService = $productService;
    }

    /**
     * 檔次詳細頁
     */
    public function __invoke(Request $request, $groupId = 0, $productId = 0)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), $request->route('groupId'), $request->route('storeId'), $productId, 'detail');

        $preview = (!empty($request->input('preview', '')) && $request->input('preview', '') == 1) ? 1 : 0; // 預覽頁
        $shareCode = !empty($_GET['share_code']) ? $_GET['share_code'] : '' ; // 單檔 MGM 贈點的分享碼
        $ref = (!empty($_COOKIE['gmc_site_pay']) && preg_match('/^ref_[0-9]+$/', $_COOKIE['gmc_site_pay'])) ? $_COOKIE['gmc_site_pay'] : ''; // 返利網 cookie 的值
        $refNum = explode('ref_', $ref)[1] ?? 0;
        $refNum = (is_numeric($refNum) && $refNum > 0) ? $refNum : 0; // 返利網編號
        $date = $this->eventService->getTime($request->input('date', date('Y-m-d H:i:s')));

        // 商品block -- start --
        $param = [
            'product_id' => $productId,
            'preview' => $preview
        ];
        // 咖啡檔次
        if (!empty($request->route('groupId'))) {
            $param['group_id'] = $groupId;
        }

        $rtProduct = $this->apiService->curl('product-info', 'GET', $param);

        if ($rtProduct['return_code'] == '1014' && !empty($ref) && !empty($refNum)) {
            $refName = Config::get('ref.name.' . $ref) ?? '';
            $this->warningAlert('此商品不適用「' . $refName . '現金」回饋，如要購買建議您下載GOMAJI APP。', '/');
        } else if (($rtProduct['return_code'] != 0000) || empty($rtProduct['data'])) {
            $this->warningAlert("商品不存在(" . $rtProduct['return_code'] . ")", Config::get('setting.usagiDomain') . "/store/" . $request->route('storeId'));
        } else {
            $rtProduct = $rtProduct['data'] ?? [];
        }

        if (!$preview) {
            // 如PC不顯示且不是FB的爬蟲跳提示文字
            $userAgent = !empty($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
            $rtProduct['display'] = $rtProduct['display'] ?? 0;
            if (($rtProduct['display'] & 1) != 1
                && strpos($userAgent, "facebookexternalhit/") === false
                && strpos($userAgent, "Facebot") === false
            ) {
                if (($rtProduct['display'] & 4) != 4 && ($rtProduct['display'] & 64) != 64) { // 若其他兩個平台也不支援，需要顯示其他提示文字
                    $this->warningAlert('商品不存在', '/');
                } else {
                    $metaAry = [
                        'url' => sprintf('%s://%s%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']),
                        'title' => $rtProduct['store_name'] . '超值優惠方案| GOMAJI夠麻吉',
                        'image' => (!empty($rtProduct['img'][0]) ? $rtProduct['img'][0] : ''),
                        'description' => (!empty($rtProduct['real_product_name']) ? $rtProduct['real_product_name'] : $rtProduct['product_name']),
                    ];
                    $this->warningAlert('此檔商品限APP使用，建議您下載APP進行購買！', '/', false, $metaAry);
                }
            }
        }
        // 商品block -- end --

        // PC or Mobile 判斷
        $platform = 0;
        $detect = new Mobile_Detect();
        if ($detect->isMobile() && !$detect->isTablet()) {
            $platform = 1;
        }

        // 增加商品頁banner輪播 -- start --
        $bannerChId = $this->productService->getBannerCh($rtProduct);
        $bannerType = 3;
        $isShowMmBanner = false;
        $refererHost = parse_url($request->headers->get('referer'))['host'] ?? '';
        $usagiHost = substr(Config::get('setting.usagiDomain'), 8);

        // mm 且（直接進入檔次頁 或 從其他網站來的），抓首頁的 banner 資訊
        if ($platform == 1 && $refererHost != $usagiHost) {
            $bannerChId = 0;
            $bannerType = 1;
            $isShowMmBanner = true;
        }

        $param = [
            'ch_id' => $bannerChId,
            'city_id' => $rtProduct['city_id'],
            'type' => $bannerType,
        ];

        $bannerCurlWork = $this->apiService->curl('banner-list', 'GET', $param);

        if (!empty($bannerCurlWork['return_code']) && $bannerCurlWork['return_code'] == 0000 && !empty($bannerCurlWork['data']['banners'])) {
            $rtProduct['banners'] = $bannerCurlWork['data']['banners'];

            foreach ($rtProduct['banners'] as $k => $b) {
                $rtProduct['banners'][$k]['link_url'] = $this->productService->getBannerLink($b);
            }
        }
        // 增加商品頁banner輪播 -- end --

        // 商品資訊內容
        $rtProduct['product_intro'] = $this->apiService->curl($rtProduct['product_intro_url']);
        //商店名稱
        $rtProduct['display_store_name'] = $this->productService->getProductName($rtProduct);

        // 評價指數
        if (strpos($rtProduct['store_rating_score'], '.') === false) {
            $rtProduct['smile_class'] = $rtProduct['store_rating_score'];
            $rtProduct['store_rating_score'] .= '.0';
        } else {
            $rtProduct['smile_class'] = floor($rtProduct['store_rating_score']) . '-1';
        }
        $rtProduct['store_rating_score'] = str_replace('.', '</span> <span class="t-085 t-main">.', $rtProduct['store_rating_score']);

        // 處理配送資訊的跳窗
        $productDescRes = $this->apiService->curl($rtProduct['product_desc_url']);
        $rtProduct['product_description'] = $this->productService->handleProductDescription($productDescRes);

        // 處理使用規則的跳窗
        $ticketUseRuleRes = $this->apiService->curl($rtProduct['ticket_use_rule_url']);
        $rtProduct['ticket_use_rule'] = $this->productService->handleProductDescription($ticketUseRuleRes);

        // 處理兌換說明 -- start --
        $idxStart = strpos($rtProduct['product_description'], '<ul class="fine_print_area">') + strlen('<ul class="fine_print_area">');
        $idxEnd = strpos($rtProduct['product_description'], '</ul>');
        $rtProduct['fine_print'] = array();
        if ($idxStart !== false && $idxEnd !== false) {
            $liHtml = substr($rtProduct['product_description'], $idxStart, $idxEnd - $idxStart);
            $arr = explode('</li>', $liHtml);
            foreach ($arr as $li) {
                $li = trim($li);
                if (empty($li)) {
                    continue;
                }

                // 由於格式不合，手動轉換格式
                $nake = str_replace(array(' ', "\t", "\n"), '', $li);
                $nake = str_replace(',', '，', $nake);
                $nake = strip_tags($nake);

                $regx = '/[0-9]+\.\ *需遵守兌換券須知及店家現場消費規定/i';
                $li = preg_replace($regx, '', $li);
                $rtProduct['fine_print'][] = $li . '</li>';
            }
        }
        // 處理兌換說明 -- end --

        // 如為無效期 需換兌換券須知的跳窗文字
        $rtProduct['tooltip_text'] = '不能與其他優惠合併，無法兌換現金，逾期未兌換可退費。';

        $rtProduct['url'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // 開始倒數 tk_type = 1
        if ($rtProduct['tk_type'] == 1) {
            $rtProduct['untilTs'] = (strtotime($rtProduct['expiry_date']) - time());
        }

        // 如果完售則 call 完售熱門推薦api
        if ($rtProduct['order_status'] == 'END') {
            $param = [
                'sid' => $rtProduct['store_id'],
                'gid' => $rtProduct['group_id'],
                'pid' => $rtProduct['product_id'],
                'product_kind' => $rtProduct['product_kind'],
                'plat' => 2,
                'func' => 1
            ];

            $hotCurlWork = $this->apiService->curl('other-products', 'GET', $param);

            if (($hotCurlWork['return_code'] == 0000) && !empty($hotCurlWork['data'])) {
                // 設定只顯示10筆熱銷推薦商品
                $rtProduct['hot_products'] = [];
                $num = (count($hotCurlWork['data']) < 10) ? count($hotCurlWork['data']) : 10;
                for ($i = 0; $i < $num; $i++) {
                    $rtProduct['hot_products'][$i]['link'] = $this->productService->getProductLink($hotCurlWork['data'][$i]);
                    $rtProduct['hot_products'][$i]['org_price'] = $this->productService->getProductPrice($hotCurlWork['data'][$i], $this->productService::ORIGINAL_PRICE); // 原價
                    $rtProduct['hot_products'][$i]['price'] = $this->productService->getProductPrice($hotCurlWork['data'][$i], $this->productService::SELLING_PRICE); // 售價
                    foreach ($hotCurlWork['data'][$i] as $key => $val) {
                        $rtProduct['hot_products'][$i][$key] = $val;
                    }
                }
            }
        }
        // 圖片輪播介紹
        if (!empty($rtProduct['img'])) {
            foreach ($rtProduct['img'] as $k => $v) {
                $v = str_replace('products', 'products/o', $v);
                $rtProduct['img'][$k] = str_replace('_r.', '.', $v);
            }
        }
        // 單方案預覽頁
        $rtProduct['previewOrgPrice'] = (count($rtProduct['sub_products']) > 0) ? 0 : $rtProduct['org_price']; // 原價
        $rtProduct['previewPrice'] = (count($rtProduct['sub_products']) > 0) ? 0 : $rtProduct['price']; // 售價
        // 價格
        $rtProduct['org_price'] = $this->productService->getProductPrice($rtProduct, $this->productService::ORIGINAL_PRICE);
        $rtProduct['price'] = $this->productService->getProductPrice($rtProduct, $this->productService::SELLING_PRICE);

        $data = $this->defaultPageParam();
        $data['product'] = $rtProduct;
        $data['preview'] = $preview;
        $data['shareCode'] = $shareCode;
        $data['ref'] = !empty($_COOKIE['gmc_site_pay']) && strpos($_COOKIE['gmc_site_pay'], '_') != false ? explode('_', $_COOKIE['gmc_site_pay'])[1] : ''; // 返利網的編號

        // search keyword used
        $data['detailCity'] = $data['product']['city_id'];
        $data['ch'] = $data['product']['ch_id'];

        $subChannelInTarget = false;
        if (!empty($data['product']['sub_channels'])) {
            $subChannels = explode(',', $data['product']['sub_channels']);
            if (in_array(2, $subChannels) || in_array(9, $subChannels)) {
                $subChannelInTarget = true;
            }
        }

        if ($subChannelInTarget && Config::get('product.categoryId.ticket') == $data['product']['category_id']) {
            $data['ch'] = Config::get('channel.id.es');
        } else if (Config::get('channel.id.lf') == $data['product']['ch_id']) {
            $data['ch'] = Config::get('channel.id.lfn');
        } else if (Config::get('product.kindId.coffee') == $data['product']['product_kind']) {
            $data['ch'] = Config::get('channel.id.coffee');
        }

        if ($data['ch']) {
            $data['dropdownAllowCh'] = [];
        }

        // 如果有fb粉絲團擷取短網址
        if (!empty($data['product']['store_info']['facebook_url'])) {
            $data['product']['store_info']['facebook_url'] = urldecode($data['product']['store_info']['facebook_url']);
            $original_fb_url = $data['product']['store_info']['facebook_url'];
            $symbolCharacter = '?';
            if (false !== ($rst = strpos($original_fb_url, $symbolCharacter))) {
                $data['product']['store_info']['facebook_url'] = substr($original_fb_url, 0, $rst);
            }
        }

        // meta -- start --
        $storeName = $data['product']['store_name'] ?? '';
        $realProductName = $data['product']['real_product_name'] ?? '';
        $productName = $data['product']['product_name'] ?? '';
        $metaProductName = !empty($realProductName) ? $realProductName : $productName;

        if ($data['product']['city_id'] == Config('city.baseCityList.publicWelfare')) {
            // 公益檔次
            $configMetaData = Config::get('meta.productDetail.publicWelfare');
            $data['meta']['title'] = $this->metaService->bindValue($configMetaData['title'], [':publicWelfareName' => $productName]);
            $data['meta']['description'] = $this->metaService->bindValue($configMetaData['description'], [':productName' => $productName]);
        } elseif ($data['product']['product_kind'] == Config::get('product.kindId.coffee')) {
            // 咖啡檔次
            $configMetaData = Config::get('meta.productDetail.coffee');
            $data['meta']['title'] = $this->metaService->bindValue($configMetaData['title'], [':brandName' => $storeName, ':productName' => $productName]);
            $data['meta']['description'] = $this->metaService->bindValue($configMetaData['description'], [':productName' => $metaProductName]);
        } else {
            // 一般檔次
            $configMetaData = Config::get('meta.productDetail.common');
            $data['meta']['title'] = $this->metaService->bindValue($configMetaData['title'], [':storeName' => $storeName]);
            $data['meta']['description'] = $this->metaService->bindValue($configMetaData['description'], [':productName' => $metaProductName]);
        }

        $data['meta']['ogImage'] = empty($data['product']['img'][0]) ? '' : $data['product']['img'][0];
        // meta -- end --

        // clk -- start --
        $data['clk'] = [
            'plat' => ($platform == 1) ? 'mm' : 'www',
            'id' => $data['product']['product_id'],
        ];

        switch ($data['product']['ch_id']) {
            case Config::get('channel.id.rs'):
                $data['clk']['bu'] = 'RS';
                if (Config::get('product.kindId.coffee') == $data['product']['product_kind']) {
                    $data['product']['ch_name'] = "麻吉咖啡館";
                } else {
                    $data['product']['ch_name'] = "美食餐廳";
                }
                break;

            case Config::get('channel.id.bt'):
                $data['clk']['bu'] = 'BT';
                break;

            case Config::get('channel.id.es'):
                $data['clk']['bu'] = 'ES';
                $data['product']['ch_name'] = '旅遊住宿';
                break;

            case Config::get('channel.id.lfn'):
                $data['clk']['bu'] = 'LF';
                break;

            case Config::get('channel.id.mass'):
                $data['clk']['bu'] = 'MASS';
                break;

            case Config::get('channel.id.lf'):
                $data['product']['ch_name'] = '休閒娛樂';
                break;

            case Config::get('channel.id.sh'):
                $data['clk']['bu'] = 'SH';
                break;
        }

        if (1 == $data['product']['is_paper_ticket']) {
            $data['clk']['bu'] = 'TK';
        }
        // clk --  end  --

        // 公益
        if ($rtProduct['city_id'] == Config::get('city.baseCityList.publicWelfare')) {
            $es['fixedNum'] = 0; // 定期定額份數
            //config ES_HOST
            $esUrl = sprintf('%s%s%s', 'https://510.org.tw/', 'api/product/', $productId);
            $esCurlWork = $this->apiService->curl($esUrl, 'GET', '');

            if (($esCurlWork['return_code'] == 0000) && !empty($esCurlWork['data'])) {
                $es['fixedNum'] = $esCurlWork['data']['num'];
            }

            $es['totalNum'] = $rtProduct['max_order_no']; // 最多份數
            $es['soldNum'] = $rtProduct['order_no']; // 已募集份數
            $es['achieveNum'] = $es['soldNum'] + $es['fixedNum']; // 所募集的全部份數
            $data['es'] = $es;
        } else {
            $es['totalNum'] = 0;
            $es['achieveNum'] = 0;
            $data['es'] = $es;
        }

        // 麵包穴 -- start --
        if (($data['product']['sub_channels']  == Config::get('channel.id.es') || $data['product']['sub_channels'] == Config::get('channel.id.lf')) && $data['product']['category_id'] == Config::get('product.categoryId.ticket')) {
            $data['resDetail']['sub_link'] = '/ch/' . Config::get('channel.id.es') . '?';
            $data['resDetail']['sub_name'] = '旅遊住宿';
        } else if ($data['product']['sub_channels'] == Config::get('channel.id.rs') && $data['product']['category_id'] == Config::get('product.categoryId.ticket')) {
            $data['resDetail']['sub_link'] = '/ch/' . Config::get('channel.id.rs') . '?';
            $data['resDetail']['sub_name'] = '美食餐廳';
        } else {
            $data['resDetail']['sub_link'] = '/ch/' . $data['product']['ch_id'] . '?';
            $data['resDetail']['sub_name'] = $data['product']['ch_name'];
        }

        // 日本票卷名稱group_name : 一起旅行社股份有限公司 ,(休閒娛樂 category_id = 58,麵包削要與店家頁對齊故)
        if (($data['product']['category_id'] == Config::get('product.categoryId.overseaTicket') || $data['product']['category_id'] == Config::get('product.categoryId.foreignTicket')) || ($data['product']['ch_id'] == Config::get('channel.id.lf') && $data['product']['category_id'] != Config::get('product.categoryId.casual'))) {
            if ($data['product']['ch_id'] == Config::get('channel.id.lf')) {
                $data['resDetail']['sub_child_link'] = '/store/' . $data['product']['store_id'];
            } else {
                $data['resDetail']['sub_child_link'] = '/store/' . $data['product']['store_id'];
            }
            $data['resDetail']['sub_child_name'] = $data['product']['store_page_name'];
            $data['resDetail']['sub_child_name_detail'] = $data['product']['store_name'];
        } else if ($data['product']['ch_id'] == Config::get('channel.id.sh') && $data['product']['category_id'] == Config::get('product.categoryId.ticket') || ($data['product']['ch_id'] == Config::get('channel.id.es') && $data['product']['category_id'] != Config::get('product.categoryId.travelAbroad'))) {
            // 紙本票卷, 旅遊及(國外旅遊/郵輪tag = 136)
            if (!empty($data['product']['is_paper_ticket'])) {
                $data['resDetail']['sub_child_link'] = '/store/' . $data['product']['store_id'];
            } else {
                $data['resDetail']['sub_child_link'] = '/store/' . $data['product']['store_id'];
            }
            $data['resDetail']['sub_child_name'] = $data['product']['store_page_name'];
            $data['resDetail']['sub_child_name_detail'] = $data['product']['store_name'];
        } else {
            if ($data['product']['product_kind'] != Config::get('product.kindId.coffee')) {
                if ($data['product']['ch_id'] == Config::get('channel.id.sh') && !empty($data['product']['representative_category'])) {
                    // 宅配商品於麵包屑不顯示店家名稱，顯示該產品所屬熱門類別
                    $data['resDetail']['sub_child_link'] = $data['product']['representative_category']['link'];
                    $data['resDetail']['sub_child_name'] = $data['product']['representative_category']['name'];
                    $data['resDetail']['sub_child_name_detail'] = $data['product']['store_name'];
                }
                $data['resDetail']['sub_child_link'] = !empty($data['resDetail']['sub_child_link']) ? $data['resDetail']['sub_child_link'] : '/store/' . $data['product']['store_id'];
                $data['resDetail']['sub_child_name'] = !empty($data['resDetail']['sub_child_name']) ? $data['resDetail']['sub_child_name'] : $data['product']['store_page_name'];
                $data['resDetail']['sub_child_name_detail'] = !empty($data['resDetail']['sub_child_name_detail']) ? $data['resDetail']['sub_child_name_detail'] : $data['product']['group_name'];
            } else {
                $data['resDetail']['sub_child_link'] = '/coffee/brand/' . $data['product']['group_id'];
                $data['resDetail']['sub_child_name'] = $data['product']['group_name'];
                $data['resDetail']['sub_child_name_detail'] = $data['product']['store_name'];
            }
        }
        // 麵包穴 -- end --

        // tag 標籤
        $tag_i = 0;
        foreach ($data['product']['new_pc_tag'] as $val) {
            if (!empty($data['product']['is_paper_ticket']) && $data['product']['sub_channels'] == Config::get('channel.id.rs')) {
                $data['resDetail']['tag'][$tag_i]['tag_link'] = '/ch/' . Config::get('channel.id.rs') . '?city=1&dist_group=0&category=' . $val['tag_id'];
            } else if (!empty($data['product']['is_paper_ticket'])) {
                $data['resDetail']['tag'][$tag_i]['tag_link'] = '/ch/' . Config::get('channel.id.es') . '?city=1&dist_group=0&category=' . $val['tag_id'];
            } else {
                if ($data['product']['ch_id'] == Config::get('channel.id.lf')) {
                    $tag_chid = Config::get('channel.id.lfn');
                } else {
                    $tag_chid = $data['product']['ch_id'];
                }
                $data['resDetail']['tag'][$tag_i]['tag_link'] = '/ch/' . $tag_chid . '?city=1&dist_group=0&category=' . $val['tag_id'];
            }
            $data['resDetail']['tag'][$tag_i]['tag_name'] = $val['tag_name'];
            $tag_i++;
        }

        // 判斷是否符合為二進位和數值的1
        $data['resDetail']['bitwise'] = ($data['product']['extra'] & 1) ? true : false;
        // 商品介紹的id值
        $data['resDetail']['ticket_id'] = (!empty($data['product']['is_paper_ticket'])) ? 'info' : 'package';

        // 更多商品名稱 config
        if (!empty($data['product']['is_paper_ticket'])
            || $data['product']['category_id'] == Config::get('product.categoryId.exhibitionPerformance')
            || $data['product']['city_id'] == Config::get('city.baseCityList.publicWelfare')
        ) {
            $data['resDetail']['more_product'] = '【' . $data['product']['group_name'] . '】';
        } else if ($data['product']['category_id'] == Config::get('product.categoryId.overseaTicket') || $data['product']['category_id'] == Config::get('product.categoryId.foreignTicket')) {
            $data['resDetail']['more_product'] = '【海外票券】';
        } else {
            $data['resDetail']['more_product'] = '【' . $data['product']['display_store_name'] . '】';
        }

        // 更多商品銷售 config
        $data['resDetail']['more_product_sell'] = '';
        if ($data['product']['city_id'] == Config::get('city.baseCityList.publicWelfare')) {
            $data['resDetail']['more_product_sell'] = $data['product']['order_no'] . '人響應';
        } else if ($data['product']['display_flag'] == 1) {
            $data['resDetail']['more_product_sell'] = '售' . $data['product']['order_no'] . '份';
        } else if ($data['product']['category_id'] == Config::get('product.categoryId.indoorGame')) {
            $data['resDetail']['more_product_sell'] = '剩' . $data['product']['remain_no'] . '份';
        }

        // 更多商品
        if (!empty($data['product']['other_products'])) {
            foreach ($data['product']['other_products'] as $key => $value) {
                $data['product']['other_products'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                $data['product']['other_products'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
            }
        }

        // 是否顯示現有空
        if ($data['product']['available_info']['enable'] == 1) {
            $data['resDetail']['productBoder'] = 'border-available';
            $data['resDetail']['availableType'] = 'show';
        } else {
            $data['resDetail']['productBoder'] = '';
            $data['resDetail']['availableType'] = 'hide';
        }

        // 馬上購買按鈕狀態
        $data['resDetail']['html_purchaseBox'] = '';
        $data['resDetail']['buyButtonName'] = '';
        $isPromo = isset($data['product']['is_promo'])
            && $data['product']['is_promo'] == 1
            && isset($data['product']['promo_data']['promote_type'])
            && $data['product']['promo_data']['promote_type'] == Config::get('product.promoteType.ae'); // 是否為 AE 廣告檔次
        if ($isPromo) {
            // AE 檔次
            $buttonName = $data['product']['promo_data']['promote_text'] ?? '';
            $mmButtonInfo = $data['product']['promo_data']['promote_text'] ?? '';
        } else if ($data['product']['city_id'] == Config::get('city.baseCityList.publicWelfare')) {
            // 公益檔次
            $buttonName = '立即幫助';
            $mmButtonInfo = '$' . $data["product"]["price"] . ' ' . $buttonName;
        } else {
            $buttonName = '馬上購買';
            if (!empty($data['product']['sub_products']) && count($data['product']['sub_products']) > 0) {
                $buyText = '<span>起</span> ';
            } else {
                $buyText = ' ';
            }
            $mmButtonInfo = '$' . $data["product"]["price"] . $buyText . $buttonName;
        }

        $data['resDetail']['buy_button_url'] = Config::get('setting.usagiDomain'); // 預設預覽方案跳窗「馬上購買」按鈕連結為首頁
        if ($data['product']['order_status'] == 'SUCCESS' || $data['product']['order_status'] == 'LACK' || $preview == 1) {
            if (count($data['product']['sub_products']) > 0) {
                // 多方案(預覽頁、正式頁)
                $box_info = 'data-fancybox data-src="#purchaseBox"';
                $box_href = 'javascript:void(0);';
            } else {
                // 單方案(預覽頁、正式站)
                if ($preview == 1) {
                    // 跳出方案跳窗
                    $box_info = 'data-fancybox data-src="#purchaseBox-preview"';
                    $box_href = 'javascript:void(0);';
                    // 有規格細項
                    if ($data['product']['inventory'] == 1) {
                        $data['resDetail']['buy_button_url'] = url('/checkout/pid/' . $data['product']['product_id'] . '/spid/0' . '?share_code=' . $shareCode . (!empty($data['ref']) ? '&ref=' . $data['ref'] : '') . ($preview == 1 ? '&preview=1' : ''));
                    }
                } else {
                    // 單方案(正式頁)，有規格細項
                    if ($data['product']['inventory'] == 1) {
                        $box_href = url('/checkout/pid/' . $data['product']['product_id'] . '/spid/0' . '?share_code=' . $shareCode . (!empty($data['ref']) ? '&ref=' . $data['ref'] : '') . ($preview == 1 ? '&preview=1' : ''));
                        $box_info = '';
                    } else {
                        // 單方案(正式頁)，沒有規格細項
                        $box_href = 'javascript:void(0);';
                        $box_url = $isPromo
                            ? sprintf(
                                "'%s'",
                                $data['product']['promo_data']['promote_url'] ?? ''
                            )
                            : sprintf(
                                "'https://ssl.gomaji.com/checkout-1.php?pid=%d&share_code=%s%s'",
                                $data['product']['product_id'] ?? 0,
                                $shareCode,
                                (!empty($refNum) ? '&ref=' . $refNum : '')
                            );
                        $box_info = 'onclick="linkToCheckout(' . $box_url . ')"';
                    }
                }
            }
            $data['resDetail']['html_purchaseBox'] = '<a class="btn btn-main mb-2" href="' . $box_href . '" role="button" ' . $box_info . '  rel="buy">' . $buttonName . '</a>';
            $data['resDetail']['html_purchaseBox_mm'] = '<a class="btn btn-main" ' . $box_info . ' href="' . $box_href . '" role="button">' . $mmButtonInfo . '</a>';
            $data['resDetail']['buyButtonName'] = $buttonName;
        }

        // 標題
        $data['title'] = '必吃美食餐廳優惠餐券，五星人氣餐廳超值優惠';
        // jsonld
        $data['webType'] = 'product';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Product', $data);

        // mm header “上一頁”的按鈕連結及文字
        $buAry = $this->productService->getBu($data);

        $data['goBack']['link'] = !empty($request->headers->get('referer'))
            ? 'javascript: window.history.back();'
            : sprintf('/ch/%d', $buAry['id']); // 如是頻道頁來的返回上一頁
        $data['goBack']['text'] = '逛更多';
        // 另開新視窗尚未有上一頁的歷史紀錄
        $data['goBack']['toolBarLink'] = sprintf('/ch/%d', $buAry['id']);
        // Top 按鈕增加的 class 名稱
        $data['topBtnClass'] = 'product';
        // 折扣
        $data['resDetail']['dataDiscount'] = ($data['product']['org_price'] > 0) ? (($data['product']['price'] / $data['product']['org_price']) * 100) / 10 : 0;

        // 判斷是否符合顯示價高通報(符合:true 不符合:false)
        $data['resDetail']['sub_channels_status'] = false;
        $arrSubChannels = explode(',', $data['product']['sub_channels']);
        if ((in_array(Config::get('channel.id.es'), $arrSubChannels)) || (in_array(Config::get('channel.id.lf'), $arrSubChannels))) {
            $data['resDetail']['sub_channels_status'] = true;
        }

        $data['resDetail']['platform'] = ($platform == 1) ? 'top: 4em;' : '';
        $data['resDetail']['tabScrollTop'] = ($platform == 1) ? 108 : 50; // Tab 的錨點校準數值
        // 搶購一空商品
        if ($rtProduct['order_status'] == 'END') {
            if ($data['product']['ch_id'] == Config::get('channel.id.sh') && $data['product']['is_paper_ticket'] != 0) {
                $data['resDetail']['tabScrollNum'] = ($platform == 1) ? 100 : 600; // Tab 的錨點校準增減數值
            } else {
                $data['resDetail']['tabScrollNum'] = ($platform == 1) ? 100 : 500; // Tab 的錨點校準增減數值
            }
        } else {
            $data['resDetail']['tabScrollNum'] = ($platform == 1) ? 210 : 0; // Tab 的錨點校準增減數值
        }

        // 有更多商品列表
        if (count($data['product']['other_products']) > 0) {
            $data['resDetail']['ratingList'] = ''; // 評價樣式
        } else {
            $data['resDetail']['ratingList'] = 'ratingList-marginbottom'; // 評價樣式
        }

        $data['resDetail']['displayMap'] = ($data['product']['ch_id'] == Config::get('channel.id.sh') && $data['product']['is_paper_ticket'] == 0) ? '' : 'i-map'; // 是否顯示地標icon
        $data['mmTitle'] = $data['product']['store_name'] ?? ''; // mm header 標題
        $data['isShowFooter'] = ($platform == 0); // mm 不顯示 footer
        $data['isShowMmBanner'] = $isShowMmBanner; // 是否顯示 mm banner
        $data['meta']['canonicalUrl'] = url()->current(); // 設定canonicalUrl
        $data['date'] = $date;

        return view('main.product', $data);
    }

    /**
     * 轉跳頁
     */
    public function redirect(Request $request)
    {
        // 過濾參數
        $productId = (int) htmlspecialchars(trim($request->input('pid', '')));
        if (empty($productId)) {
            $this->warningAlert('操作錯誤', '/');
        }

        // 取得檔次資訊
        $apiParam = ['product_id' => $productId];
        $apiResult = $this->apiService->curl('product-info', 'GET', $apiParam);
        if ($apiResult['return_code'] != '0000' || empty($apiResult['data'])) {
            $this->warningAlert('商品不存在', '/');
        }
        $storeId = $apiResult['data']['store_id'] ?? 0;

        // 導到欓次詳細頁
        header(sprintf('Location: /store/%s/pid/%s', $storeId, $productId));
    }

    /**
     * 預覽頁轉跳
     */
    public function preview(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), '', '', '', 'preview');

        $sid = !empty($request->input('sid', '')) ? htmlspecialchars(trim($request->input('sid', ''))) : '';

        $param = [
            'ea' => $sid,
        ];

        $rtPreview = $this->apiService->curl('preview', 'GET', $param);

        if ($rtPreview['return_code'] != 0000 || empty($rtPreview['data'])) {
            $this->warningAlert('商品不存在', '/');
        }

        $productId = $rtPreview['data']['product_id'] ?? 0;
        $storeId = $rtPreview['data']['store_id'];

        // 導到欓次詳細頁
        header(sprintf('Location: /store/%s/pid/%s?preview=1', $storeId, $productId));
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     * @param int $groupId 分店
     * @param int $storeId 店家編號
     * @param int $productId  商品id
     * @param string $type 來源(detail:非預覽頁, preview:預覽頁)
     */
    private function paramsValidation($request, $groupId = 0, $storeId = 0, $productId = 0, $type = '')
    {
        // 預覽頁
        if ($type == 'preview') {
            // 檢查的參數
            $input = [
                'sid' => $request['sid'] ?? '',
                'date' => $request['date'] ?? date('Y-m-d H:i:s'),
            ];

            // 檢查規則
            $rules = [
                'sid' => 'required',
                'date' => 'date',
            ];

            // 驗證的錯誤訊息
            $messages = [
                'sid.required' => '參數錯誤（' . Config::get('errorCode.sidEmpty') . '）',
                'date.date' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.dateDate')),
            ];
        } else {
            // 檢查的參數
            $input = [
                'productId' => $productId,
                'preview' => $request['preview'] ?? 0,
                'date' => $request['date'] ?? date('Y-m-d H:i:s'),
            ];

            // 咖啡檔次
            if (!empty($groupId)) {
                $input['groupId'] = $groupId;
            } else {
                $input['storeId'] = $storeId;
            }

            // 檢查規則
            $rules = [
                'groupId' => 'numeric',
                'storeId' => 'numeric',
                'productId' => 'required|numeric|gt:0',
                'preview' => 'numeric',
                'date' => 'date',
            ];

            // 驗證的錯誤訊息
            $messages = [
                'productId.required' => '參數錯誤（' . Config::get('errorCode.productIdEmpty') . '）',
                'productId.numeric' => '參數錯誤（' . Config::get('errorCode.productIdNumeric') . '）',
                'productId.gt' => '參數錯誤（' . Config::get('errorCode.productIdGt') . '）',
                'preview.numeric' => '參數錯誤（' . Config::get('errorCode.previewNumeric') . '）',
                'groupId.numeric' => '參數錯誤（' . Config::get('errorCode.groupIdNumeric') . '）',
                'storeId.numeric' => '參數錯誤（' . Config::get('errorCode.storeIdNumeric') . '）',
                'date.date' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.dateDate')),
            ];
        }


        $validator = Validator::make($input, $rules, $messages);

        // 驗證有出錯
        if ($validator->fails()) {
            $errors = $validator->errors(); // 驗證錯誤訊息
            $inspectParams = array_keys($input); // 檢查對象
            foreach ($inspectParams as $inspect) {
                // 該項目錯誤訊息內容不為空
                if (!empty($errors->get($inspect)[0])) {
                    $this->warningAlert($errors->get($inspect)[0], '/404');
                }
            }
        }
    }
}
