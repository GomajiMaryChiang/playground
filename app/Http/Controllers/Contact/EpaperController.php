<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class EpaperController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /*
     * 取消訂閱電子報頁
     */
    public function __invoke(Request $request)
    {
        $this->paramsValidation($request->all()); // 參數驗證
        $session = htmlspecialchars(trim($request->input('session', '')));

        // ===== 取得電子報資訊 =====
        $edmData = [];
        $apiParam = ['session' => $session];
        $apiResult = $this->apiService->curl('member-edm-status', 'GET', $apiParam);
        if ($apiResult['return_code'] != '0000' || empty($apiResult['data'])) {
            $this->warningAlert("${apiResult['description']}（${apiResult['return_code']}）", '/');
            exit;
        }
        $edmData = $apiResult['data'];
        // ===== End: 取得電子報資訊 =====

        // ===== 目前訂閱了哪些城市 =====        
        $edmCityList = Config('city.edmCityList');
        if (!empty($edmData['subscribe'])) {
            foreach ($edmData['subscribe'] as $value) {
                if (isset($edmCityList[$value])) {
                    $edmCityList[$value]['checked'] = true;
                }
            }
        }
        // ===== End: 目前訂閱了哪些城市 =====

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam();
        $pageParam['mmTitle'] = '電子報訂閱管理';

        // content
        $pageParam['session'] = $session; // 加密過的 email 資訊
        $pageParam['edmCityList'] = $edmCityList; // edm 訂閱的城市列表
        $pageParam['email'] = $edmData['email'] ?? ''; // 訂閱的 email
        /* ===== End: 頁面參數 ===== */

        return view('contact.epaper', $pageParam);
    }

    /**
     * 參數驗證
     * @param array $requestAry 參數陣列
     */
    private function paramsValidation($requestAry = [])
    {
        // 檢查的參數
        $input = [
            'session' => $requestAry['session'] ?? '',
        ];

        // 檢查規則
        $rules = [
            'session' => 'required',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'session.required' => '參數錯誤（' . Config::get('errorCode.sessionEmpty') . '）',
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
