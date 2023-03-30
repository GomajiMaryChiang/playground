<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use Config;

class LoginController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService, EventService $eventService)
    {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
    }

    /*
     * 登入頁
     */
    public function __invoke(Request $request)
    {
        $date = $this->eventService->getTime($request->input('date', date('Y-m-d H:i:s'))); // 測試用的日期參數
        $goto = htmlspecialchars(trim($request->input('goto', Config::get('setting.usagiDomain'))));


        /* ===== 導頁參數的網域如非指定的網域，則登入後導回首頁 ===== */
        $gotoAry = parse_url($goto);
        $gotoHost = $gotoAry['host'] ?? '';
        $gotoPath = $gotoAry['path'] ?? '';


        /* ===== 導頁參數的網域如非指定的網域，則登入後導回首頁 ===== */
        $gomajiPattern = '/^([\w\.\-])+.gomaji.com$/';
        $esmarketPattern = '/^([\w\.\-])+.trippacker.com.tw$/';
        $shopifyPattern = '/^([\w\.\-])+myshopify.com$/';
        $linePattern = '/^\/event\/pcode\/coupon93([\w\.\-])+$/';

        if (!preg_match($gomajiPattern, $gotoHost)
            && !preg_match($esmarketPattern, $gotoHost)
            && !preg_match($shopifyPattern, $gotoHost)
            && !preg_match($linePattern, $gotoPath)
        ) {
            $goto = Config::get('setting.usagiDomain');
        }
        /* ===== End: 導頁參數的網域如非指定的網域，則登入後導回首頁 ===== */


        /* ===== 導頁參數的網域如為指定的網域，則登入後導回首頁 ===== */
        $buy123Pattern = '/^(buy123|mbuy123|appbuy123).gomaji.com$/';

        if (preg_match($buy123Pattern, $gotoHost)
            && $date >= '2023-04-01 00:00:00'
        ) {
            $goto = Config::get('setting.usagiDomain');
        }
        /* ===== End: 導頁參數的網域如為指定的網域，則登入後導回首頁 ===== */


        /* ===== 取判斷是否登入用的 Cookie 值 ===== */
        $cookieAry = [
            't' => $_COOKIE['t'] ?? '',
            'gb_el' => $_COOKIE['gb_el'] ?? '',
            'gb_sel' => $_COOKIE['gb_sel'] ?? '',
        ];
        /* ===== End: 取判斷是否登入用的 Cookie 值 ===== */


        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['mmTitle'] = '登入';
        $pageParam['goBack']['text'] = '';
        $pageParam['isShowMicroHeader'] = true;

        // content
        $pageParam['goto'] = $goto; // 登入後導頁的網址
        $pageParam['cookieAry'] = $cookieAry; // 判斷是否登入用的 Cookie 值
        /* ===== End: 頁面參數 ===== */

        return view('main.login.index', $pageParam);
    }
}
