<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\ChannelService;
use App\Services\CityService;
use App\Services\MetaService;
use App\Services\JsonldService;
use App\Services\ProductService;
use Config;

class ProductListController extends Controller
{
    protected $apiService;
    protected $channelService;
    protected $cityService;
    protected $metaService;
    protected $jsonldService;
    protected $productService;

    public function __construct(ApiService $apiService, ChannelService $channelService, CityService $cityService, MetaService $metaService, JsonldService $jsonldService, ProductService $productService)
    {
        $this->apiService = $apiService;
        $this->channelService = $channelService;
        $this->cityService = $cityService;
        $this->metaService = $metaService;
        $this->jsonldService = $jsonldService;
        $this->productService = $productService;
    }

    /**
     * 活動頁event & 主題頁category
     */
    public function __invoke(Request $request, $categoryId = 0)
    {
        // 參數驗證
        if ($categoryId == 0) {
            $this->paramsValidation($request->all(), 0, 'eventList');
        } else {
            $this->paramsValidation($request->all(), $request->route('categoryId'), 'category');
        }

        $data = $this->defaultPageParam();

        if (isset($_GET['channel_id'])) {
            $ch = empty($_GET['channel_id']) ? 1 : htmlspecialchars(strip_tags($_GET['channel_id']), ENT_QUOTES);
        } else {
            $ch = empty($_GET['ch_id']) ? 1 : htmlspecialchars(strip_tags($_GET['ch_id']), ENT_QUOTES);
        }
        $biId = empty($_GET['bi_id']) ? 0 : htmlspecialchars(strip_tags($_GET['bi_id']), ENT_QUOTES);
        $city = empty($_GET['city_id']) ? 0 : htmlspecialchars(strip_tags($_GET['city_id']), ENT_QUOTES);
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        $event_id = empty($_GET['event_id']) ? 0 : htmlspecialchars(strip_tags($_GET['event_id']), ENT_QUOTES);

        $ch = intval($ch);
        $city = intval($city);
        $page = intval($page);
        $event_id = intval($event_id);
        if ($page < 1) {
            $page = 1;
        }

        if ($event_id == 0) {
            $api = 'product-list';
            $curlParam = [
                'ch_id' => $ch,
                'city_id' => $city,
                'cat_id'  => $categoryId,
                'sort_id' => 0,
                'page' => $page,
                'bi_id' => $biId,
            ];
        } else {
            $api = 'event_list';
            $curlParam = [
                'channel_id' => $ch,
                'city_id' => $city,
                'event_id' => $event_id,
                'bi_id' => $biId,
            ];
        }

        $data['products'] = [];
        $productsArray = $this->apiService->curl($api, 'GET', $curlParam); // apiService
        if (!empty($productsArray) && $productsArray['return_code'] == 0000) {
            $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data
        }

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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);
            }
        }

        $data['ch'] = $ch;
        $data['bi_id'] = $biId;
        $data['city'] = $city;
        $data['category'] = $categoryId;
        $data['title'] = $productsArray['data']['title_name'] ?? '';
        $data['chTitle'] = (array_key_exists($data['ch'], Config::get('channel.homeList')))
            ? Config::get('channel.homeList.' . $data['ch'] . '.title')
            : Config::get('channel.homeList.' . Config::get('channel.id.rs') . '.title');
        $data['chTitleUrl'] =  (array_key_exists($data['ch'], Config::get('channel.homeList')))
            ? Config::get('channel.homeList.' . $data['ch'] . '.url')
            : Config::get('channel.homeList.' . Config::get('channel.id.rs') . '.url');
        $data['subChTitle'] = $productsArray['data']['title_name'] ?? '';
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 1;
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 1;
        $data['loadMoreUrl'] = ($event_id == 0)
            ? sprintf('/category/%s?ch_id=%s&city_id=%s&bi_id=%s&page=', $categoryId, $ch, $city, $biId) // 主題檔次頁
            : sprintf('/event_list?channel_id=%s&city_id=%s&bi_id=%s&event_id=%s&page=', $ch, $city, $biId, $event_id); // 活動檔次頁
        $data['mmTitle'] = $productsArray['data']['title_name'] ?? ''; // mm header 標題

        // jsonld
        $data['webType'] = 'category';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Category', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }

        return view('listing.productList', $data);
    }

    /**
     * 特別企劃special & 排行搒top
     */
    public function special(Request $request, $id = 0)
    {
        // 參數驗證
        if ($id < 100) {
            $this->paramsValidation($request->all(), $request->route('id'), 'top');
        } elseif ($id > 500) {
            $this->paramsValidation($request->all(), $request->route('id'), 'special');
        }

        $data = $this->defaultPageParam();

        // 查詢參數設定 --- 開 始 ---
        $city = empty($_GET['city']) ? 1 : htmlspecialchars(strip_tags($_GET['city']), ENT_QUOTES);
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);

        $city = intval($city);
        $page = intval($page);
        if ($page < 1) {
            $page = 1;
        }

        $type = 0;
        if ($id < 100) {
            $type = 2; // 排行榜top
        } elseif ($id > 500) {
            $type = 1; // 特別企劃special
        }

        $curlParam = array(
            'type' => $type ?? '',
            'id' => $id,
            'city_id' => $city,
            'page' => $page,
        );
        // 查詢參數設定 --- 結 束 ---

        $pageSize = 20;
        $productsArray = $this->apiService->curl('home-learderboard-detail', 'GET', $curlParam); // apiService

        $storeInfoAry = []; // 店家資訊，放置店家名稱＆價格 for SEO description
        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

        if (!empty($data['products'])) {
            $ts = time();
            $index = 0;
            $si = ($productsArray['data']['product_cur_page'] - 1) * $pageSize;

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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);

                if (2 == $type) {
                    $data['products'][$key]['rank'] = (++$si);
                }

                // 過濾重複店家，家店僅收錄第一個出現的價格
                if (!empty($value['store_name']) && !empty($value['price']) && !in_array($value['store_name'], array_column($storeInfoAry, 'name'))) {
                    $storeInfoAry[] = [
                        'name' => $value['store_name'], // 記錄店家，有重複就不再寫入
                        'nameAndPrice' => sprintf('%s %s元', $value['store_name'], $value['price']), // SEO description 顯示店家名稱&價格
                    ];
                }
            }
        }

        $data['city'] = $city;
        $data['page'] = $page;
        $data['title'] = $productsArray['data']['banner_title'] ?? '';
        $data['noHotBage'] = 1;
        $data['chTitle'] = ($type == 1) ? '特別企劃' : '排行榜';
        $data['chTitleUrl'] = ($type == 1) ? '/special' : '/top';
        $data['subChTitle'] = $productsArray['data']['banner_title'] ?? '';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = ($type == 1) ? sprintf('/special/%s?city=%s&page=', $id, $city) : sprintf('/top/%s?city=%s&page=', $id, $city);
        $data['mmTitle'] = $productsArray['data']['banner_title'] ?? ''; // mm header 標題

        $metaBindAry = [
            ':subChTitle' => $data['subChTitle'],
            ':storeName1' => $storeInfoAry[0]['nameAndPrice'] ?? '',
            ':storeName2' => $storeInfoAry[1]['nameAndPrice'] ?? '',
            ':storeName3' => $storeInfoAry[2]['nameAndPrice'] ?? '',
        ];

        if ($id < 100) {
            $metaTitle = Config::get('meta.top.list.title');
            $metaDescription = Config::get('meta.top.list.description');
            $data['meta']['title'] = $this->metaService->bindValue($metaTitle, $metaBindAry) ?? '';
            $data['meta']['description'] = $this->metaService->bindValue($metaDescription, $metaBindAry) ?? '';
            $data['meta']['canonicalUrl'] = url()->current(); // 設定排行榜canonicalUrl
        } elseif ($id > 500) {
            $metaTitle = Config::get('meta.special.list.title');
            $data['meta']['title'] = $this->metaService->bindValue($metaTitle, $metaBindAry) ?? '';
            $data['meta']['canonicalUrl'] = sprintf('%s?city=%d', url()->current(), $city); // 設定特別企劃canonicalUrl
        }

        // jsonld
        $data['webType'] = 'special';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Special', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }

        return view('listing.productList', $data);
    }

    /**
     * 公益510
     */
    public function publicWelfare()
    {
        $data = $this->defaultPageParam();

        $curlParam = array(
            'ch_id' => 7,
            'city_id' => 19,
            'cat_id'  => 125,
        );

        $productsArray = $this->apiService->curl('product-list', 'GET', $curlParam); // apiService

        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

        if (!empty($data['products'])) {
            $ts = time();
            foreach ($data['products'] as $key => $value) {
                if ($value['product_kind'] != 1) {
                    unset($data['products'][$key]);
                    continue;
                }

                if (!empty($value['promo_data']) && 4 == $value['product_kind']) {
                    $data['products'][$key]['link'] = $this->productService->getBannerLink($value['promo_data']);
                } else {
                    $data['products'][$key]['link'] = $this->productService->getProductLink($value);
                }

                $data['products'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);
            }
        }

        $data['ch'] = 7;
        $data['city'] = 19;
        $data['title'] = '100元做公益';
        $data['chTitle'] = '100元做公益';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = '';
        $data['mmTitle'] = '100元做公益'; // mm header 標題

        // meta -- start --
        $data['meta']['title'] = Config::get('meta.publicWelfare.title');
        $data['meta']['description'] = Config::get('meta.publicWelfare.description');
        $data['meta']['keywords'] = Config::get('meta.publicWelfare.keywords');
        $data['meta']['canonicalUrl'] = url()->current();
        // meta -- end --

        // jsonld
        $data['webType'] = '510';
        $data['jsonld'] = $this->jsonldService->getJsonldData('510', $data);

        return view('listing.productList', $data);
    }

    /**
     * 宅配生鮮
     */
    public function esForeign()
    {
        $data = $this->defaultPageParam();

        $city = empty($_GET['city']) ? 1 : htmlspecialchars(strip_tags($_GET['city']), ENT_QUOTES);
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        $page = intval($page);
        if ($page < 1) {
            $page = 1;
        }

        $curlParam = array(
            'type' => 1,
            'page' => $page,
            'city_id' => $city
        );

        $productsArray = $this->apiService->curl('es-recommend-foreign', 'GET', $curlParam); // apiService

        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);
            }
        }

        $data['ch'] = 0;
        $data['page'] = $page;
        $data['city'] = $city;
        $data['title'] = $productsArray['data']['title_name'] ?? '';
        $data['chTitle'] = $productsArray['data']['title_name'] ?? '';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = '';
        $data['mmTitle'] = $productsArray['data']['title_name'] ?? ''; // mm header 標題
        // meta -- start --
        $data['meta']['title'] = Config::get('meta.esForeign.title');
        $data['meta']['description'] = Config::get('meta.esForeign.description');
        $data['meta']['keywords'] = Config::get('meta.esForeign.keywords');
        $data['meta']['canonicalUrl'] = url()->current();
        // meta -- end --

        // jsonld
        $data['webType'] = 'esForeign';
        $data['jsonld'] = $this->jsonldService->getJsonldData('EsForeign', $data);

        return view('listing.productList', $data);
    }

    /**
     * RS頻道 限時優惠、首次開賣、喝飲料
     */
    public function rsSpecial(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), 0, 'chSpecial');

        $data = $this->defaultPageParam();

        // 城市、地區
        $distGroup = $this->cityService->getCityValue($request, 'dist_group', 'dist_group', 0);
        $city = $this->cityService->getCityValue($request, 'city', 'city', 1);
        $cityData = $this->cityService->getCityData(Config::get('channel.id.rs'), $city, $distGroup); // 取得城市資訊
        $this->cityService->checkCityValue(Config::get('channel.id.rs'), $cityData['cityList'], $city, $distGroup); // 檢查城市相關參數的內容值

        // 分頁
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        $page = intval($page);
        if ($page < 1) {
            $page = 1;
        }

        $type = 0;
        $urlInfo = parse_url($_SERVER['REQUEST_URI']);
        $urlPath = substr($urlInfo['path'], 1);
        $data['urlPath'] = $urlPath;
        $configMetaType = '';
        switch ($urlPath) {
            case 'flash_sale':
                $type = 1;
                $configMetaType = 'rsFlashSale';
                break;
            case 'new_open':
                $type = 2;
                $configMetaType = 'rsNewOpen';
                break;
            case 'drinks':
                $type = 7;
                $configMetaType = 'rsDrinks';
                break;
        }

        $curlParam = array(
            'type' => $type,
            'city_id' => $city,
            'page' => $page,
        );

        $pageSize = 20;
        $productsArray = $this->apiService->curl('rs-recommend-special', 'GET', $curlParam); // apiService

        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

        if (!empty($data['products'])) {
            $ts = time();
            $index = 0;
            $si = ($productsArray['data']['product_cur_page'] - 1) * $pageSize;

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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);

                if (2 == $type) {
                    $data['products'][$key]['rank'] = (++$si);
                }
            }
        }

        $data['ch'] = Config::get('channel.id.rs');
        $data['page'] = $page;
        $data['city'] = $city;
        $data['title'] = $productsArray['data']['title_name'] ?? '';
        $data['noHotBage'] = 1;
        $data['goBack']['text'] = '逛更多'; // MM的回上一頁
        $data['goBack']['link'] = Config::get('channel.homeList.' . $data['ch'] . '.url'); // MM的回上一頁
        $data['chTitle'] = Config::get('channel.homeList.' . $data['ch'] . '.title');
        $data['chTitleUrl'] = Config::get('channel.homeList.' . $data['ch'] . '.url');
        $data['subChTitle'] = $productsArray['data']['title_name'] ?? '';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = sprintf('/%s?city=%s&page=', $urlPath, $city);
        $data['cityData'] = $cityData; // 城市列表
        $data['mmTitle'] = $productsArray['data']['title_name'] ?? ''; // mm header 標題

        // meta -- start --
        $configMetaData = Config::get('meta.channelSpecial.' . $configMetaType); //  RS 限時的 config meta 資訊
        $data['meta']['title'] = $configMetaData['title'] ?? '';
        $data['meta']['description'] = $configMetaData['description'] ?? '';
        $data['meta']['canonicalUrl'] = sprintf('%s?city=%d&dist_group=%d', url()->current(), $city, $distGroup);
        // meta -- end --

        // jsonld
        $data['webType'] = 'chSpecial';
        $data['jsonld'] = $this->jsonldService->getJsonldData('ChSpecial', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }

        return view('listing.productList', $data);
    }

    /**
     * BT頻道 限時優惠、連鎖品牌
     */
    public function btSpecial(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), 0, 'chSpecial');

        $data = $this->defaultPageParam();

        // 城市、地區
        $distGroup = $this->cityService->getCityValue($request, 'dist_group', 'dist_group', 0);
        $city = $this->cityService->getCityValue($request, 'city', 'city', 1);
        $cityData = $this->cityService->getCityData(Config::get('channel.id.bt'), $city, $distGroup); // 取得城市資訊
        $this->cityService->checkCityValue(Config::get('channel.id.bt'), $cityData['cityList'], $city, $distGroup); // 檢查城市相關參數的內容值

        // 分頁
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        $page = intval($page);
        if ($page < 1) {
            $page = 1;
        }

        $type = 0;
        $urlInfo = parse_url($_SERVER['REQUEST_URI']);
        $urlPath = substr($urlInfo['path'], 1);
        $data['urlPath'] = $urlPath;
        $configMetaType = '';
        switch ($urlPath) {
            case 'bt_flash_sale':
                $type = 1;
                $configMetaType = 'btFlashSale';
                break;
            case 'bt_chain_store':
                $type = 2;
                $configMetaType = 'btChainStore';
                break;
        }

        $curlParam = array(
            'type' => $type,
            'city_id' => $city,
            'page' => $page,
        );

        $pageSize = 20;
        $productsArray = $this->apiService->curl('bt-recommend-special', 'GET', $curlParam); // apiService

        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

        if (!empty($data['products'])) {
            $ts = time();
            $index = 0;
            $si = ($productsArray['data']['product_cur_page'] - 1) * $pageSize;

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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);

                if (2 == $type) {
                    $data['products'][$key]['rank'] = (++$si);
                }
            }
        }

        $data['ch'] = Config::get('channel.id.bt');
        $data['page'] = $page;
        $data['city'] = $city;
        $data['title'] = $productsArray['data']['title_name'] ?? '';
        $data['goBack']['text'] = '逛更多'; // MM的回上一頁
        $data['goBack']['link'] = Config::get('channel.homeList.' . $data['ch'] . '.url'); // MM的回上一頁
        $data['chTitle'] = Config::get('channel.homeList.' . $data['ch'] . '.title');
        $data['chTitleUrl'] = Config::get('channel.homeList.' . $data['ch'] . '.url');
        $data['subChTitle'] = $productsArray['data']['title_name'] ?? '';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = sprintf('/%s?city=%s&page=', $urlPath, $city);
        $data['cityData'] = $cityData; // 城市列表
        $data['mmTitle'] = $productsArray['data']['title_name'] ?? ''; // mm header 標題

        // meta -- start --
        $configMetaData = Config::get('meta.channelSpecial.' . $configMetaType); // BT頻道分流 限時搶購/品牌連鎖的 config meta 資訊
        $data['meta']['title'] = $configMetaData['title'] ?? '';
        $data['meta']['description'] = $configMetaData['description'] ?? '';
        $data['meta']['canonicalUrl'] = sprintf('%s?city=%d&dist_group=%d', url()->current(), $city, $distGroup);
        // meta -- end --

        // jsonld
        $data['webType'] = 'chSpecial';
        $data['jsonld'] = $this->jsonldService->getJsonldData('ChSpecial', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }

        return view('listing.productList', $data);
    }

    public function esSpecial(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), 0, 'chSpecial');

        $data = $this->defaultPageParam();

        // 城市、地區
        $region = $this->cityService->getCityValue($request, 'es_region', 'region', 0);
        $spot = $this->cityService->getCityValue($request, 'es_spot', 'spot', 0);
        $city = $this->cityService->getCityValue($request, 'es_city', 'city', 0);
        $distGroup = 0;
        $cityData = $this->cityService->getCityData(Config::get('channel.id.es'), $city, 0, $region, $spot); // 取得城市資訊
        $this->cityService->checkCityValue(Config::get('channel.id.es'), $cityData['cityList'], $city, $distGroup, $region, $spot); // 檢查城市相關參數的內容值

        // 分頁
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        if ($page < 1) {
            $page = 1;
        }

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

        $curlParam = array(
            'page' => $page,
        );

        if (empty($city)) {
            $curlParam['region_id'] = $region;
        } else {
            $curlParam['city_id'] = $region;
            $curlParam['dist_group_id'] = $city;
            $curlParam['spot_id'] = $spot;
        }

        $pageSize = 20;
        $productsArray = $this->apiService->curl('es-recommend-products', 'GET', $curlParam); // apiService

        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

        if (!empty($data['products'])) {
            $ts = time();
            $index = 0;
            $si = ($productsArray['data']['product_cur_page'] - 1) * $pageSize;

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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);
            }
        }

        $data['ch'] = Config::get('channel.id.es');
        $data['region'] = $region;
        $data['city'] = $city;
        $data['spot'] = $spot;
        $data['page'] = $page;
        $data['title'] = $productsArray['data']['title_name'] ?? '';
        $data['goBack']['text'] = '逛更多'; // MM的回上一頁
        $data['goBack']['link'] = Config::get('channel.homeList.' . $data['ch'] . '.url'); // MM的回上一頁
        $data['chTitle'] = Config::get('channel.homeList.' . $data['ch'] . '.title');
        $data['chTitleUrl'] = Config::get('channel.homeList.' . $data['ch'] . '.url');
        $data['subChTitle'] = $productsArray['data']['title_name'] ?? '';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = sprintf('/travel_fair?region=%s&city=%s&spot=%s&page=', $region, $city, $spot);
        $data['cityData'] = $cityData; // 城市列表
        $data['mmTitle'] = $productsArray['data']['title_name'] ?? ''; // mm header 標題

        // meta -- start --
        $configMetaData = Config::get('meta.channelSpecial.esTravelFair'); // ES頻道分流的 config meta 資訊
        $data['meta']['title'] = $configMetaData['title'] ?? '';
        $data['meta']['description'] = $configMetaData['description'] ?? '';
        $data['meta']['canonicalUrl'] = sprintf('%s?region=%d&city=%d&spot=%d', url()->current(), $region, $city, $spot);
        // meta -- end --

        // jsonld
        $data['webType'] = 'chSpecial';
        $data['jsonld'] = $this->jsonldService->getJsonldData('ChSpecial', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }

        return view('listing.productList', $data);
    }

    public function shSpecial(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), 0, 'chSpecial');

        $data = $this->defaultPageParam();

        // 分頁
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        if ($page < 1) {
            $page = 1;
        }

        $curlParam = [
            'page' => $page,
        ];

        $productsArray = $this->apiService->curl('sh-recommend-products', 'GET', $curlParam); // apiService

        $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data

        if (!empty($data['products'])) {
            foreach ($data['products'] as $key => $value) {
                // 價格
                $data['products'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE);
                $data['products'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE);

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);
            }
        }

        $data['ch'] = Config::get('channel.id.sh');
        $data['page'] = $page;
        $data['title'] = $productsArray['data']['title_name'] ?? '';
        $data['goBack']['text'] = '逛更多'; // MM的回上一頁
        $data['goBack']['link'] = Config::get('channel.homeList.' . $data['ch'] . '.url'); // MM的回上一頁
        $data['chTitle'] = Config::get('channel.homeList.' . $data['ch'] . '.title');
        $data['chTitleUrl'] = Config::get('channel.homeList.' . $data['ch'] . '.url');
        $data['subChTitle'] = $productsArray['data']['title_name'] ?? '';
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['loadMoreUrl'] = '/sh_special?page=';
        $data['mmTitle'] = $productsArray['data']['title_name'] ?? ''; // mm header 標題

        // meta -- start --
        $configMetaData = Config::get('meta.channelSpecial.shSpecial'); // SH頻道分流的 config meta 資訊
        $data['meta']['title'] = $configMetaData['title'] ?? '';
        $data['meta']['description'] = $configMetaData['description'] ?? '';
        $data['meta']['canonicalUrl'] = url()->current();
        // meta -- end --

        // jsonld
        $data['webType'] = 'chSpecial';
        $data['jsonld'] = $this->jsonldService->getJsonldData('ChSpecial', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }

        return view('listing.productList', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     * @param int $id 主要ID
     * @param string $type 來源(detail: categoryAndEventList主題頁, specialAndTop特別企劃及排行榜, chSpecial頻道特別頁)
     */
    private function paramsValidation($request, $id = 0, $type = '')
    {
        $input = []; // 檢查的參數
        $rules = []; // 檢查規則
        $messages = []; // 驗證的錯誤訊息

        switch ($type) {
            case 'category':
                // 主題頁 網址：domain.com/category/categoryId?city=
                // 檢查的參數
                $input = [
                    'cat_id' => $id ?? 0,
                    'ch_id' => $request['ch_id'] ?? 1,
                    'city_id' => $request['city_id'] ?? 0,
                    'bi_id' => $request['bi_id'] ?? 0,
                    'page' => $request['page'] ?? 1,
                ];

                // 檢查規則
                $rules = [
                    'cat_id' => 'required|numeric|gt:0',
                    'ch_id' => 'required|numeric|gt:0',
                    'city_id' => 'numeric',
                    'bi_id' => 'required|numeric',
                    'page' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'cat_id.required' => '參數錯誤（' . Config::get('errorCode.categoryIdEmpty') . '）',
                    'cat_id.numeric' => '參數錯誤（' . Config::get('errorCode.categoryIdNumeric') . '）',
                    'cat_id.gt' => '參數錯誤（' . Config::get('errorCode.categoryIdGt') . '）',
                    'ch_id.required' => '參數錯誤（' . Config::get('errorCode.channelIdEmpty') . '）',
                    'ch_id.numeric' => '參數錯誤（' . Config::get('errorCode.channelIdNumeric') . '）',
                    'ch_id.gt' => '參數錯誤（' . Config::get('errorCode.channelIdGt') . '）',
                    'city_id.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
                    'bi_id.required' => '參數錯誤（' . Config::get('errorCode.biIdEmpty') . '）',
                    'bi_id.numeric' => '參數錯誤（' . Config::get('errorCode.biIdNumeric') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                ];
                break;
            case 'eventList':
                // 活動頁 網址：domain.com/event_list?event_id=city=
                // 檢查的參數
                $input = [
                    'event_id' => $request['event_id'] ?? 0,
                    'channel_id' => $request['channel_id'] ?? 1,
                    'city_id' => $request['city_id'] ?? 0,
                    'bi_id' => $request['bi_id'] ?? 0,
                    'page' => $request['page'] ?? 1,
                ];

                // 檢查規則
                $rules = [
                    'event_id' => 'required|numeric|gt:0',
                    'channel_id' => 'required|numeric',
                    'city_id' => 'numeric',
                    'bi_id' => 'required|numeric|gt:0',
                    'page' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'event_id.required' => '參數錯誤（' . Config::get('errorCode.eventIdEmpty') . '）',
                    'event_id.numeric' => '參數錯誤（' . Config::get('errorCode.eventIdNumeric') . '）',
                    'event_id.gt' => '參數錯誤（' . Config::get('errorCode.eventIdGt') . '）',
                    'channel_id.required' => '參數錯誤（' . Config::get('errorCode.channelIdEmpty') . '）',
                    'channel_id.numeric' => '參數錯誤（' . Config::get('errorCode.channelIdNumeric') . '）',
                    'city_id.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
                    'bi_id.required' => '參數錯誤（' . Config::get('errorCode.biIdEmpty') . '）',
                    'bi_id.numeric' => '參數錯誤（' . Config::get('errorCode.biIdNumeric') . '）',
                    'bi_id.gt' => '參數錯誤（' . Config::get('errorCode.biIdGt') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                ];
                break;
            case 'special':
                // 特別企劃special
                // 檢查的參數
                $input = [
                    'id' => $id ?? 0,
                    'city_id' => $request['city'] ?? 0,
                    'page' => $request['page'] ?? 1,
                ];

                // 檢查規則
                $rules = [
                    'id' => 'required|numeric|gt:0',
                    'city_id' => 'numeric|gt:0',
                    'page' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'id.required' => '參數錯誤（' . Config::get('errorCode.specialIdEmpty') . '）',
                    'id.numeric' => '參數錯誤（' . Config::get('errorCode.specialIdNumeric') . '）',
                    'id.gt' => '參數錯誤（' . Config::get('errorCode.specialIdGt') . '）',
                    'city_id.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
                    'city_id.gt' => '參數錯誤（' . Config::get('errorCode.cityIdGt') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                ];
                break;
            case 'top':
                // 排行榜top
                // 檢查的參數
                $input = [
                    'id' => $id ?? 0,
                    'city_id' => $request['city'] ?? 0,
                    'page' => $request['page'] ?? 1,
                ];

                // 檢查規則
                $rules = [
                    'id' => 'required|numeric|gt:0',
                    'city_id' => 'numeric',
                    'page' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'id.required' => '參數錯誤（' . Config::get('errorCode.topIdEmpty') . '）',
                    'id.numeric' => '參數錯誤（' . Config::get('errorCode.topIdNumeric') . '）',
                    'id.gt' => '參數錯誤（' . Config::get('errorCode.topIdGt') . '）',
                    'city_id.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                ];
                break;
            case 'chSpecial':
                // 檢查的參數
                $input = [
                    'city_id' => $request['city'] ?? 1,
                    'dist_group' => $request['dist_group'] ?? 0,
                    'region' => $request['region'] ?? 0,
                    'spot' => $request['spot'] ?? 0,
                    'page' => $request['page'] ?? 1,
                ];

                // 檢查規則
                $rules = [
                    'city_id' => 'numeric',
                    'dist_group' => 'numeric',
                    'region' => 'numeric',
                    'spot' => 'numeric',
                    'page' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'city_id.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
                    'dist_group.numeric' => '參數錯誤（' . Config::get('errorCode.distGroupIdNumeric') . '）',
                    'region.numeric' => '參數錯誤（' . Config::get('errorCode.regionIdNumeric') . '）',
                    'spot.numeric' => '參數錯誤（' . Config::get('errorCode.spotIdNumeric') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                ];
                break;
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
