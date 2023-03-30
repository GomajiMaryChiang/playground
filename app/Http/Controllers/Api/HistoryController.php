<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;

class HistoryController extends Controller
{
    protected $apiService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 訂單查詢
     */
    public function history(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request -> email) || is_array($request -> duration)) {
            echo json_encode(['err_no' => '2113', 'msg' => '錯誤參數來源']);
            return;
        }

        $email = (string) $request -> email;
        $duration = (string) $request -> duration;

        if (empty($email)) {
            echo json_encode(['err_no' => '2111', 'msg' => '缺少必要參數']);
            return;
        }

        if (empty($duration)) {
            echo json_encode(['err_no' => '2111', 'msg' => '缺少必要參數']);
            return;
        }

        // 查詢日期類型
        if ($duration != '3' && $duration != '6' && $duration != '12') {
            echo json_encode(['err_no' => '2111', 'msg' => '缺少必要參數']);
            return;
        }

        // 驗證email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['err_no' => '2112', 'msg' => 'email格式有誤']);
            return;
        }

        $curlParam = [
            'email' => $email,
            'duration' => $duration,
        ];

        // [客服中心]購買紀錄 Api
        $curlWork = $this->apiService->curl('purchase_history', 'GET', $curlParam);

        return json_encode($curlWork);
    }

    /**
     * 發票歸戶
     */
    public function invoice(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request -> email)) {
            echo json_encode(['err_no' => '2113', 'msg' => '錯誤參數來源']);
            return;
        }

        $email = (string) $request -> email;

        if (empty($email)) {
            echo json_encode(['err_no' => '2111', 'msg' => '缺少必要參數']);
            return;
        }

        // 驗證email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['err_no' => '2112', 'msg' => 'email格式有誤']);
            return;
        }

        $curlParam = [
            'type' => 'map_account',
            'email' => $email,
        ];

        // [客服中心]發票歸戶 Api
        $curlWork = $this->apiService->curl('invoice_map_account', 'GET', $curlParam);

        return json_encode($curlWork);
    }
}
