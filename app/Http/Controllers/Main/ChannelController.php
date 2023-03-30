<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\ChannelService;
use App\Services\CityService;
use App\Services\EventService;
use App\Services\JsonldService;
use App\Services\MetaService;
use App\Services\ProductService;
use Config;
use Mobile_Detect;

class ChannelController extends Controller
{
    protected $apiService;
    protected $channelService;
    protected $cityService;
    protected $eventService;
    protected $jsonldService;
    protected $metaService;
    protected $productService;

    public function __construct(
        ApiService $apiService,
        ChannelService $channelService,
        CityService $cityService,
        EventService $eventService,
        JsonldService $jsonldService,
        MetaService $metaService,
        ProductService $productService
    ) {
        $this->apiService = $apiService;
        $this->channelService = $channelService;
        $this->cityService = $cityService;
        $this->eventService = $eventService;
        $this->jsonldService = $jsonldService;
        $this->metaService = $metaService;
        $this->productService = $productService;
    }

    /**
     * 頻道頁
     */
    public function __invoke(Request $request, $ch)
    {
        // 如果 $ch 是字串，為 /channel/restaurant 等舊稱
        // 如果不在 switch case 裡面，以字串狀態去下面進行參數驗證導錯
        if (is_string($ch)) {
            switch ($ch) {
                case 'restaurant':
                    $ch = Config::get('channel.id.rs');
                    break;
                case 'beauty':
                    $ch = Config::get('channel.id.bt');
                    break;
                case 'travel':
                    $ch = Config::get('channel.id.es');
                    break;
                case 'shipping':
                    $ch = Config::get('channel.id.sh');
                    break;
                case 'qk':
                    $ch = Config::get('channel.id.qk');
                    break;
                case 'massage':
                    $ch = Config::get('channel.id.mass');
                    break;
                case 'life':
                    $ch = Config::get('channel.id.lfn');
                    break;
            }
        }

        // 參數驗證
        $this->paramsValidation($request->all(), $ch);

        // 城市、地區
        if ($ch != Config::get('channel.id.sh') && floor($ch / 100000) != Config::get('channel.id.sh')) {
            $city = ($ch == Config('channel.id.es') || floor($ch / 100000) == Config::get('channel.id.es'))
                ? $this->cityService->getCityValue($request, 'es_city', 'city', 0)
                : $this->cityService->getCityValue($request, 'city', 'city', 1);
        } else {
            // 若為宅配頻道，$city == 全國地區
            $city = Config::get('city.baseCityList.taiwan');
        }

        $distGroup = $this->cityService->getCityValue($request, 'dist_group', 'dist_group', 0);
        $region = $this->cityService->getCityValue($request, 'es_region', 'region', 0);
        $spot = $this->cityService->getCityValue($request, 'es_spot', 'spot', 0);
        $cityData = $this->cityService->getCityData($ch, $city, $distGroup, $region, $spot); // 取得城市資訊
        $this->cityService->checkCityValue($ch, $cityData['cityList'], $city, $distGroup, $region, $spot); // 檢查城市相關參數的內容值
        $date = htmlspecialchars(trim($request->input('date', date('Y-m-d H:i:s'))));

        // 如果 $ch > 100000，為 7000015 吃到飽、7000012 火鍋 等等的熱門類別頁面
        $locationInfo = [
            'city' => $city,
            'distGroup' => $distGroup,
            'region' => $region,
            'spot' => $spot,
        ];
        if ($ch > 100000 && !isset($_GET['category'])) {
            $categoryId = $ch - (floor($ch / 100000) * 100000);
            $ch = floor($ch / 100000);
            $canonicalRefactor = $this->channelService->cannonicalUrlRefactor($ch, $categoryId, $locationInfo, 0);
        } else {
            $categoryId = empty($_GET['category']) ? 0 : htmlspecialchars(strip_tags($_GET['category']), ENT_QUOTES);
            if ($categoryId == 0) {
                $canonicalRefactor = $this->channelService->cannonicalUrlRefactor($ch, $categoryId, $locationInfo, 0); // 頻道首頁
            } else {
                $canonicalRefactor = $this->channelService->cannonicalUrlRefactor($ch, $categoryId, $locationInfo, 1); // /ch/7?category=15
            }
        }

        // 錯誤的頻道編號，頁面導至404
        if (!in_array($ch, Config::get('channel.channelList'))) {
            $this->warningAlert('操作錯誤', '/404');
            exit;
        }

        // 判斷返利網來的是否要阻擋進入此頁面
        $disablecChList = Config::get('ref.disablecCh');
        $ref = $_COOKIE['gmc_site_pay'] ?? '';
        $refName = Config::get('ref.name.' . $ref) ?? '';

        if (!empty($ref) && isset($disablecChList[$ref]) && in_array($ch, $disablecChList[$ref])) {
            $this->warningAlert('此頻道商品不適用「' . $refName . '現金」回饋，如要購買建議您下載GOMAJI如要購買建議您下載GOMAJI APP。', '/');
        }

        $sort = empty($_GET['sort']) ? 0 : htmlspecialchars(strip_tags($_GET['sort']), ENT_QUOTES);
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);

