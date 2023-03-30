<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\JsonldService;
use App\Services\ProductService;
use Config;

class StoreController extends Controller
{
    protected $apiService;
    protected $productService;
    protected $jsonldService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, ProductService $productService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->productService = $productService;
        $this->jsonldService = $jsonldService;
    }

    /**
     * 店家頁
     */
    public function __invoke(Request $request, $storeId, $branchId = 0)
    {
        $this->paramsValidation($storeId, $branchId); // 參數驗證

        // 取得店家頁資訊
        $apiParam = ['store_id' => $storeId];
        $storeDataResult = $this->apiService->curl('store-page', 'GET', $apiParam);
        if ($storeDataResult['return_code'] != '0000' || empty($storeDataResult['data']['store'])) {
            $this->warningAlert('查無此商家代號', '/');
        }
        $storeData = $storeDataResult['data']['store'];

        // 店家評價
        $ratingScore = $storeData['rating']['avg_rating'] ?? 0;
        $ratingScoreAry = explode('.', $ratingScore);
        $storeData['store_rating_int'] = $ratingScoreAry[0];
        $storeData['store_rating_dot'] = '.' . ($ratingScoreAry[1] ?? 0);
        $storeData['store_rating_people'] = $storeData['rating']['rating_count'] ?? 0;
        $storeData['store_rating_class'] = sprintf('i-smile-%s%s', $ratingScoreAry[0], (!empty($ratingScoreAry[1]) ? '-1' : ''));

        // 麵包屑
        $breadcrumb = [];
        $chId = $this->getChId($storeData);
        $representativeCategory = $storeData['representative_category'] ?? [];
        $breadcrumb['title'] = Config::get("channel.chName.$chId", '');
        $breadcrumb['link'] = sprintf('/ch/%d', $chId);
        $breadcrumb['subTitle'] = $storeData['store_name'] ?? '';
        $breadcrumb['subLink'] = '';
        $breadcrumb['chId'] = $chId ?? '';
        // 如果店家為宅配店家，且 representative_category 不為空，以該店家熱門類別取代店家名稱
        if ($chId == Config::get('channel.id.sh') && !empty($representativeCategory)) {
            $breadcrumb['subTitle'] = $representativeCategory['name'] ?? '';
            $breadcrumb['subLink'] = $representativeCategory['link'] ?? '';
        }

        // 分店列表
        $branchList = [];
        if (!empty($storeData['branches'])) {
            $branchList = array_combine(array_column($storeData['branches'], 'branch_id'), $storeData['branches']);
        }

        // 預設分店資訊
        $defaultBranch = [];
        if (!empty($storeData['branches'])) {
            $defaultBranch = $storeData['branches'][0];

            // 是否有指定的分店
            if (!empty($branchId)) {
                $assignBranch = array_filter($storeData['branches'], function ($branch) use ($branchId) {
                    return $branch['branch_id'] == $branchId;
                });
                $defaultBranch = !empty($assignBranch) ? array_shift($assignBranch) : $defaultBranch; // 取第一個分店資訊
            }
        }

        // 類別列表
        $categoryList = [];
        if (!empty($storeData['categorys'])) {
            $categoryList = array_merge($categoryList, $storeData['categorys']);
        }
        if (!empty($storeData['tags'])) {
            $categoryList = array_merge($categoryList, $storeData['tags']);
        }

        // 檔次列表
        $productList = [];
        if (!empty($storeData['products'])) {
            $productList = $storeData['products'];
            foreach ($productList as $key => $value) {
                $value['store_id'] = $storeId;
                $productList[$key]['link'] = $this->productService->getProductLink($value);
                $productList[$key]['status'] = $this->productService->getProductStatus($value);
                $productList[$key]['display_desc'] = $this->productService->getDisplayDesc($value);
                $productList[$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                $productList[$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價
            }
        }

        // 取得附近推薦檔次列表
        $otherProductData = [];
        if (!empty($productList)) {
            $firstProduct = $productList[0];
            $apiParam = [
                // gid規則：有選擇分店則使用分店作為查詢條件，若無則用第一筆顯示商品的分店作為查詢條件
                'gid' => !empty($branchId) ? $branchId : $firstProduct['group_id'],
                'pid' => $firstProduct['product_id'],
                'sid' => $storeId,
                'product_kind' => $firstProduct['product_kind'] == Config::get('product.kindId.coffee') ? Config::get('product.kindId.rsGid') : $firstProduct['product_kind'],
                'plat' => 2,
                'func' => 2
            ];
            $otherProductResult = $this->apiService->curl('other-products', 'GET', $apiParam);
            if ($otherProductResult['return_code'] == '0000' && !empty($otherProductResult['data'])) {
                $otherProductData = $otherProductResult['data'];
            }
        }

        // 附近推薦檔次列表
        $otherProductList = [];
        if (!empty($otherProductData)) {
            $otherProductList = $otherProductData;
            foreach ($otherProductList as $key => $value) {
                $otherProductList[$key]['link'] = $this->productService->getProductLink($value);
                $otherProductList[$key]['display_desc'] = $this->productService->getDisplayDesc($value);
                $otherProductList[$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE); // 原價
                $otherProductList[$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE); // 售價

                // 評價
                $ratingScore = $value['store_rating_score'] ?? 0;
                if (strpos($ratingScore, '.') === false) {
                    $ratingScore .= '.0';
                }
                $otherProductList[$key]['store_rating_int'] = floor($ratingScore);
                $otherProductList[$key]['store_rating_dot'] = substr(strval($ratingScore), -2);
            }
        }

        /* ===== 頁面參數 ===== */
        $pageParam = $this->defaultPageParam();

        // header
        $pageParam['title'] = 'GOMAJI 最大吃喝玩樂平台';
        $pageParam['mmTitle'] = $storeData['store_name'] ?? ''; // mm header 標題
        $pageParam['goBack']['link'] = sprintf('/ch/%d', $chId); // mm header “上一頁”的按鈕連結
        $pageParam['goBack']['text'] = '逛更多'; // mm header “上一頁”的按鈕文字

        // content
        $pageParam['breadcrumb'] = $breadcrumb; // 麵包屑
        $pageParam['store'] = $storeData; // 店家資訊
        $pageParam['defaultBranch'] = $defaultBranch; // 預設分店資訊
        $pageParam['branchList'] = $branchList; // 分店列表
        $pageParam['categoryList'] = $categoryList; // 類別列表
        $pageParam['productList'] = $productList; // 檔次列表
        $pageParam['otherProductList'] = $otherProductList; // 附近推薦檔次列表

        // jsonld
        $pageParam['webType'] = 'store';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('Store', $pageParam);

        // meta
        $pageParam['meta']['title'] = $pageParam['store']['store_name'] . '| ' . implode('、', array_column($categoryList, 'name')) . '優惠券、抵用券| GOMAJI夠麻吉';
        $pageParam['meta']['description'] = iconv_substr(str_replace(["\r", "\n"], '', trim(strip_tags($pageParam['store']['store_intro']))), 0, 100, 'UTF-8');
        $pageParam['meta']['ogImage'] = empty($pageParam['store']['products'][0]['img']) ? '' : $pageParam['store']['products'][0]['img'];
        $pageParam['meta']['canonicalUrl'] = sprintf('%s/store/%d', Config::get('setting.usagiDomain'), $storeId);
        /* ===== End: 頁面參數 ===== */

        return view('main.store', $pageParam);
    }

    protected function getChId($store = [])
    {
        $chId = $store['channel'] ?? Config::get('channel.id.rs');

        if (in_array($chId, [Config::get('channel.id.tk'), Config::get('channel.id.lf')])) {
            return Config::get('channel.id.lfn');
        }

        return $chId;
    }

    /**
     * 店家介紹
     * @param int $storeId 店家編號
     */
    public function intro($storeId = 0)
    {
        // 參數驗證
        $this->paramsValidation($storeId);

        // 取得店家頁資訊
        $apiParam = ['store_id' => $storeId];
        $storeDataResult = $this->apiService->curl('store-page', 'GET', $apiParam);
        if ($storeDataResult['return_code'] != '0000' || empty($storeDataResult['data']['store'])) {
            $this->warningAlert(__('查無此商家代號'), '/');
        }
        $storeData = $storeDataResult['data']['store'];

        $pageParam = $this->defaultPageParam();
        // header
        $pageParam['mmTitle'] = $storeData['store_name'] ?? ''; // mm header 標題
        $pageParam['goBack']['link'] = ''; // mm header “上一頁”的按鈕連結
        $pageParam['goBack']['text'] = ''; // mm header “上一頁”的按鈕文字

        // 店家資訊
        $pageParam['store'] = $storeData; // 店家資訊

        // 此頁面只有 for app，設定不顯示 header/footer
        $pageParam['isShowLightHeader'] = false;
        $pageParam['isShowHeader'] = false;
        $pageParam['isShowFooter'] = false;

        return view('main.intro', $pageParam);
    }

    /**
     * 參數驗證
     * @param int   $storeId    店家編號
     * @param int   $branchId   分店編號
     */
    private function paramsValidation($storeId = 0, $branchId = 0)
    {
        // 檢查的參數
        $input = [
            'storeId' => $storeId,
            'branchId' => $branchId ?? 0,
        ];

        // 檢查規則
        $rules = [
            'storeId' => 'required|numeric|gt:0',
            'branchId' => 'numeric|gte:0',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'storeId.required' => '參數錯誤（' . Config::get('errorCode.storeIdEmpty') . '）',
            'storeId.numeric' => '參數錯誤（' . Config::get('errorCode.storeIdNumeric') . '）',
            'storeId.gt' => '參數錯誤（' . Config::get('errorCode.storeIdGt') . '）',
            'branchId.numeric' => '參數錯誤（' . Config::get('errorCode.branchIdNumeric') . '）',
            'branchId.gte' => '參數錯誤（' . Config::get('errorCode.branchIdGte') . '）',
        ];

        $validator = Validator::make($input, $rules, $messages);
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
