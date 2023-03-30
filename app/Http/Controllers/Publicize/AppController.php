<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\JsonldService;
use Config;

// 定義簡訊文字內容
define('APP_DOWNLOAD_WORD', '立即下載GOMAJI APP，輸入邀請碼 【GOMAJI】 現賺$100  https://gmj.tw/ZEm6N');
// 定義簡訊類型
define('APP_DOWNLOAD_LINK', '8');

class AppController extends Controller
{
    protected $jsonldService;

    /**
     * Dependency Injection
     */
    public function __construct(JsonldService $jsonldService)
    {
        $this->jsonldService = $jsonldService;
    }

    public function __invoke(Request $request)
    {
        $data['code'] = $request->input('code') ?? 'GOMAJI'; // 邀請碼

        // jsonld
        $jsonldData = [
            'pageTitle' => '下載 APP',
            'pageUrl' => sprintf('%s%s', Config::get('setting.usagiDomain'), $this->filterQueryUri()),
        ];
        $data['jsonld'] = $this->jsonldService->getJsonldData('App', $jsonldData);

        return view('publicize.app', $data);
    }

    /**
     * 寄送APP下載簡訊
     * @return boolean
    */
    public function sendAppSms()
    {
        // 阻擋參數為陣列的內容值
        if (is_array($_POST['mobile_phone'])) {
            return false;
        }

        $mobile_phone = $_POST['mobile_phone']; // 手機號碼
        $sms_body = urlencode(APP_DOWNLOAD_WORD); // 簡訊文字內容
        $src_id = APP_DOWNLOAD_LINK; // 簡訊類型
        $mobileNumber = trim($mobile_phone);

        if (0 == preg_match("/^09\d{8}$/", $mobileNumber)) {
            return false;
        }

        $params = array(
            'agent' => '',
            'mobile_phone' => $mobileNumber,
            'src_id' => $src_id,
            'smbody' => APP_DOWNLOAD_WORD
        );

        $headers = [
            'Authorization: Bearer eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ==.eyJpc3MiOiJHT01BSkkiLCJsYXQiOjE1NDYyNzIwMDAsImV4cCI6MTYwOTQzMDQwMCwidWlkIjoid3d3LmdvbWFqaS5jb20ifQ==.4e23bad19bcd85eb224e4a8670c30b2ea9d4458b1cc35ddcbcd2c5a9d801718b'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, 'https://ccc.gomaji.com/redirect/send-sms');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, 'www.gomaji.com');
        $buffer = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($buffer);
        if ($result && $result->status == 'SUCCESS') {
            return true;
        } else {
            return false;
        }
    }
}