        // 活動
        $biId = empty($_GET['bi_id']) ? 0 : htmlspecialchars(strip_tags($_GET['bi_id']), ENT_QUOTES);
        $eventId = empty($_GET['event_id']) ? 0 : htmlspecialchars(strip_tags($_GET['event_id']), ENT_QUOTES);

        $biId = intval($biId);
        $city = intval($city);
        $categoryId = intval($categoryId);
        $page = intval($page);
        if ($page < 1) {
            $page = 1;
        }

        if ($page == 1) {
            $data = $this->defaultPageParam();
            $data['meta']['canonicalUrl'] = $canonicalRefactor;
        } else {
            $data = $this->defaultPageParam(false);
        }

        if ($ch == 2) {
            $patterns = $this->channelService->getRegionPattern();
            $pattern1 = sprintf('region=%s&city=%s&spot=%s', $region, $city, $spot);
            if (!in_array($pattern1, $patterns)) {
                $spot = 0;

                $pattern2 = sprintf('region=%s&city=%s', $region, $city);
                if (!in_array($pattern2, $patterns)) {
                    $city = 0;

                    $pattern3 = sprintf('region=%s', $region);
                    if (!in_array($pattern3, $patterns)) {
                        $region = 0;
                    }
                }
            }
        }

        // PC or Mobile 判斷
        $platform = 0;
        $detect = new Mobile_Detect();
        if ($detect->isMobile() && !$detect->isTablet()) {
            $platform = 1;
        }

        // 商品Block -- start --
        $defaultPage = $_COOKIE['default_page'] ?? 1; // 預設要載入的頁數
        $initCount = ($page > 1) ? $page : 1;
        $limitCount = ($page > 1) ? $page : $defaultPage;
        $data['products'] = [];

