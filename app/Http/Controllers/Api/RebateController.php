<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;

class RebateController extends Controller
{
    protected $apiService;

    // error code
    const DATA_ERROR_CODE = '3000';
    const UNUSUAL_ERROR_CODE = '3001';
    const FAIL_ERROR_CODE = '3002';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 登記註冊
     * @param object data 相關資訊
     * @return array
     */
    public function signup(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('t')) || is_array($request->input('gm_uid'))) {
            $result = [
                'return_code' => self::FAIL_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
            return $result;
        }

        // 過濾參數
        $t = htmlspecialchars(trim($request->input('t', '')));
        $gmUid = htmlspecialchars($request->input('gm_uid', 0));

        if (empty($t) || empty($gmUid)) {
            $result = [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        // call ccc api
        $curlParam = [
            'gm_uid' => $gmUid,
            't' => $t,
        ];

        $result = $this->apiService->curl('signup', 'POST', $curlParam);

        if (empty($result)) {
            $result = [
                'return_code' => self::UNUSUAL_ERROR_CODE,
                'description' => '異常狀況',
            ];
        }

        return $result;
    }
}
