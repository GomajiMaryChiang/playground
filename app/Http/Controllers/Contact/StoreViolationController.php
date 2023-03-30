<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class StoreViolationController extends Controller
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
     * 店家洗單通報
     */
    public function __invoke(Request $request, $productId = 0)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), $productId);

        $branchId = empty($request->input('branch_id')) ? 0 : $request->input('branch_id');
        
        // 預設參數
        $data = $this->defaultPageParam(false);
        // mm版
        $data['mmTitle'] = '店家洗單通報';
        $data['goBack']['text'] = '';
        // meta
        $data['meta']['ogUrl'] = sprintf(Config::get('setting.usagiDomain') . '%s', $this->filterQueryUri());
        $data['isShowLightHeader'] = true;

        $curlParam = [
            'product_id' => $productId,
            'branch_id' => $branchId
        ];

        $rtCurlWork = $this->apiService->curl('contact-violations', 'GET', $curlParam);

        if (($rtCurlWork['return_code'] != 0000) || empty($rtCurlWork['data'])) {
            $this->warningAlert('店家不存在(' . $rtCurlWork['return_code'] . ')', '/');
            exit;
        }

        // 將APP的資訊存入cookie
        $this->setMobileAppCookie();
        
        $data['store'] = $rtCurlWork['data'];

        return view('contact.storeViolation', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     * @param int $productId  商品id
     */
    private function paramsValidation($request, $productId = 0)
    {
        // 檢查的參數
        $input = [
            'productId' => $productId,
            'branchId' => $request['branch_id'] ?? 0,
        ];

        // 檢查規則
        $rules = [
            'productId' => 'required|numeric|gt:0',
            'branchId' => 'numeric',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'productId.required' => '參數錯誤（' . Config::get('errorCode.productIdEmpty') . '）',
            'productId.numeric' => '參數錯誤（' . Config::get('errorCode.productIdNumeric') . '）',
            'productId.gt' => '參數錯誤（' . Config::get('errorCode.productIdGt') . '）',
            'branchId.numeric' => '參數錯誤（' . Config::get('errorCode.branchIdNumeric') . '）',
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
