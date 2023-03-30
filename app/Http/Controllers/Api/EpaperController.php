<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;

class EpaperController extends Controller
{
    protected $apiService;

    // call ccc api 的行為參數
    const ACT_CANCEL = 'follow_cancel';

    // 城市列表：公益、旅遊、宅配購物+ &宅配美食、台北、桃園、新竹、台中、台南、高雄
    const CITY_LIST = ['PublicWelfare', 'Travel', 'Taiwan', 'Taipei', 'Taoyuan', 'Hsinchu', 'Taichung', 'Tainan', 'Kaohsiung'];

    // error code
    const EMAIL_ERROR_CODE = '103';
    const CITY_ERROR_CODE = '104';
    const DATA_ERROR_CODE = '105';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 訂閱電子報
     * @param string $email 欲訂閱的email
     * @param string $city  欲訂閱的城市
     * @return array
     */
    public function subscribe(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('email'))
            || is_array($request->input('city'))
        ) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
        }

        // 過濾參數
        $email = htmlspecialchars(trim($request->input('email', '')));
        $city = htmlspecialchars(trim($request->input('city', '')));

        // 檢查參數
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => 'Email格式錯誤！',
            ];
        }
        if (empty($city) || !in_array($city, self::CITY_LIST)) {
            return [
                'return_code' => self::CITY_ERROR_CODE,
                'description' => '請輸入有效的城市名稱！',
            ];
        }

        // call ccc api
        $curlParam = [
            'email' => $email,
            'city' => $city,
        ];
        $result = $this->apiService->curl('epaper-subscribe', 'GET', $curlParam);

        return $result;
    }

    /**
     * 取消訂閱電子報
     * @param string $email 欲取消訂閱的email
     * @return array
     */
    public function cancel(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('email'))) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
        }

        // 過濾參數
        $email = htmlspecialchars(trim($request->input('email', '')));

        // 檢查參數
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => 'Email格式錯誤！',
            ];
        }

        // call ccc api
        $curlParam = [
            'email' => $email,
            'act' => self::ACT_CANCEL,
        ];
        $result = $this->apiService->curl('epaper-cancel', 'GET', $curlParam);

        return $result;
    }

    /**
     * 更新訂閱電子報
     * @param string $cityList 欲更新的城市列表
     * @param string $session  加密過的email
     * @return array
     */
    public function update(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('email'))
            || is_array($request->input('city'))
        ) {
            return [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
        }

        // 過濾參數
        $cityList = htmlspecialchars(trim($request->input('cityList', '')));
        $session = htmlspecialchars(trim($request->input('session', '')));

        // 檢查參數
        if (empty($session)) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => '缺少email資訊！',
            ];
        }

        // call ccc api
        $curlParam = [
            'subscribe' => $cityList,
            'session' => $session,
        ];
        $result = $this->apiService->curl('member-edm-update', 'POST', $curlParam);

        return $result;
    }
}
