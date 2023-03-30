<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class StoreHighPriceController extends Controller
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
     * 價高通報
     */
    public function __invoke($productId = 0)
    {
        // 參數驗證
        $this->paramsValidation($productId);

        // 預設參數
        $data = $this->defaultPageParam(false);
        // mm版
        $data['mmTitle'] = '價高通報';
        $data['goBack']['text'] = '';
        // meta
        $data['meta']['ogUrl'] = sprintf(Config::get('setting.usagiDomain') . '%s', $this->filterQueryUri());
        $data['isShowLightHeader'] = true;


        $curlParam = [
            'product_id' => $productId
        ];
        
        $rtCurlWork = $this->apiService->curl('contact-highprice', 'GET', $curlParam);

        if (($rtCurlWork['return_code'] != 0000) || empty($rtCurlWork['data'])) {
            $this->warningAlert('店家不存在(' . $rtCurlWork['return_code'] . ')', '/');
            exit;
        }

        // 將APP的資訊存入cookie
        $this->setMobileAppCookie();

        $data['store'] = $rtCurlWork['data'];

        return view('contact.storeHighPrice', $data);
    }

    /**
     * 參數驗證
     * @param int $productId  商品id
     */
    private function paramsValidation($productId = 0)
    {
        // 檢查的參數
        $input = [
            'productId' => $productId,
        ];

        // 檢查規則
        $rules = [
            'productId' => 'required|numeric|gt:0',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'productId.required' => '參數錯誤（' . Config::get('errorCode.productIdEmpty') . '）',
            'productId.numeric' => '參數錯誤（' . Config::get('errorCode.productIdNumeric') . '）',
            'productId.gt' => '參數錯誤（' . Config::get('errorCode.productIdGt') . '）',
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
