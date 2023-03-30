<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class AccountController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function __invoke(Request $request)
    {
        // 如果不是以APP開啟，跳出提醒視窗
        if (!$this->checkFromMobileApp()) {
            $this->warningAlert('請開啟APP參與活動呦～', '/');
        }
        $gmUid = $_COOKIE['gm_uid'] ?? $_SERVER['HTTP_X_GOMAJI_MEMBERID'] ?? 0;
        if ($gmUid == 0) {
            $this->warningAlert('請登入參加活動喔！', 'GOMAJI://mine');
        }

        /* --- Start: APP使用者資訊 --- */
        $idToken = $request->header('t') ?? '';
        $_COOKIE['account_t'] = $idToken;
        setcookie('account_t', $idToken, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        $device = $request->header('X-GOMAJI-DeviceType') ?? '';
        $_COOKIE['account_d'] = $device;
        setcookie('account_d', $device, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        $deviceId = $request->header('X-GOMAJI-DeviceID') ?? '';
        $_COOKIE['account_di'] = $deviceId;
        setcookie('account_di', $deviceId, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        /* --- End: APP使用者資訊 --- */

        /*--- Start: API ---*/
        $apiParam = [
            'gm_uid' => $gmUid,
        ];
        $apiHeader = [
            'X-GOMAJI-ID-Token' => $idToken,
        ];
        $apiResults = $this->apiService->curl('account-info', 'GET', $apiParam, [], $apiHeader);
        if (empty($apiResults) || (isset($apiResults['return_code']) && $apiResults['return_code'] != '0000')) {
            $this->warningAlert(sprintf('操作錯誤 (%s) %s', $apiResults['return_code'], $apiResults['description']), '/');
        }
        /*--- End: API ---*/

        $pageParam = $this->defaultPageParam(false);
        $pageParam['account'] = $apiResults['data'] ?? [];
        $pageParam['isApp'] = $this->checkFromMobileApp();
        $pageParam['cityList'] = Config::get('city.accountCityList');
        $pageParam['chtitle'] = '帳號資料填寫';
        $pageParam['mmTitle'] = '帳號資料填寫'; // mm header 標題
        // meta
        $pageParam['meta']['title'] = Config::get('meta.account.title');
        // app 開啟的不顯示 header & footer
        $pageParam['isShowLightHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowFooter'] = !$this->checkFromMobileApp();

        return view('contact.account', $pageParam);
    }
}
