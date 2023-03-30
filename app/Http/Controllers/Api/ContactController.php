<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\ContactService;
use Mews\Captcha\Captcha;
use Config;

class ContactController extends Controller
{
    protected $apiService;
    protected $contactService;

    // error code
    const MESSAGE_ID_ERROR_CODE = '101';
    const MESSAGE_CONTENT_ERROR_CODE = '102';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, ContactService $contactService)
    {
        $this->apiService = $apiService;
        $this->contactService = $contactService;
    }

    /**
     * 聯絡我們
     */
    public function contact(Request $request)
    {
        if (!empty($request->input('captcha'))) {
            // 檢查驗證碼 Start
            $rules = [
                'captcha' => 'required|captcha'
            ];
            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails()) {
                return 'Incorrect';
            }
            // 檢查驗證碼 End

            $postData = [];
            $json = $request->input('json');
            parse_str($request->input('json'), $postData);

            // 檢驗
            $reCaptchaToken = $postData['token'] ?? "";
            $reCaptchaParams = [
                'secret' => config('contact.recaptcha_secret', ''),
                'response' => $reCaptchaToken,
            ];
            $reCaptchaCurlWork = $this->apiService->curl(
                'https://www.google.com/recaptcha/api/siteverify',
                'POST',
                $reCaptchaParams
            );
            if (!$this->parseReCaptchaResponse($reCaptchaCurlWork)) {
                $postData['recaptcha'] = $reCaptchaCurlWork;
                $logMessage = json_encode($postData);
                app('log')->error("recaptcha error: " . $logMessage, [
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                ]);
                return "robot";
            }

            $keysAndType = $this->contactService->getKeysAndType();


            $curlParam = [];
            foreach ($keysAndType as $key => $type) {
                $curlParam[$key] = (isset($postData[$key])) ? $postData[$key] : $this->contactService->getDefaultValByType($type);
            }
            $curlWork = $this->apiService->curl('insert-contact', 'POST', $curlParam);

            return $curlWork['return_code'] ?? '';
        }
        return 'Incorrect';
    }

    /**
     * 回覆客服留言
     * @param int    $messageId      留言編號
     * @param string $messageContent 留言內容
     * @return array
     */
    public function message(Request $request)
    {
        // 過濾參數
        $messageId = htmlspecialchars(trim($request->input('messageId', '')));
        $messageContent = htmlspecialchars(trim($request->input('messageContent', '')));

        // 檢查參數
        if (empty($messageId)) {
            return [
                'return_code' => self::MESSAGE_ID_ERROR_CODE,
                'description' => '缺少參數！',
            ];
        }
        if (empty($messageContent)) {
            return [
                'return_code' => self::MESSAGE_CONTENT_ERROR_CODE,
                'description' => '缺少參數！！',
            ];
        }

        // call ccc api
        $curlParam = [
            'ticket_id' => (int) $messageId,
            'contact_content' => $messageContent,
        ];
        $result = $this->apiService->curl('insert-ticket-info', 'POST', $curlParam);

        return $result;
    }

    /**
     * 檢查驗證碼
     */
    public function testCaptcha(Request $request)
    {
        if (!empty($request->input('captcha'))) {
            // 檢查驗證碼 Start
            $rules = [
                'captcha' => 'required|captcha'
            ];
            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails()) {
                return 'Incorrect';
            }
            return '0000';
            // 檢查驗證碼 End
        }
    }

    /**
     * @param $response
     * @return bool
     */
    private function parseReCaptchaResponse($response)
    {
        if (empty($response)) {
            return false;
        }

        // google會檢驗token是否過期或有其他狀態，如果有，success = false
        $success = $response['success'] ?? false;
        if (!$success) {
            return false;
        }

        // score是服務判別用戶是否為機器人的做法
        // 數值為1.0 ~ 0.0之間，官方建議
        $score = $response['score'] ?? 0;
        if ($score < 0.5) {
            return false;
        }

        return true;
    }
}
