<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\JsonldService;
use Mews\Captcha\Captcha;
use Config;

class ContactController extends Controller
{
    const TYPE_CONTACT = 'contact';
    const TYPE_MESSAGE = 'message';

    protected $apiService;
    protected $captcha;
    protected $jsonldService;

    public function __construct(ApiService $apiService, Captcha $captcha, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->captcha = $captcha;
        $this->jsonldService = $jsonldService;
    }

    /*
     * 聯絡我們
     */
    public function __invoke(Request $request, $id = 11)
    {
        $id = (isset($_GET['ticket_cat_id'])) ? htmlspecialchars(trim($_GET['ticket_cat_id'])) : (int) $id;
        $uinfo = htmlspecialchars(trim($request->input('uinfo', '')));
        $isApp = $this->checkFromMobileApp() || (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'gomaji-app') !== false);

        // 參數驗證
        $this->paramsValidation(self::TYPE_CONTACT, ['id' => $id]); // 參數驗證
        $data = $this->defaultPageParam(false);
        $curlParam = [];
        $curlWork = $this->apiService->curl('contact-info', 'GET', $curlParam); // apiService
        if (!empty($curlWork['data']) && $curlWork['return_code'] == 0000) {
            $settingData = $curlWork['data'] ?? [];
            $idCheck = array_column($settingData['items'], 'ticket_category_id');
            if (!in_array($id, $idCheck)) {
                $this->warningAlert('操作錯誤', '/');
            }
            // 如果行銷合作與媒體公關在第一項，移動到最後面
            if ($settingData['items'][0]['ticket_category_id'] == Config::get('contact.id.media')) {
                $tempAry = array_shift($settingData['items']);
                $settingData['items'][] = $tempAry;
            }
        }


        // ===== 取得預設的訂單資訊 =====
        $contactData = [];
        if (!empty($uinfo)) {
            $apiParam = ['uinfo' => $uinfo];
            $apiResult = $this->apiService->curl('purchase-verify', 'POST', $apiParam);
            if (isset($apiResult['return_code'])
                && isset($apiResult['description'])
                && $apiResult['return_code'] != '0000'
            ) {
                $this->warningAlert(
                    sprintf('%s（%s）', $apiResult['description'], $apiResult['return_code']),
                    sprintf('/help/contact/%d', $id)
                );
            }
            $contactData = $apiResult['data'] ?? [];
        }
        // ===== End: 取得預設的訂單資訊 =====


        // ===== 設定預設的訂單資訊 =====
        $data['billNo'] = $contactData['bill_no'] ?? '';
        $data['mobilePhone'] = $contactData['mobile_phone'] ?? '';
        $data['email'] = $contactData['email'] ?? '';
        $data['fullName'] = $contactData['full_name'] ?? '';
        $data['ch'] = $contactData['ticket_category_id'] ?? '';
        $data['mutable'] = empty($data['billNo']) ? 1 : 0; // 如果沒有billNo，代表訂購人姓名＆email&電話號碼可以編輯的
        // ===== End: 設定預設的訂單資訊 =====


        $data['id'] = $id;
        $data['items'] = $settingData['items'] ?? [];
        $data['channels'] = $settingData['channels'] ?? [];
        $data['cities'] = $settingData['cities'] ?? [];
        $data['cityData'] = Config::get('city.districtAndZipcode');

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$isApp;
        $data['isShowHeader'] = !$isApp;
        $data['isShowFooter'] = !$isApp;

        $data['mmTitle'] = '聯絡我們';
        $data['chTitle'] = '聯絡我們';

        // meta
        $data['meta']['title'] = Config::get('meta.contact.title');

        // jsonld
        $data['webType'] = 'contact';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Contact', $data);

        return view('contact.contact', $data);
    }

    /*
     * 客服留言瀏覽頁
     */
    public function message(Request $request)
    {
        $this->paramsValidation(self::TYPE_MESSAGE, $request->all()); // 參數驗證
        $c = htmlspecialchars(trim($request->input('c', '')));


        // ===== 取得客服留言資訊 =====
        $messageData = [];
        $apiParam = ['c' => $c];
        $apiResult = $this->apiService->curl('ticket-info', 'GET', $apiParam);
        if (isset($apiResult['return_code'])
            && isset($apiResult['description'])
            && $apiResult['return_code'] != '0000'
        ) {
            $this->warningAlert(
                sprintf('%s（%s）', $apiResult['description'], $apiResult['return_code']),
                '/'
            );
        }
        $messageData = $apiResult['data'] ?? [];
        // ===== End: 取得客服留言資訊 =====


        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['mmTitle'] = '客服中心';
        $pageParam['goBack']['link'] = '/help';
        $pageParam['goBack']['text'] = '回上頁';

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        // meta
        $data['meta']['title'] = '客服中心 - 客服留言瀏覽系統 | GOMAJI 最大吃喝玩樂平台';

        // content
        $pageParam['messageList'] = $messageData['list'] ?? [];
        $pageParam['messageStatus'] = $messageData['status'] ?? '';
        $pageParam['messageId'] = $messageData['ticket_id'] ?? 0;
        /* ===== End: 頁面參數 ===== */


        return view('contact.message', $pageParam);
    }

    /**
     * 參數驗證
     * @param string $type       類型
     * @param array  $requestAry 參數陣列
     */
    private function paramsValidation($type, $requestAry = [])
    {
        $input = []; // 檢查的參數
        $rules = []; // 檢查規則
        $messages = []; // 驗證的錯誤訊息

        switch ($type) {
            case self::TYPE_CONTACT:
                $input['id'] = $requestAry['id'] ?? 0;
                $rules['id'] = 'required|numeric|gt:0';
                $messages['id.required'] = '參數錯誤（' . Config::get('errorCode.contactIdEmpty') . '）';
                $messages['id.numeric'] = '參數錯誤（' . Config::get('errorCode.contactIdNumeric') . '）';
                $messages['id.gt'] = '參數錯誤（' . Config::get('errorCode.contactIdGt') . '）';
                break;
            case self::TYPE_MESSAGE:
                $input['c'] = $requestAry['c'] ?? '';
                $rules['c'] = 'required';
                $messages['cityId.required'] = '參數錯誤（' . Config::get('errorCode.cEmpty') . '）';
                break;
        }

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

    /**
     * 重新讀取新的圖形驗證碼
     */
    public function captchaReload(Request $request)
    {
        return captcha_src('flat');
    }
}
