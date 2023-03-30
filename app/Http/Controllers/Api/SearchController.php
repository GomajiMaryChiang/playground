<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * 刪除搜尋紀錄
     */
    public function delete()
    {
        $expriyTs = time() - Config('setting.cookie.oneHourTs'); // 預設的 cookie 有效時間

        setcookie('search-keywords', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
    }
}
