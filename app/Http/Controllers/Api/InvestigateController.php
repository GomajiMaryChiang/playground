<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;

class InvestigateController extends Controller
{
    protected $apiService;

    // error code
    const EMAIL_ERROR_CODE = '103';

    const IDENTIFY_ERROR_CODE = '2002';
    const SEX_ERROR_CODE = '2004';
    const BIRTH_ERROR_CODE = '2005';
    const PLACE_ERROR_CODE = '2006';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 參加創市際問券調查 基本資料填寫頁
     * @param string $email email
     * @param int $sexCd 性別
     * @param string $birthday 生日
     * @param int $prefCd  居住地
     * @return array
     */
    public function attend(Request $request)
    {
        // 過濾參數
        $email = empty($request->input('email', '')) ? '' : htmlspecialchars(trim($request->input('email', '')));
        $sexCd = empty($request->input('sexCd', '')) ? 0 : htmlspecialchars(trim($request->input('sexCd', '')));
        $birthday = empty($request->input('birthday', '')) ? '' : htmlspecialchars(trim($request->input('birthday', '')));
        $prefCd = empty($request->input('prefCd', '')) ? 0 : htmlspecialchars(trim($request->input('prefCd', '')));
        $gmUid    = '';
        $deviceId = '';
        $device   = '';

        // 取得使用者手機資訊
        $this->getMobileInfo($gmUid, $deviceId, $device);
        
        // 檢查參數是否為空
        if (empty($gmUid) || empty($deviceId) || empty($device)) {
            return [
                'return_code' => self::IDENTIFY_ERROR_CODE,
                'description' => '請使用APP參與活動呦～',
            ];
        }

        // 檢查信箱參數
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => 'Email格式錯誤！',
            ];
        }
      
        // 檢查性別欄位
        if (!in_array($sexCd, array('1', '2'))) {
            return [
                'return_code' => self::SEX_ERROR_CODE,
                'description' => '請填寫性別呦～',
            ];
        }
        
        // 檢查生日欄位
        if (strtotime(date('Y-m-d', strtotime($birthday))) !== strtotime($birthday)) {
            return [
                'return_code' => self::BIRTH_ERROR_CODE,
                'description' => '生日格式有誤，請再檢查一下呦～',
            ];
        }

        // 檢查居住地
        if (empty($prefCd)) {
            return [
                'return_code' => self::PLACE_ERROR_CODE,
                'description' => '請填寫居住地呦～',
            ];
        }
     
        // call ccc api
        $curlParam = [
            'gm_uid'    => $gmUid,
            'device_id' => $deviceId,
            'device'    => $device,
            'email'     => $email,
            'sex_cd'    => $sexCd,
            'birthday'  => date('Y-m-d', strtotime($birthday)),
            'pref_cd'   => $prefCd,
        ];
        $result = $this->apiService->curl('insight-xplorer-subscribe', 'POST', $curlParam);

        return $result;
    }

    /**
     * 取消參加創市際問券調查 基本資料填寫頁
     * @return array
     */
    public function cancel(Request $request)
    {
        $gmUid    = '';
        $deviceId = '';
        $device   = '';
        
        // 取得使用者手機資訊
        $this->getMobileInfo($gmUid, $deviceId, $device);
        
        // 檢查參數是否為空
        if (empty($gmUid) || empty($deviceId) || empty($device)) {
            return [
                'return_code' => self::IDENTIFY_ERROR_CODE,
                'description' => '請使用APP參與活動呦～',
            ];
        }

        // call ccc api
        $curlParam = [
            'gm_uid'    => $gmUid,
        ];
        $result = $this->apiService->curl('insight-xplorer-unsubscribe', 'POST', $curlParam);

        return $result;
    }
}
