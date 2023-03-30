<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class AccountController extends Controller
{
    protected $apiService;

    // error code
    const MESSAGE_BIRTHDAY_ERROR_CODE = '102';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 會員資料蒐集頁
     */
    public function account(Request $request)
    {
        $apiParam = [
            'gm_uid' => $request->input('gm_uid', 0),
            'action_cd' => $request->input('action_cd', 1),
            'sex_cd' => $request->input('sex_cd', 0),
            'marital_status' => $request->input('marital_status', 0),
            'child' => $request->input('child', 0),
            'city' => $request->input('city', 0),
            'birthday' => $request->input('birthday', date('Y/m/d')),
            'device' => $_COOKIE['account_d'] ?? '',
            'device_id' => $_COOKIE['account_di'] ?? '',
        ];

        // 檢查日期格式
        if (!strtotime($apiParam['birthday'])) {
            return [
                'return_code' => self::MESSAGE_BIRTHDAY_ERROR_CODE,
                'description' => '日期格式錯誤。',
            ];
        }

        $apiHeader = [
            'X-GOMAJI-ID-Token' => $_COOKIE['account_t'] ?? '',
        ];
        $apiResults = $this->apiService->curl('account-subscribe', 'POST', $apiParam, [], $apiHeader);
        return $apiResults;
    }
}
