<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class HealthCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check()
    {
        // 程式碼能執行到這裡就證明php-fpm執行正常
        $description = '';

        // 檢查Redis連線是否正常
        try {
            $client = Redis::connection()->client();
            $pingResult = $client->ping();
            if (!$pingResult) {
                $description = 'can not ping success';
            }
        } catch (\Exception $e) {
            $description = $e->getTraceAsString();
        }

        // 不正常回吐錯誤
        if (!empty($description)) {
            return response([
                'return_code' => '1010',
                'description' => $description,
            ], 500);
        }

        return response([
            'return_code' => '0000',
            'description' => '',
        ]);
    }

}
