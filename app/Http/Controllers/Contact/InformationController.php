<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class InformationController extends Controller
{
    protected $apiService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 創市際問券 - 基本資料填寫頁
     */
    public function __invoke()
    {
        $gmUid = $_SERVER['HTTP_X_GOMAJI_MEMBERID'] ?? 0;
        $msg = '';
        $userInfo = [];

        // 參數驗證
        $this->paramsValidation($gmUid);

        // 預設參數
        $data = $this->defaultPageParam(false);
        // mm版
        $data['mmTitle'] = '問券';
        $data['goBack']['text'] = '';
        // meta
        $data['meta']['title'] = '【填問卷賺點數】個人資料填寫';
        $data['meta']['description'] = '台北人氣餐廳、團購美食、五星餐券、BUFFET 吃到飽通通在 GOMAJI。';
        $data['meta']['keywords'] = '團購,美食,美食餐廳,餐廳優惠,優惠券';

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        if (!$this->setMobileInfo()) {
            $msg = '請開啟APP參與活動呦～';
        } else {
            // 取用戶資料
            $curlParam = [
                'gm_uid' => $gmUid
            ];
            $rtCurlWork = $this->apiService->curl('insight-xplorer-info', 'GET', $curlParam);

            if (JSON_ERROR_NONE == json_last_error() && $rtCurlWork['return_code'] == 0000) {
                $userInfo = $rtCurlWork['data'];
            }

            if (JSON_ERROR_NONE == json_last_error() && $rtCurlWork['return_code'] != 0000) {
                $msg = $rtCurlWork['description'];
            }
        }

        $data['msg']      = $msg;
        $data['userInfo'] = $userInfo;
        $data['areaList'] = Config::get('city.areaList');
       
        return view('contact.information', $data);
    }

    /**
     * 參數驗證
     * @param int $gmUid 會員id
     */
    private function paramsValidation($gmUid = 0)
    {
        // 檢查的參數
        $input = [
            'gmUid' => $gmUid,
        ];

        // 檢查規則
        $rules = [
            'gmUid' => 'required|numeric|gt:0',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'gmUid.required' => '參數錯誤（' . Config::get('errorCode.gmUidEmpty') . '）',
            'gmUid.numeric' => '參數錯誤（' . Config::get('errorCode.gmUidNumeric') . '）',
            'gmUid.gt' => '參數錯誤（' . Config::get('errorCode.gmUidGt') . '）',
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
