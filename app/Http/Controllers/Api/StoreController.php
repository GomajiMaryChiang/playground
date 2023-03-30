<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class StoreController extends Controller
{
    protected $apiService;

    // error code
    const DATA_ERROR_CODE = '3000';
    const UNUSUAL_ERROR_CODE = '3001';
    const STORE_ID_ERROR_CODE = '3002';
    const REPORT_TYPE_ERROR_CODE = '3003';
    const ADDRESS_ERROR_CODE = '3004';
    const BUSINESS_HOURS_ERROR_CODE = '3005';
    const VALIDATION_ERROR_CODE = '3006';

    // 參數驗證類型
    const TYPE_VIOLATION = 'storeViolation';
    const TYPE_PRICE = 'storeHighPrice';
    const TYPE_REPORT = 'errorReport';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 店家洗單通報
     * @param object data 相關資訊
     * @return array
     */
    public function storeViolation(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('data'))) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
        }

        // 過濾參數
        $jsonData = $request->input('data', '');
        $receiveData = json_decode($jsonData, true);
        if (empty($receiveData) || !is_array($receiveData)) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        // 參數型態驗證
        $validationResult = $this->paramsValidation(self::TYPE_VIOLATION, $receiveData);
        if (!empty($validationResult)) {
            return [
                'return_code' => self::VALIDATION_ERROR_CODE,
                'description' => $validationResult,
            ];
        }

        $receiveData['store_id'] = isset($receiveData['store_id']) ? filter_var(trim($receiveData['store_id']), FILTER_VALIDATE_INT) : 0;
        $receiveData['product_id'] = isset($receiveData['product_id']) ? filter_var(trim($receiveData['product_id']), FILTER_VALIDATE_INT) : 0;
        $receiveData['full_name'] = isset($receiveData['full_name']) ? filter_var(trim(urldecode($receiveData['full_name'])), FILTER_SANITIZE_STRING) : '';
        $receiveData['email'] = isset($receiveData['email']) ? filter_var(trim($receiveData['email']), FILTER_SANITIZE_EMAIL) : '';
        $receiveData['mobile_phone'] = isset($receiveData['mobile_phone']) ? filter_var(trim($receiveData['mobile_phone']), FILTER_SANITIZE_STRING) : '';
        $receiveData['contact_content'] = isset($receiveData['contact_content']) ? filter_var(trim($receiveData['contact_content']), FILTER_SANITIZE_STRING) : '';
        $errorMsg = '';

        if (!$receiveData['store_id']) {
            $errorMsg = '店家名稱不得為空白';
        } elseif (!$receiveData['product_id']) {
            $errorMsg = '回報的商品資料異常，請重新再試';
        } elseif (!$receiveData['full_name']) {
            $errorMsg = '請填寫通報人姓名';
        } elseif (!$receiveData['email']) {
            $errorMsg = '請填寫通報人EMAIL';
        } elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $receiveData['email'])) {
            $errorMsg = '通報人EMAIL格式錯誤';
        } elseif (!$receiveData['mobile_phone']) {
            $errorMsg = '請填寫通報人手機';
        } elseif (!preg_match('/09[0-9]{8}/', $receiveData['mobile_phone'])) {
            $errorMsg = '通報人手機格式錯誤';
        } elseif (!$receiveData['contact_content']) {
            $errorMsg = '請填寫洗單描述';
        }

        if (!empty($errorMsg)) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => $errorMsg,
            ];
        }

        $result = $this->apiService->curl('contact-violations-send', 'POST', $receiveData);

        if (empty($result)) {
            $result = [
                'return_code' => self::UNUSUAL_ERROR_CODE,
                'description' => '異常狀況',
            ];
        }

        return $result;
    }

    /**
     * 價高通報
     * @param object data 相關資訊
     * @return array
     */
    public function storeHighPrice(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('data'))) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
        }

        // 過濾參數
        $jsonData = empty($request->input('data', '')) ? '' : $request->input('data', '');
        $receiveData = json_decode($jsonData, true);
        if (empty($receiveData) || !is_array($receiveData)) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        // 參數型態驗證
        $validationResult = $this->paramsValidation(self::TYPE_PRICE, $receiveData);
        if (!empty($validationResult)) {
            return [
                'return_code' => self::VALIDATION_ERROR_CODE,
                'description' => $validationResult,
            ];
        }

        $receiveData['product_id'] = filter_var(trim($receiveData['product_id'] ?? 0), FILTER_VALIDATE_INT);
        $receiveData['sp_flag'] = filter_var(trim($receiveData['sp_flag'] ?? 0), FILTER_VALIDATE_INT);
        $receiveData['sp_id'] = filter_var(trim($receiveData['sp_id'] ?? 0), FILTER_VALIDATE_INT);
        $receiveData['web_url'] = filter_var(urldecode(trim($receiveData['web_url'] ?? '')), FILTER_VALIDATE_URL);
        $receiveData['price'] = filter_var(trim(urldecode($receiveData['price'] ?? 0)), FILTER_VALIDATE_INT);
        $receiveData['contact_content'] = filter_var(trim($receiveData['contact_content'] ?? ''), FILTER_SANITIZE_STRING);
        $receiveData['full_name'] = filter_var(urldecode(trim($receiveData['full_name'] ?? '')), FILTER_SANITIZE_STRING);
        $receiveData['email'] = filter_var(trim($receiveData['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $receiveData['mobile_phone'] = filter_var(trim($receiveData['mobile_phone'] ?? ''), FILTER_SANITIZE_STRING);
        $errorMsg = '';

        if (!$receiveData['product_id']) {
            $errorMsg = '回報的商品資料異常，請重新整理';
        } elseif (1 == $receiveData['sp_flag'] && !$receiveData['sp_id']) {
            $errorMsg = '請選擇子方案';
        } elseif (!$receiveData['web_url']) {
            $errorMsg = '請填寫比價網網址';
        } elseif (!$receiveData['price']) {
            $errorMsg = '請填寫比價網站價錢';
        } elseif (!$receiveData['contact_content']) {
            $errorMsg = '請填寫比價條件';
        } elseif (!$receiveData['full_name']) {
            $errorMsg = '請填寫通報人姓名';
        } elseif (!$receiveData['email']) {
            $errorMsg = '請填寫通報人EMAIL';
        } elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $receiveData['email'])) {
            $errorMsg = '通報人EMAIL格式錯誤';
        } elseif (!$receiveData['mobile_phone']) {
            $errorMsg = '請填寫通報人手機';
        } elseif (!preg_match('/09[0-9]{8}/', $receiveData['mobile_phone'])) {
            $errorMsg = '通報人手機格式錯誤';
        }

        if (!empty($errorMsg)) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => $errorMsg,
            ];
        }

        $result = $this->apiService->curl('contact-highprice-send', 'POST', $receiveData);

        if (empty($result)) {
            $result = [
                'return_code' => self::UNUSUAL_ERROR_CODE,
                'description' => '異常狀況',
            ];
        }

        return $result;
    }

    /**
     * 錯誤回報
     * @param int    $storeId             店家編號
     * @param int    $branchId            分店編號
     * @param int    $reportType          回報類型
     * @param string $branchAddress       地址更正
     * @param string $branchBusinessHours 營業資訊更正
     * @return array
     */
    public function errorReport(Request $request)
    {
        // 參數型態驗證
        $validationResult = $this->paramsValidation(self::TYPE_REPORT, $request->all());
        if (!empty($validationResult)) {
            return [
                'return_code' => self::VALIDATION_ERROR_CODE,
                'description' => $validationResult,
            ];
        }

        // 過濾參數
        $storeId = htmlspecialchars(trim($request->input('storeId', 0)));
        $branchId = htmlspecialchars(trim($request->input('branchId', 0)));
        $reportType = htmlspecialchars(trim($request->input('reportType', 0)));
        $branchAddress = htmlspecialchars(trim($request->input('branchAddress', '')));
        $branchBusinessHours = htmlspecialchars(trim($request->input('branchBusinessHours', '')));

        // 檢查參數
        if (empty($storeId)) {
            return [
                'return_code' => self::STORE_ID_ERROR_CODE,
                'description' => '缺少參數！',
            ];
        }
        switch ($reportType) {
            case Config::get('store.errorReport.close'):
                $branchAddress = '';
                $branchBusinessHours = '';
                break;
            case Config::get('store.errorReport.address'):
                $branchBusinessHours = '';
                if (empty($branchAddress)) {
                    return [
                        'return_code' => self::ADDRESS_ERROR_CODE,
                        'description' => '缺少參數！',
                    ];
                }
                break;
            case Config::get('store.errorReport.businessHours'):
                $branchAddress = '';
                if (empty($branchBusinessHours)) {
                    return [
                        'return_code' => self::BUSINESS_HOURS_ERROR_CODE,
                        'description' => '缺少參數！',
                    ];
                }
                break;
            default:
                return [
                    'return_code' => self::REPORT_TYPE_ERROR_CODE,
                    'description' => '缺少參數！',
                ];
        }

        // call ccc api
        $curlParam = [
            'store_id' => $storeId,
            'branch_id' => $branchId,
            'report_type' => $reportType,
            'branch_address' => $branchAddress,
            'branch_business_hours' => $branchBusinessHours,
            'ip' => $request->ip(),
        ];
        $result = $this->apiService->curl('store-error-report', 'GET', $curlParam);

        return $result;
    }

    /**
     * 參數驗證
     * @param string $type       類型
     * @param array  $requestAry 參數陣列
     * @return string 錯誤訊息
     */
    private function paramsValidation($type, $requestAry = [])
    {
        $input = []; // 檢查的參數
        $rules = []; // 檢查規則
        $messages = []; // 驗證的錯誤訊息

        switch ($type) {
            case self::TYPE_VIOLATION:
                // 檢查的參數
                $input = [
                    'storeId' => $requestAry['store_id'] ?? 0,
                    'productId' => $requestAry['product_id'] ?? 0,
                    'fullName' => $requestAry['full_name'] ?? '',
                    'email' => $requestAry['email'] ?? '',
                    'mobilePhone' => $requestAry['mobile_phone'] ?? 0,
                    'contactContent' => $requestAry['contact_content'] ?? '',
                ];

                // 檢查規則
                $rules = [
                    'storeId' => 'numeric|gte:0',
                    'productId' => 'numeric|gte:0',
                    'fullName' => 'string',
                    'email' => 'email',
                    'mobilePhone' => 'numeric',
                    'contactContent' => 'string',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'storeId.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.storeIdNumeric')),
                    'storeId.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.storeIdGte')),
                    'productId.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.productIdNumeric')),
                    'productId.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.productIdGte')),
                    'fullName.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.fullNameString')),
                    'email.email' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.emailEmail')),
                    'mobilePhone.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.mobilePhoneNumeric')),
                    'contactContent.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.contactContentString')),
                ];
                break;
            case self::TYPE_PRICE:
                // 檢查的參數
                $input = [
                    'productId' => $requestAry['product_id'] ?? 0,
                    'spFlag' => $requestAry['sp_flag'] ?? 0,
                    'spId' => $requestAry['sp_id'] ?? 0,
                    'webUrl' => $requestAry['web_url'] ?? '',
                    'price' => $requestAry['price'] ?? 0,
                    'contactContent' => $requestAry['contact_content'] ?? '',
                    'fullName' => $requestAry['full_name'] ?? '',
                    'email' => $requestAry['email'] ?? '',
                    'mobilePhone' => $requestAry['mobile_phone'] ?? 0,
                ];

                // 檢查規則
                $rules = [
                    'productId' => 'numeric|gte:0',
                    'spFlag' => 'numeric|gte:0',
                    'spId' => 'numeric|gte:0',
                    'webUrl' => 'string',
                    'price' => 'numeric|gte:0',
                    'contactContent' => 'string',
                    'fullName' => 'string',
                    'email' => 'email',
                    'mobilePhone' => 'numeric',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'productId.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.productIdNumeric')),
                    'productId.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.productIdGte')),
                    'spFlag.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.spFlagNumeric')),
                    'spFlag.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.spFlagGte')),
                    'spId.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.spIdNumeric')),
                    'spId.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.spIdGte')),
                    'webUrl.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.webUrlString')),
                    'price.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.priceNumeric')),
                    'price.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.priceGte')),
                    'contactContent.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.contactContentString')),
                    'fullName.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.fullNameString')),
                    'email.email' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.emailEmail')),
                    'mobilePhone.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.mobilePhoneNumeric')),
                ];
                break;
            case self::TYPE_REPORT:
                // 檢查的參數
                $input = [
                    'storeId' => $requestAry['storeId'] ?? 0,
                    'branchId' => $requestAry['branchId'] ?? 0,
                    'reportType' => $requestAry['reportType'] ?? 0,
                    'branchAddress' => $requestAry['branchAddress'] ?? '',
                    'branchBusinessHours' => $requestAry['branchBusinessHours'] ?? '',
                ];

                // 檢查規則
                $rules = [
                    'storeId' => 'numeric|gte:0',
                    'branchId' => 'numeric|gte:0',
                    'reportType' => 'numeric|gte:0',
                    'branchAddress' => 'string',
                    'branchBusinessHours' => 'string',
                ];

                // 驗證的錯誤訊息
                $messages = [
                    'storeId.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.storeIdNumeric')),
                    'storeId.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.storeIdGte')),
                    'branchId.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.branchIdNumeric')),
                    'branchId.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.branchIdGte')),
                    'reportType.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.reportTypeNumeric')),
                    'reportType.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.reportTypeGte')),
                    'branchAddress.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.branchAddressString')),
                    'branchBusinessHours.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.branchBusinessHoursString')),
                ];
                break;
        }

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors(); // 驗證錯誤訊息
            $inspectParams = array_keys($input); // 檢查對象
            foreach ($inspectParams as $inspect) {
                // 該項目錯誤訊息內容不為空
                if (!empty($errors->get($inspect)[0])) {
                    return $errors->get($inspect)[0];
                }
            }
        }
        return '';
    }
}
