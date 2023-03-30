<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\JsonldService;
use App\Services\ProductService;
use Config;

class BrandDetailController extends Controller
{
    const TYPE_RS = 'RS';
    const TYPE_FOOD = 'FOOD';
    const TYPE_FRESH = 'FRESH';
    const TYPE_ARRAY = [
        self::TYPE_RS,
        self::TYPE_FOOD,
        self::TYPE_FRESH,
    ];

    protected $apiService;
    protected $jsonldService;
    protected $productService;

    public function __construct(ApiService $apiService, ProductService $productService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->jsonldService = $jsonldService;
        $this->productService = $productService;
    }

    /**
     * 品牌餐廳/星級飯店 ＆ 名店美食 檔次列表頁
     */
    public function __invoke($brand = 0, Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), $request->route('brand'), 'brand');

        // 設定查詢參數 --- 開 始 ---
        $city = 1;
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        $sort = empty($_GET['sort']) ? 0 : htmlspecialchars(strip_tags($_GET['sort']), ENT_QUOTES);
        $type = empty($_GET['type']) ? self::TYPE_RS : strtoupper(htmlspecialchars(strip_tags($_GET['type']), ENT_QUOTES));
        $brandName = ($type == self::TYPE_RS) ? '星級飯店．品牌餐廳' : '名店美食';
        $brandLink = ($type == self::TYPE_RS) ? '/brand' : '/sh_brand';
        $brand = intval(!isset($brand)? '1': $brand);
        $page = intval($page);
        if ( $page < 1 ) {
            $page = 1;
        }

        $curlParam = [
            'brand_type' => $type,
            'pa_id' => $brand,
            'page' => $page,
            'sort_id' => $sort,
        ];
        // 設定查詢參數 --- 結 束 ---

        // apiService --- 開 始 ---
        $productsArray = $this->apiService->curl('brand-product-list', 'GET', $curlParam);
        // apiService --- 結 束 ---

        // 麵包屑 --- 開 始 ---
        $breadcrumbList = [
            [
                'title' => '首頁',
                'link' => '/',
            ],
            [
                'title' => $brandName,
                'link' => $brandLink,
            ],
            [
                'title' => $productsArray['data']['title'] ?? '',
            ],
        ];
        // 如為“名店美食”，麵包屑第二層加上宅配頻道
        if ($type != self::TYPE_RS) {
            $channelBreadcrumb = [
                [
                    'title' => Config::get('channel.homeList' . Config::get('channel.id.sh')) ?? '宅配美食',
                    'link' => sprintf('/ch/%d', Config::get('channel.id.sh')),
                ]
            ];
            array_splice($breadcrumbList, 1, 0, $channelBreadcrumb);
        }
        // 麵包屑 --- 結 束 ---

        // 帶入參數 --- 開 始 ---
        $data = $this->defaultPageParam();

        $data['products'] = $productsArray['data']['product'] ?? [];
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;

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

                // 檔次連結網址
                $data['products'][$key]['link'] = $this->productService->getProductLink($value);

                // 小圖片標章 ex:sold-out
                $data['products'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);

                // 價格
                $data['products'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE);
                $data['products'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE);
            }
        }

        $data['brand'] = $brand;
        $data['city'] = $city;
        $data['page'] = $page;
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['sort'] = $sort;
        $data['sortList'] = ['推薦排序', '評價高至低', '價格低至高', '價格高至低'];
        $data['sortUrl'] = sprintf('%s/%s?city=%s&page=%s&type=%s', $brandLink, $brand, $city, $page, $type);
        $data['title'] = $productsArray['data']['title'] ?? '';
        $data['img'] = $productsArray['data']['img'] ?? [];
        $data['loadMoreUrl'] = sprintf('%s/%s?city=%s&sort=%s&type=%s', $brandLink, $brand, $city, $sort, $type);
        $data['mmTitle'] = $productsArray['data']['title'] ?? ''; // mm header 標題
        $data['breadcrumbList'] = $breadcrumbList; // 麵包屑

        // meta -- start --
        $configMetaData = ($type == self::TYPE_RS) ? Config::get('meta.channelSpecial.rsBrandDetail') : Config::get('meta.channelSpecial.shBrandDetail'); //  RS 品牌牆/宅配美食 品牌的 config meta 資訊
        $configMetaTitle = ($type == self::TYPE_RS) ? $breadcrumbList[2]['title'] . $configMetaData['title'] : $configMetaData['title'];
        $data['meta']['title'] = $configMetaTitle ?? '';
        $data['meta']['description'] = $configMetaData['description'] ?? '';
        $data['meta']['canonicalUrl'] = url()->current(); // 設定canonicalUrl
        // meta -- end --

        // mm header “上一頁”的按鈕連結及文字
        $data['goBack']['link'] = $brandLink;
        $data['goBack']['text'] = '逛更多';

        // jsonld
        $data['webType'] = 'brandList';
        $data['jsonld'] = $this->jsonldService->getJsonldData('BrandList', $data);

        // 帶入參數 --- 結 束 ---

        // 載入更多 --- 開 始 ---
        if ($page != 1) {

            $html = '';
            if (!empty($productsArray['data']['product'])) {
                $html = view('layouts.brandProduct', $data) -> render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $productsArray['data']['product_total_pages'] ?? 0,
                'html' => $html
            );

            exit(json_encode($result));
        }
        // 載入更多 --- 結 束 ---

        return view('listing.brandDetail', $data);
    }

    /**
     * 品牌咖啡列表
     */
    public function coffee($groupId = 0, Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), $request->route('groupId'), 'coffee');

        $data = $this->defaultPageParam();

        $ch = Config::get('channel.id.coffee');
        $sort = empty($_GET['sort']) ? 0 : htmlspecialchars(strip_tags($_GET['sort']), ENT_QUOTES);
        $page = empty($_GET['page']) ? 1 : htmlspecialchars(strip_tags($_GET['page']), ENT_QUOTES);
        if ($page < 1) {
            $page = 1;
        }

        $curlParam = array(
            'ch_id' => $ch,
            'gid' => $groupId,
            'page' => $page,
            'sort_id' => $sort,
        );

        $productsArray = $this->apiService->curl('product-list', 'GET', $curlParam); // apiService

        if ($productsArray['return_code'] == '0000') {
            $data['products'] = $productsArray['data']['product'] ?? []; // 商品資料主要陣列塞入$data
            $data['all'] = $productsArray;
        }
        $pageSize = 20;
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

                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);
            }
        }

        // 麵包屑
        $breadcrumbList = [
            [
                'title' => '首頁',
                'link' => '/',
            ],
            [
                'title' => $data['products'][0]['group_name'] ?? '',
            ],
        ];

        $data['ch'] = Config::get('channel.id.coffee');
        $data['sort'] = $sort;
        $data['page'] = $page;
        $data['img'] = $productsArray['data']['header_img'] ?? '';
        $data['title'] = $productsArray['data']['coffee_title'] ?? '';
        $data['goBack']['text'] = '逛更多'; // MM的回上一頁
        $data['goBack']['link'] = '/earnpoint'; // MM的回上一頁
        $data['totalItems'] = $productsArray['data']['product_total_items'] ?? 0;
        $data['totalPages'] = $productsArray['data']['product_total_pages'] ?? 0;
        $data['sortList'] = array('推薦排序', '', '價格低至高', '價格高至低'); // 咖啡頻道排序
        $data['sortUrl'] = sprintf('/coffee/brand/%d', $groupId);
        $data['loadMoreUrl'] = sprintf('/coffee/brand/%d?sort=%s', $groupId, $sort);
        $data['mmTitle'] = $productsArray['data']['product'][0]['group_name'] ?? ''; // mm header 標題
        $data['breadcrumbList'] = $breadcrumbList; // 麵包屑

        $configMetaName = sprintf('meta.coffee.%d', $groupId);
        $configMetaData = Config::get($configMetaName, Config::get('meta.coffee.0'));
        $data['meta']['title'] = $configMetaData['title'] ?? '';
        $data['meta']['description'] = $configMetaData['description'] ?? '';
        $data['meta']['canonicalUrl'] = url()->current(); // 設定canonicalUrl

        // jsonld
        $data['webType'] = 'coffee';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Coffee', $data);

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

        return view('listing.brandDetail', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     * @param int $id 飯店/餐廳/品牌咖啡ID
     * @param string $type 類型，brand 品牌餐廳/星級飯店、coffee 品牌咖啡
     */
    private function paramsValidation($request, $id = 0, $type = '')
    {
        $input = [];// 檢查的參數
        $rules = [];// 檢查規則
        $messages = [];// 驗證的錯誤訊息

        switch ($type) {
            case 'brand':
                // 檢查的參數
                $input = [
                    'brand' => $id ?? 0,
                    'page' => $request['page'] ?? 1,
                    'city' => $request['city'] ?? 0,
                    'sort_id' => $request['sort'] ?? 0,
                    'type' => !empty($request['type']) ? strtoupper($request['type']) : '',
                ];

                // 檢查規則
                $rules = [
                    'brand' => 'required|numeric|gt:0',
                    'page' => 'numeric',
                    'city' => 'numeric',
                    'sort_id' => 'numeric',
                    'type' => 'in:' . implode(',', self::TYPE_ARRAY),
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'brand.required' => '參數錯誤（' . Config::get('errorCode.brandIdEmpty') . '）',
                    'brand.numeric' => '參數錯誤（' . Config::get('errorCode.brandIdNumeric') . '）',
                    'brand.gt' => '參數錯誤（' . Config::get('errorCode.brandIdGt') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                    'city.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
                    'sort_id.numeric' => '參數錯誤（' . Config::get('errorCode.sortIdNumeric') . '）',
                    'type.in' => '參數錯誤（' . Config::get('errorCode.brandTypeIn') . '）',
                ];
                break;
            case 'coffee':
                // 檢查的參數
                $input = [
                    'gid' => $id ?? 0,
                    'page' => $request['page'] ?? 1,
                    'sort_id' => $request['sort'] ?? 0,
                ];

                // 檢查規則
                $rules = [
                    'gid' => 'required|numeric|gt:0',
                    'page' => 'numeric',
                    'sort_id' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'gid.required' => '參數錯誤（' . Config::get('errorCode.groupIdEmpty') . '）',
                    'gid.numeric' => '參數錯誤（' . Config::get('errorCode.groupIdNumeric') . '）',
                    'gid.gt' => '參數錯誤（' . Config::get('errorCode.groupIdGt') . '）',
                    'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
                    'sort_id.numeric' => '參數錯誤（' . Config::get('errorCode.sortIdNumeric') . '）',
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
