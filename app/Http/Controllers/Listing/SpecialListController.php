<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\CityService;
use App\Services\JsonldService;
use Config;

class SpecialListController extends Controller
{
    protected $apiService;
    protected $cityService;
    protected $jsonldService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, CityService $cityService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->cityService = $cityService;
        $this->jsonldService = $jsonldService;
    }

    /**
     * 特別企劃
     */
    public function special(Request $request)
    {
        $this->paramsValidation($request->all()); // 參數驗證

        $cityId = $this->cityService->getCityValue($request, 'city', 'city', 1); // 城市

        $pageParam = $this->defaultPageParam();
        $pageParam['title'] = '特別企劃';
        $pageParam['type'] = 'special';
        $pageParam['mmTitle'] = '特別企劃'; // mm header 標題
        $pageParam['meta']['title'] = Config::get('meta.special.main.title');
        $pageParam['meta']['description'] = Config::get('meta.special.main.description');
        $pageParam['meta']['canonicalUrl'] = url()->current(); // 設定canonicalUrl

        // 取得特別企劃資訊
        $specialListResult = [];
        $param = ['ch_id' => 0, 'city_id' => $cityId];
        $pageParam['specialList'] = [];
        $specialListResult = $this->apiService->curl('home-learderboard', 'GET', $param);
        if ($specialListResult['return_code'] == '0000' && !empty($specialListResult['data'])) {
            $pageParam['specialList'] = $specialListResult['data']['special_list'] ?? [];
        }

        // jsonld
        $pageParam['webType'] = 'specialList';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('SpecialList', $pageParam);

        return view('listing.specialList', $pageParam);
    }

    /**
     * 排行榜
     */
    public function top()
    {
        $pageParam = $this->defaultPageParam();
        $pageParam['title'] = '排行榜';
        $pageParam['type'] = 'top';
        $pageParam['cityId'] = 1;
        $pageParam['mmTitle'] = '排行榜'; // mm header 標題
        
        // meta -- start --
        $pageParam['meta']['title'] = Config::get('meta.top.main.title');
        $pageParam['meta']['description'] = Config::get('meta.top.main.description');
        $pageParam['meta']['canonicalUrl'] = url()->current(); // 設定canonicalUrl
        // meta -- end --


        // 取得排行榜資訊
        $topListResult = [];
        $param = ['ch_id' => 0, 'city_id' => 1];
        $pageParam['specialList'] = [];
        $topListResult = $this->apiService->curl('home-learderboard', 'GET', $param);
        if ($topListResult['return_code'] == '0000' && !empty($topListResult['data'])) {
            $pageParam['specialList'] = $topListResult['data']['ranking_list'] ?? [];
        }
        // 切割名稱顯示
        foreach ($pageParam['specialList'] as $key => $val) {
            $pageParam['specialList'][$key]['top'] = 'T' . explode('T', $pageParam['specialList'][$key]['name'])[1];
            $pageParam['specialList'][$key]['name'] = explode('T', $pageParam['specialList'][$key]['name'])[0];
        }

        // jsonld
        $pageParam['webType'] = 'specialList';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('SpecialList', $pageParam);

        return view('listing.specialList', $pageParam);
    }

    /**
     * 參數驗證
     * @param array $requestAry 參數陣列
     */
    private function paramsValidation($requestAry = [])
    {
        // 檢查的參數
        $input = [
            'cityId' => $requestAry['city'] ?? 1,
        ];

        // 檢查規則
        $rules = [
            'cityId' => 'numeric|gt:0',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'cityId.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
            'cityId.gt' => '參數錯誤（' . Config::get('errorCode.cityIdGt') . '）',
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
