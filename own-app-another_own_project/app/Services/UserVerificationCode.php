<?php

namespace App\Services;

//use App\Repositories\ApiRepository;
use App\Services\ApiService;
use App\Models\UserVerification;
use App\Models\NeoSMSInfo;
use Illuminate\Support\Facades\Redis;

class UserVerificationCode
{
    protected $apiService;
    protected $userVerification;
    protected $neoSMSInfo;
    protected $redis;

    // API 簡訊發送相關設定
    const SMS_ACCOUNT = '0934340927'; // 使用者帳號
    const SMS_PWD = 'MS9icwmW9gO3'; // 密碼
    const SMS_MTYPE = 'G'; // 簡訊種類(G:一般簡訊)
    const SMS_ENCODING = 'utf8'; // 簡訊內容的編碼方式(utf8：UTF-8編碼, urlencode：URL編碼, urlencode_utf8：URL與UTF-8編碼)

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, UserVerification $userVerification, NeoSMSInfo $neoSMSInfo, Redis $redis)
    {
        $this->apiService = $apiService;
        $this->userVerification = $userVerification;
        $this->neoSMSInfo = $neoSMSInfo;
        $this->redis = $redis;
    }

    /**
     * 以簡訊送出驗證碼 (包含發送安全紀錄的儲存)
     *
     * @param $uId
     * @param $mobilePhone
     * @return bool|void
     */
    public function sendVerificationCodeBySms($uId, $mobilePhone)
    {
        $code = $this->getVerificationCode($mobilePhone); // 產生4位數驗證碼

        // 更新發送的簡訊資訊的狀態
        $resVerificationRecordStatus = $this->updateVerificationRecordStatus($uId); 
        if ($resVerificationRecordStatus) {
            return false;
        }

        // 新增發送的簡訊資訊並取得簡訊資訊的ID
        $resVerificationRecordId = $this->createVerificationRecord($uId, $code);
        if (!$resVerificationRecordId) {
            return false;
        }

        // 標注特殊白名單是不需要輸入驗證碼的
        $isNeedToSendSms = $this->isNeedSendSms($mobilePhone);
        if (!$isNeedToSendSms) {
            return true;
        }

        $sendResult = $this->sendSms($mobilePhone, $code, $resVerificationRecordId); // 寄送簡訊
        if ($sendResult) {
            $rKey = $this->getVerificationCodeCacheKey($mobilePhone);
            $smsKey = $this->getSmsRecordCacheKey($mobilePhone);
            $this->redis::set($rKey, $smsKey);
            $this->redis::expire($rKey, 300); // 時間設定300秒後過期
            $this->redis::set($smsKey, 1);
            $this->redis::expire($smsKey, 30); // 時間設定30秒後過期
        }
        return $sendResult;
    }

    /**
     * 確認簡訊在安全時間內是否已經發送過了
     *
     * @param $mobilePhone
     * @return bool
     */
    public function isSmsAlreadySent($mobilePhone)
    {
        $isNeedToSendSms = $this->isNeedSendSms($mobilePhone);
        if ($isNeedToSendSms) {
            $smsKey = $this->getSmsRecordCacheKey($mobilePhone);
            $smsRecord = $this->redis::get($smsKey);
            // 驗證碼尚未過期
            if (!empty($smsRecord)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 產生隨機的4位數驗證碼
     *
     * @param $mobilePhone
     * @return string
     */
    private function getVerificationCode($mobilePhone)
    {
        if (in_array($mobilePhone, ['0934340927'])) {
            return '2020';
        }
        return sprintf('%04d', mt_rand(0, 9999));
    }

    /**
     * 更新資料庫該會員的資訊
     *
     * @param $uId
     * @param $verificationCode
     * @return bool
     */
    private function updateVerificationRecordStatus($uId)
    {
        return $this->userVerification::where('u_id', '=', $uId)->update(['flag' => '2']);
    }

    /**
     * 在資料庫儲存下建立的驗證碼
     *
     * @param $uId
     * @param $verificationCode
     * @return bool
     */
    private function createVerificationRecord($uId, $verificationCode)
    {
        $this->userVerification->u_id = $uId; // 會員id
        $this->userVerification->verification_code = $verificationCode; // 4位數驗證碼
        $this->userVerification->create_ts = now()->timestamp; // 建立時間戳

        $this->userVerification->save(); // 新增
        return $this->userVerification->id; // 取得新增的那筆ID
    }

    /*
     * 發送手機認證簡訊
     */
    private function sendSms($mobilePhone, $code, $resVerificationRecordId)
    {
        // call ccc api
        $curlParam = [
            'id' => self::SMS_ACCOUNT,
            'password' => self::SMS_PWD,
            'tel' => $mobilePhone,
            'msg' => '歡迎來到瑪莉的二手playground小小世界，您的驗證碼是' . $code . '，啾咪！',
            'mtype' => self::SMS_MTYPE,
            'encoding' => self::SMS_ENCODING
        ];

        $res = $this->apiService->curl('login', 'POST', $curlParam);

        // 新增米瑟奇媒體API的簡訊回傳資訊
        $this->createNeoSMSInfo($resVerificationRecordId, $res);
        
        // 當回傳的ErrorCode不為正常發送時
        if (strpos(str_replace("\n","",$res), "ErrorCode=0") === false) {
            return false;
        }
        return true;
    }

    /**
     * 在資料庫儲存米瑟奇媒體API的簡訊回傳資訊
     *
     * @param $uId
     * @param $verificationCode
     * @return bool
     */
    private function createNeoSMSInfo($resVerificationRecordId, $errorMsg)
    {
        $this->neoSMSInfo->uv_id = $resVerificationRecordId; // user_verification ID
        $this->neoSMSInfo->error_msg = $errorMsg; // 訊息代碼(詳細可參考「米瑟奇媒體股份有限公司」文件)
        // $this->neoSMSInfo->lcount = $lcount; // 訊息代碼(詳細可參考「米瑟奇媒體股份有限公司」文件)
        // $this->neoSMSInfo->msgID = $msgID000; // 訊息代碼(詳細可參考「米瑟奇媒體股份有限公司」文件)
        // $this->neoSMSInfo->create_at = date('Y-m-d H:i:s'); // 建立時間戳

// 目前create_at的時間可以新增～資料表也可以了～但是create_at的存入時間不對～要查一下原因感覺不是在台灣 是在倫敦之類的

        return $this->neoSMSInfo->save(); // 新增
    }

    /**
     *
     * @param $mobilePhone
     * @return string
     */
    private function getVerificationCodeCacheKey($mobilePhone)
    {
        return 'USER::MOBILE::' . md5($mobilePhone);
    }

    /**
     *
     * @param $mobilePhone
     * @return string
     */
    private function getSmsRecordCacheKey($mobilePhone)
    {
        return 'USER::SMSRECORD::' . md5($mobilePhone);
    }

    /**
     * 標注特殊白名單是不需要輸入驗證碼的
     *
     * @param $mobilePhone
     * @return bool
     */
    private function isNeedSendSms($mobilePhone)
    {
        return !in_array($mobilePhone, ['0934340927']);
    }
}
