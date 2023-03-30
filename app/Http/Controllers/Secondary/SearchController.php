<?php

namespace App\Http\Controllers\Secondary;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\ChannelService;
use App\Services\CityService;
use App\Services\MetaService;
use App\Services\JsonldService;
use App\Services\ProductService;
use App\Services\SearchService;
use Config;

class SearchController extends Controller
{
    protected $apiService;
    protected $channelService;
    protected $cityService;
    protected $productService;
    protected $searchService;
    protected $metaService;
    protected $jsonldService;

    public function __construct(ApiService $apiService, ChannelService $channelService, CityService $cityService, ProductService $productService, SearchService $searchService, MetaService $metaService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->channelService = $channelService;
        $this->cityService = $cityService;
        $this->productService = $productService;
        $this->searchService = $searchService;
        $this->metaService = $metaService;
        $this->jsonldService = $jsonldService;
    }

    /**
     * 搜尋結果頁
     */
    public function __invoke(Request $request)
    {
        $searchKeyword = htmlspecialchars(strip_tags($request->input('keyword', ''), ENT_QUOTES));
        $ch = htmlspecialchars(strip_tags($request->input('ch', 0), ENT_QUOTES));
        // $ch 不在現有頻道列表數字裡面的話，設為 0（全域搜索）
        if (!in_array($ch, Config::get('channel.channelList'))) {
            $ch = 0;
        }
        $cross = htmlspecialchars(strip_tags($request->input('cross', 0), ENT_QUOTES));
        $sort = htmlspecialchars(strip_tags($request->input('sort', 0), ENT_QUOTES));
        $page = htmlspecialchars(strip_tags($request->input('page', 1), ENT_QUOTES));
        $city = $this->cityService->getCityValue($request, 'city', 'city', 1);
        $distGroup = $this->cityService->getCityValue($request, 'dist_group', 'dist_group', 0);
        $cityData = $this->cityService->getCityData(0, $city); // 取得城市資訊
        $this->cityService->checkCityValue(0, $cityData['cityList'], $city, $distGroup); // 檢查城市相關參數的內容值

        // 參數驗證
        $this->paramsValidation($request->all());

        if (empty($searchKeyword)) {
            // 操作錯誤處理
            if ($page != 1) {
                exit('keyword lose!!');
            }
            $this->warningAlert('操作錯誤', '/');
            exit;
        } else {
            // 將搜尋關鍵字加入Cookie
            $this->searchService->searchKeywords($searchKeyword);
        }

        $data = $this->defaultPageParam();

        // 檢查跨區參數
        $queryCity = $city;
        if ($cross) {
            $queryCity = 0;
        }

        // 檢查排序方式參數
        if (!in_array($sort, array(0, 1, 2, 3))) {
            $sort = 0;
        }

        $curlParam = [
            'ch_id' => $ch,
            'city_id' => $queryCity,
            'keyword' => $searchKeyword,
            'page' => $page,
            'sort' => $sort,
        ];

        $data['products'] = [];
        $searchResults = $this->apiService->curl('search', 'GET', $curlParam); // apiService
        if (!empty($searchResults) && $searchResults['return_code'] == 0000) {
            $data['products'] = $searchResults['data']['product']; // 商品資料主要陣列塞入$data
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

                // 檔次連結網址
                $data['products'][$key]['link'] = $this->productService->getProductLink($data['products'][$key]);
                $data['products'][$key]['micro_order_status'] = $this->productService->getProductStatus($value);

                // 價格
                $data['products'][$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE);
                $data['products'][$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE);
            }
        }

        $data['title'] = '[' . $searchKeyword . '] 搜尋結果';
        $data['sort'] = $sort;
        $data['searchKeyword'] = $searchKeyword;
        $data['city'] = $queryCity;
        $data['cross'] = $cross;
        $data['cityList'] = Config::get('city.cityList');
        $data['totalPages'] = $searchResults['data']['product_total_pages'] ?? 0;
        $data['totalItems'] = $searchResults['data']['product_total_items'] ?? 0;
        $data['loadMoreUrl'] = sprintf('search?keyword=%s&ch=%s&city=%s&cross=%s&sort=%s&page=', $searchKeyword, $ch, $queryCity, $cross, $sort);
        $data['cityData'] = $cityData; // 城市列表
        $data['mmTitle'] = '搜尋結果'; // mm header 標題
        $data['meta']['title'] = $this->metaService->bindValue(Config::get('meta.search.title'), [':keyword' => $searchKeyword]);
        $data['meta']['description'] = Config::get('meta.search.description');
        $data['meta']['canonicalUrl'] = sprintf('%s?keyword=%s&ch=%s&city=%s&cross=%s&sort=%s', url()->current(), $searchKeyword, $ch, $queryCity, $cross, $sort); //設定canonicalUrl

        // 城市選單的連結網址參數，加上搜尋關鍵字
        foreach ($data['cityData']['cityList'] as $key => $city) {
             $data['cityData']['cityList'][$key]['paramValue'] .= sprintf('&keyword=%s', $searchKeyword);
        }

        // jsonld
        $data['webType'] = 'search';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Search', $data);

        // Loading More
        if ($page != 1) {
            $html = '';
            if (!empty($searchResults['data']['product'])) {
                $html = view('layouts.channelProduct', $data)->render(); // 將視圖code塞入
            }

            $result = array(
                'code' => 1,
                'message' => '',
                'total_pages' => $searchResults['data']['product_total_pages'] ?? 0,
                'html' => $html,
            );

            exit(json_encode($result));
        }

        return view('secondary.search', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     */
    private function paramsValidation($request)
    {
        // 檢查的參數
        $input = [
            'ch_id' => $request['ch'] ?? 0,
            'cross' => $request['cross'] ?? 0,
            'sort_id' => $request['sort'] ?? 0,
            'page' => $request['page'] ?? 1,
            'city_id' => $request['city'] ?? 0,
            'dist_group_id' => $request['dist_group'] ?? 0,
        ];

        // 檢查規則
        $rules = [
            'ch_id' => 'numeric|gte:0',
            'cross' => 'numeric',
            'sort_id' => 'numeric',
            'page' => 'numeric',
            'city_id' => 'numeric',
            'dist_group_id' => 'numeric',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'ch_id.numeric' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.channelIdNumeric')),
            'ch_id.gte' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.channelIdGte')),
            'cross.numeric' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.crossNumeric')),
            'sort_id.numeric' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.sortIdNumeric')),
            'page.numeric' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.pageNumeric')),
            'city_id.numeric' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.cityIdNumeric')),
            'dist_group_id.numeric' => sprintf('%s (%d)', '參數錯誤', Config::get('errorCode.distGroupIdNumeric')),
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
