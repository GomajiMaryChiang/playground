<?php

namespace App\Http\Controllers\Errors;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class ServerErrorController extends Controller
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
     * 500 錯誤頁
     */
    public function __invoke(Request $request)
    {
        $this->paramsValidation($request->all()); // 參數驗證
        $statusCode = htmlspecialchars(trim($request->input('statusCode', 500)));

        $pageParam = $this->defaultPageParam();
        $pageParam['meta']['title'] = Config::get('meta.500.title');
        $pageParam['mmTitle'] = $statusCode;
        $pageParam['statusCode'] = $statusCode;

        // app 開啟的不顯示 header & footer
        $pageParam['isShowHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowFooter'] = !$this->checkFromMobileApp();

        return response()->view('errors.500', $pageParam)->setStatusCode(500);
    }

    /**
     * 參數驗證
     * @param array $requestAry 參數陣列
     */
    private function paramsValidation($requestAry = [])
    {
        // 檢查的參數
        $input = [
            'statusCode' => $requestAry['statusCode'] ?? 0,
        ];

        // 檢查規則
        $rules = [
            'statusCode' => 'numeric',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'statusCode.numeric' => '參數錯誤（' . Config::get('errorCode.statusCodeNumeric') . '）',
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
