<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use App\Services\UserVerificationCode;
use App\Services\UserLoginService;
use Config;

class LoginController extends Controller
{
    protected $userVerificationCode;
    protected $userLoginService;

    // no error
    const NO_ERROR = '0000'; // 回傳成功

    // error code
    const PHONE_ERROR_CODE = '104'; // 手機號碼格式錯誤

     // User auth error
    const SEND_SMS_VERIFICATION_FAILED = '3012'; // 發送手機認證簡訊失敗
    const SMS_TRY_IT_LATER = '3027';

    /**
     * Dependency Injection
     */
    public function __construct(UserVerificationCode $userVerificationCode, UserLoginService $userLoginService)
    {
        $this->userVerificationCode = $userVerificationCode;
        $this->userLoginService = $userLoginService;
    }

    /**
     * 發送手機號碼的驗證碼
     * @param string $phone 手機號碼
     * @return array
     */
    public function login(Request $request)
    {
        // 過濾參數
        $phone = htmlspecialchars(trim($request->input('mobile_phone', '')));

        // 檢查參數
        if (!preg_match('/^09[0-9]{8}$/', $phone)) {
            return [
                'return_code' => self::PHONE_ERROR_CODE,
                'description' => '手機號碼格式錯誤！',
            ];
        }

        // 確認簡訊在安全時間內是否已經發送過了
        if ($this->userVerificationCode->isSmsAlreadySent($phone)) {
            return [
                'return_code' => self::SMS_TRY_IT_LATER,
                'description' => '已發送驗證碼，請稍後再嘗試重新發送喔！',
            ];
        }

        $user = $this->userLoginService->login($phone);

//目前剩下這段尚未處理喔！處理完就完成登入這塊了～再來就是註冊(完成這個後～可以做最後的檢查一次就可以進入註冊囉^^)
// 不過可以去查看一下usgai的js部分login後會幹嘛～若有的還要很麻煩也許也可以從註冊開始～或是完成login的東西後再繼續註冊部分喔！
//$user = $loginService->login($mobilePhone);

        $sendResult = $this->userVerificationCode->sendVerificationCodeBySms($user['id'], $phone);
        if (!$sendResult) {
            return [
                'return_code' => self::SEND_SMS_VERIFICATION_FAILED,
                'description' => '發送手機認證簡訊失敗！',
            ];
        }

        return $result = [
            'return_code' => self::NO_ERROR,
            'data' => [
                'id' => (int) $user['id']
            ],
        ];
    } 
}