        $_COOKIE['default_page'] = null;
        setcookie('default_page', '', time() - 3600, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));

        for ($i = $initCount; $i <= $limitCount; $i++) {
            $curlParam = [
                'ch_id' => $ch,
                'cat_id' => $categoryId,
                'sort_id' => $sort,
                'page' => $i,
                'plat' => $platform,
            ];

            if ($ch == Config::get('channel.id.es')) {
                if (empty($city)) {
                    $curlParam['region_id'] = $region;
                } else {
                    $curlParam['dist_group_id'] = $city;
                    $curlParam['spot_id'] = $spot;
                    $curlParam['city_id'] = $region;
                }
            } else {
                $curlParam['city_id'] = $city;
                $curlParam['dist_group_id'] = $distGroup;
            }

            $productsArray = $this->apiService->curl('product-list', 'GET', $curlParam); // apiService

            if ($productsArray['return_code'] == 0000 && !empty($productsArray['data']['product'])) {
                $data['products'] = array_merge($data['products'], $productsArray['data']['product']); // 商品資料主要陣列塞入$data
            }
        }

        $promoAfterCount = 0; // special block位置的前置設定
        $promoIndex = -1; // special block位置的前置設定
        $promoList = [];

        if (!empty($data['products'])) {
            $ts = time();
            foreach ($data['products'] as $key => $value) {
                // 評價為整數時，加上小數點0
                if (strpos($value['store_rating_score'], '.') === false) {
                    $value['store_rating_score'] .= '.0';
                }

                // 因應視圖的評價分數大小，將字體拆分
                $data['products'][$key]['store_rating_int'] = floor($value['store_rating_score']);
                $data['products'][$key]['store_rating_dot'] = substr(strval($value['store_rating_score']), -2);

                // 販售期限/倒數
                $data['products'][$key]['until_ts'] = 0;
                if ($value['tk_type'] == 1 && !empty($value['expiry_date'])) {
                    $data['products'][$key]['until_ts'] = strtotime($value['expiry_date']) - $ts;
                }

                // 價格
                $data['products'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE);
                $data['products'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE);

                // 檔次連結網址
                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);

                // 如果promo_data有內容 => 廣告海報
                if (!empty($value['promo_data']) && 4 == $value['product_kind']) {
                    $data['products'][$key]['link'] = $this->productService->getBannerLink($value['promo_data']);
                    // 如果promo_list有內容 => 特別企劃
                } elseif (!empty($value['promo_list']) && 5 == $value['product_kind']) {
                    $promoIndex = $key;
                    $promoList = $value;
                } elseif (-1 == $promoIndex && 7 == $value['product_kind']) {
                    $promoAfterCount = count($value['today_special_list']);
                    if (empty($promoAfterCount)) {
                        $promoAfterCount = -1;
                    }
                }
            }
        }
        // 特別企劃，將位置固定在第9個品項，讓前面檔次可以排滿
        if ($promoIndex != -1) {
            unset($data['products'][$promoIndex]);
            $data['products'] = array_values($data['products']);

            $newIndex = (count($data['products']) < 8) ? count($data['products']) : 8;
            $newIndex = $newIndex - $promoAfterCount;
            $data['products'] = array_merge(
                array_slice($data['products'], 0, $newIndex),
                array($promoList),
                array_slice($data['products'], $newIndex)
            );
        }

        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0; // 總頁數
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0; // 總商品數
        $data['page'] = $page;

        // Loading More
        if ($page != 1) {
            $html = '';
            if ($productsArray['return_code'] == 0000 && !empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html,
            );

            exit(json_encode($result));
        }
        // 商品Block -- end --

        // Category分類按鈕 --- 開 始 ---
        $curlParam = array('ch_id' => $ch);
        $categoriesArray = $this->apiService->curl('category-list', 'GET', $curlParam); // apiService

        // 設定類別連結網址
        $data['categories'] = [];
        $data['subChTitle'] = '';
        if (!empty($categoriesArray) && $categoriesArray['return_code'] == 0000 && !empty($categoriesArray['data'])) {
            foreach ($categoriesArray['data'] as $key => $value) {
                $categoriesArray['data'][$key]['link'] = $this->channelService->getCategoryLink($value, $city, $distGroup, $region, $spot);
            }
            $data['categories'] = $categoriesArray['data'] ?? []; // 類別按鈕資料
            $data['subChTitle'] = ($categoryId == 0) ? '' : $this->channelService->getSubChTitle($categoryId, $data['categories']); // 麵包屑副標題
        }
        // Category分類按鈕 --- 結 束 ---

        // Banner區塊 --- 開 始 ---
        $curlParam = array(
            'ch_id' => $ch,
            'city_id' => $city,
            'type' => 2,
        );
        $bannersArray = $this->apiService->curl('banner-list', 'GET', $curlParam); // apiService
        if ($bannersArray['return_code'] == 0000) {
            if (!empty($bannersArray['data']['banners'])) {
                $data['banners'] = $bannersArray['data']['banners']; // 左側banner
                foreach ($data['banners'] as $key => $value) {
                    $data['banners'][$key]['link'] = $this->productService->getBannerLink($value);
                }
            }
            if (!empty($bannersArray['data']['second_banner'])) {
                $data['second_banner'] = $bannersArray['data']['second_banner']; // 右上banner
                foreach ($data['second_banner'] as $key => $value) {
                    $data['second_banner'][$key]['link'] = $this->productService->getBannerLink($value);
                }
            }
            if (!empty($bannersArray['data']['third_banner'])) {
                $data['third_banner'] = $bannersArray['data']['third_banner']; // 右下banner
                foreach ($data['third_banner'] as $key => $value) {
                    $data['third_banner'][$key]['link'] = $this->productService->getBannerLink($value);
                }
            }
            // 浮水印
            if (!empty($bannersArray['data']['activity_ad'])) {
                $data['activityAd'] = $bannersArray['data']['activity_ad'];
            }
        }
        // Banner區塊 --- 結 束 ---

        // 推薦專區 --- 開 始 ---
        if (0 == $categoryId) {
            // 只有全部分類需要顯示
            $curlParam = [
                'ch_id' => $ch,
                'city_id' => $city,
                'dist_group_id' => $distGroup,
                'region_id' => $region,
            ];

            $commendArray = $this->apiService->curl('channel-recommend', 'GET', $curlParam); // apiService
            if (!empty($commendArray) && $commendArray['return_code'] == 0000 && !empty($commendArray['data'])) {
                $data['rsBrand'] = $commendArray['data']['rsBrand'] ?? []; // RS
                $data['flashSale'] = $commendArray['data']['flashSale'] ?? []; // RS
                $data['firstOpen'] = $commendArray['data']['firstOpen'] ?? []; // RS
                $data['drinks'] = $commendArray['data']['drinks'] ?? []; // RS
                $data['esSpecial'] = $commendArray['data']['esSpecial'] ?? []; // ES
                $data['esHotCat'] = $commendArray['data']['esHotCat'] ?? []; // ES
                $data['btFlashSale'] = $commendArray['data']['btFlashSale'] ?? []; // BT
                $data['btChainStore'] = $commendArray['data']['btChainStore'] ?? []; // BT
                $data['shSpecial'] = $commendArray['data']['shSpecial'] ?? []; // SH 名店美食
                $data['shBrand'] = $commendArray['data']['shBrand'] ?? []; // SH 名店美食
                $data['shHotCat'] = $commendArray['data']['shHotCat'] ?? []; // SH 熱銷類別

                if (!empty($data['flashSale']['product'])) {
                    $ts = time();
                    foreach ($data['flashSale']['product'] as $key => $value) {
                        // 販售期限/倒數
                        $data['flashSale']['product'][$key]['until_ts'] = 0;
                        if ($value['tk_type'] == 1 && !empty($value['expiry_date'])) {
                            $data['flashSale']['product'][$key]['until_ts'] = strtotime($value['expiry_date']) - $ts;
                        }
                        $data['flashSale']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['flashSale']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['flashSale']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['flashSale']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                if (!empty($data['firstOpen']['product'])) {
                    foreach ($data['firstOpen']['product'] as $key => $value) {
                        $data['firstOpen']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['firstOpen']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['firstOpen']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['firstOpen']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                if (!empty($data['drinks']['product'])) {
                    foreach ($data['drinks']['product'] as $key => $value) {
                        $data['drinks']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['drinks']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['drinks']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['drinks']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                if (!empty($data['esSpecial']['product'])) {
                    foreach ($data['esSpecial']['product'] as $key => $value) {
                        $data['esSpecial']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['esSpecial']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['esSpecial']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['esSpecial']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                if (!empty($data['esHotCat']['category'])) {
                    foreach ($data['esHotCat']['category'] as $key => $value) {
                        $data['esHotCat']['category'][$key]['link'] = $this->channelService->getCategoryLink($value, $city, 0, $region, $spot);
                        $data['esHotCat']['category'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['esHotCat']['category'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['esHotCat']['category'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                if (!empty($data['btFlashSale']['product'])) {
                    $ts = time();
                    foreach ($data['btFlashSale']['product'] as $key => $value) {
                        // 販售期限/倒數
                        $data['btFlashSale']['product'][$key]['until_ts'] = 0;
                        if ($value['tk_type'] == 1 && !empty($value['expiry_date'])) {
                            $data['btFlashSale']['product'][$key]['until_ts'] = strtotime($value['expiry_date']) - $ts;
                        }
                        $data['btFlashSale']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['btFlashSale']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['btFlashSale']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['btFlashSale']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                if (!empty($data['btChainStore']['product'])) {
                    foreach ($data['btChainStore']['product'] as $key => $value) {
                        $data['btChainStore']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['btChainStore']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['btChainStore']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['btChainStore']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                // SH 限時優惠
                if (!empty($data['shSpecial']['product'])) {
                    foreach ($data['shSpecial']['product'] as $key => $value) {
                        $data['shSpecial']['product'][$key]['link'] = $this->productService->getProductLink($value);
                        $data['shSpecial']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
                        $data['shSpecial']['product'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                        $data['shSpecial']['product'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
                    }
                }

                // SH 熱銷類別
                if (!empty($data['shHotCat']['category'])) {
                    foreach ($data['shHotCat']['category'] as $key => $value) {
                        $data['shHotCat']['category'][$key]['link'] = $this->channelService->getCategoryLink($value, $city, $distGroup);
                    }
                }
            }
        }
        // 推薦專區 --- 結 束 ---

        // 主打星 block -- start --
        $curlParam = array(
            'ch_id' => $ch,
            'city_id' => $city,
            'type' => 2,
        );

        $flagshipArray = $this->apiService->curl('flagship-product', 'GET', $curlParam); // apiService

        if (isset($flagshipArray['return_code']) && $flagshipArray['return_code'] == 0000 && !empty($flagshipArray['data']['popup_ad'])) {
            $data['popupAdStyle'] = 'display: block;'; // 預設主打星檔次顯示
            $data['popupAd'] = $flagshipArray['data']['popup_ad'];
            foreach ($data['popupAd']['products'] as $key => $val) {
                $data['popupAd']['product'][$key]['micro_order_status'] = $this->productService->getProductStatus($val); // 銷售狀態
            }
            $data['popupAd']['display'] = $this->channelService->popupAd($ch, $city, $data['popupAd']); // 主打星是否顯示
            // 主打星為兩個檔次時
            if ($data['popupAd']['display'] == false && !empty($bannersArray['data']['activity_ad']['action']) && $bannersArray['data']['activity_ad']['action'] == 'flagship-product') {
                $data['popupAdStyle'] = 'display: none;'; // 隱藏主打星跳窗顯示
                $data['popupAd']['display'] = true; // 產主打星跳窗資訊
            }
        } else {
            $data['popupAd']['display'] = false; // 代表['popup_ad']內容為空
        }
        // 主打星 block -- end --

        // meta -- start --
        $storeNameAry = array_values(array_filter(array_unique(array_column($data['products'], 'store_name')))); // 重新排序 key、過濾空值、過濾重複值
        $metaBindAry = [
            ':cityName' => $cityData['activeName'] ?? '',
            ':storeName1' => $storeNameAry[0] ?? '',
            ':storeName2' => $storeNameAry[1] ?? '',
            ':storeName3' => $storeNameAry[2] ?? '',
        ];

        $channelNameAry = array_flip(Config::get('channel.id')); // 頻道名稱對應表（id => 英文名稱）
        $channelName = $channelNameAry[$ch] ?? ''; // 頻道的英文名稱
        $configMetaName = sprintf('meta.%s', $channelName);
        $configMetaData = Config::get($configMetaName, Config::get('meta.rs')); // 頻道的 config meta 資訊
        $configMetaCatData = $configMetaData[$categoryId] ?? $configMetaData['default'] ?? []; // 類別的 config meta 資訊
        $metaTitle = $configMetaCatData['title'] ?? '';
        $metaDescription = $configMetaCatData['description'] ?? '';
        $metaOgImage = $configMetaCatData['ogImage'] ?? '';

        $data['meta']['title'] = $this->metaService->bindValue($metaTitle, $metaBindAry);
        $data['meta']['description'] = $this->metaService->bindValue($metaDescription, $metaBindAry);
        $data['meta']['ogImage'] = $metaOgImage;
        $data['meta']['keywords'] = $configMetaData['keywords'] ?? '';
        // meta -- end --

        // clk --- 開 始 ---
        $bu = ($ch != Config::get('channel.id.lfn')) ? strtoupper($channelName) : 'LF';
        $data['clk'] = [
            'plat' => ($platform == 1) ? 'mm' : 'www',
            'bu' => $bu,
            'cityEn' => Config::get("city.baseCityEngList.$city") ?? '',
        ];

        if (in_array($ch, [Config::get('channel.id.rs'), Config::get('channel.id.bt'), Config::get('channel.id.mass')])) {
            $data['clk']['tag'] = $categoryId;
        } else {
            $data['clk']['category'] = $categoryId;
        }
        // clk --- 結 束 ---

        $data['ch'] = $ch;
        $data['city'] = $city;
        $data['sort'] = $sort;
        $data['distGroup'] = $distGroup;
        $data['categoryId'] = $categoryId;
        $data['region'] = $region;
        $data['defaultPage'] = $defaultPage; // 預設載入的頁數
        $data['platform'] = $platform;
        $flagShipBlock = ($platform == 1) ? 'w-50' : 'w-100';
        $data['flagShipBlock'] = (!empty($data['activityAd']['action']) && $data['activityAd']['action'] == 'flagship-product') ? '' : $flagShipBlock; // 兩個主打星不加入樣式、一個主打星依據平台狀態加入樣式
        $data['theme'] = $this->eventService->getEventTheme($date);
        $data['sortList'] = ['推薦排序', '評價高至低', '價格低至高', '價格高至低'];
        $data['sortUrl'] = sprintf('/ch/%s?category=%s&city=%s&page=%s', $ch, $categoryId, $city, $page); // 排序方式連結
        $data['chTitleUrl'] = sprintf('/ch/%s?city=%s', $ch, $city); // 麵包屑頻道頁連結

        $data['chTitle'] = Config::get(sprintf('channel.chName.%d', $ch), ''); // 頻道列表標題
        $data['loadMoreUrl'] = sprintf('/%s?category=%s&city=%s&sort=%s&spot=%s&region=%s&dist_group=%s&page=', $ch, $categoryId, $city, $sort, $spot, $region, $distGroup); // 分頁連結

        // jsonld
        $data['webType'] = 'channel';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Channel', $data);

        $data['cityData'] = $cityData; // 城市列表
        $data['cityData']['activeName'] .= ($platform == 1) ? sprintf(' %s', $data['chTitle']) : ''; // mm 時，目前的城市名稱後面加上頻道名稱
        if ($ch == Config::get('channel.id.sh')) {
            unset($data['cityData']); // 若為「宅配頻道」不顯示城市下拉選單
            $data['mmTitle'] = Config::get('channel.homeList.' . $ch . '.title');
        }

        return view('main.channel', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     * @param int $ch 頻道類別
     */
    private function paramsValidation($request, $ch = 0)
    {
        // 檢查的參數
        $input = [
            'ch_id' => $ch ?? 0,
            'cat_id' => $request['category'] ?? 0,
            'sort_id' => $request['sort'] ?? 0,
            'page' => $request['page'] ?? 1,
            'city_id' => $request['city'] ?? 0,
            'dist_group_id' => $request['dist_group'] ?? 0,
            'region_id' => $request['region'] ?? 0,
            'spot_id' => $request['spot'] ?? 0,
            'date' => $request['date'] ?? date('Y-m-d H:i:s'),
        ];

        // 檢查規則
        $rules = [
            'ch_id' => 'required|numeric|gt:0',
            'cat_id' => 'numeric',
            'sort_id' => 'numeric',
            'page' => 'numeric',
            'city_id' => 'numeric',
            'dist_group_id' => 'numeric',
            'region_id' => 'numeric',
            'spot_id' => 'numeric',
            'date' => 'date',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'ch_id.required' => '參數錯誤（' . Config::get('errorCode.channelIdEmpty') . '）',
            'ch_id.numeric' => '參數錯誤（' . Config::get('errorCode.channelIdNumeric') . '）',
            'ch_id.gt' => '參數錯誤（' . Config::get('errorCode.channelIdGt') . '）',
            'cat_id.numeric' => '參數錯誤（' . Config::get('errorCode.categoryIdNumeric') . '）',
            'sort_id.numeric' => '參數錯誤（' . Config::get('errorCode.sortIdNumeric') . '）',
            'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
            'city_id.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
            'dist_group_id.numeric' => '參數錯誤（' . Config::get('errorCode.distGroupIdNumeric') . '）',
            'region_id.numeric' => '參數錯誤（' . Config::get('errorCode.regionIdNumeric') . '）',
            'spot_id.numeric' => '參數錯誤（' . Config::get('errorCode.spotIdNumeric') . '）',
            'date.date' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.dateDate')),
        ];

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
