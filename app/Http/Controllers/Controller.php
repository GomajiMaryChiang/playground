<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Config;
use Mobile_Detect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 警告訊息
    protected function warningAlert($msg, $url = '', $guarantee = false, $metaAry = [])
    {
        $toGoScript = '';
        if (empty($url)) {
            $toGoScript = 'history.go(-1);';
        } else {
            $toGoScript = 'location.href="' . $url . '";';
        }

        // 設定 http 狀態碼
        http_response_code(404);

        // 錯誤訊息需多回傳 meta，為了讓 fb line 爬的到
        $meta = '';
        if (!empty($metaAry)) {
            $title = (!empty($metaAry['title']) ? $metaAry['title'] : 'GOMAJI夠麻吉 | 團購、美食、旅遊、SPA、折扣、優惠、好康 | 最大吃喝玩樂平台');
            $siteName = (!empty($metaAry['siteName']) ? $metaAry['siteName'] : 'GOMAJI夠麻吉 | 團購、美食、旅遊、SPA、折扣、優惠、好康 | 最大吃喝玩樂平台');
            $url = (!empty($metaAry['url']) ? $metaAry['url'] : 'https://www.gomaji.com/');
            $image = (!empty($metaAry['image']) ? $metaAry['image'] : 'https://staticdn.gomaji.com/ch_pic/gomaji-com.jpg');
            $description = (!empty($metaAry['description']) ? $metaAry['description'] : '5折起 ! 優惠餐券、住宿券、SPA按摩券、門票展覽、摩鐵泡湯休息券、五星飯店Buffet 、燒烤火鍋吃到飽、各式團購優惠券即買即用，GOMAJI夠麻吉全都有！');

            $meta = '<meta property="og:title" content="' . $title . '" />'
                    . '<meta property="og:site_name" content="' . $siteName . '" />'
                    . '<meta property="og:type" content="website" />'
                    . '<meta property="og:url" content="' . $url . '" />'
                    . '<meta property="og:image" content="' . $image . '" />'
                    . '<meta property="og:description" content="' . $description . '" />';
        }

        $script = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' .
                    $meta .
                    '<script>alert("' . (($guarantee)?$msg:addslashes($msg)) . '");' . $toGoScript . '</script>';

        exit($script);
    }

    /**
    * 過濾網址列參數，防止 XSS
    * @return string 已過濾的網址列參數
    */
    protected function filterQueryUri()
    {
        // 如果沒有 GET 參數，直接回傳 URI
        if (empty($_SERVER['QUERY_STRING'])) {
            return $_SERVER['REQUEST_URI'];
        }

        // 取得 uri 及 query
        $requestUriAry = explode('?', $_SERVER['REQUEST_URI']);
        $uri = $requestUriAry[0];
        $queryString = $requestUriAry[1];

        // 過濾每個 query 參數
        $queryAry = explode('&', $queryString);
        $securityQueryAry = array_map(function($query) {
            $query = explode('=', $query);
            return !isset($query[1])
                ? $this->securityFilter($query[0])
                : $this->securityFilter($query[0]) . '=' . $this->securityFilter($query[1]);
        }, $queryAry);
        $securityQueryString = implode('&', $securityQueryAry);

        return sprintf('%s?%s', $uri, $securityQueryString);
    }

    /**
    * 過濾標籤及單雙引號，防止 XSS
    * @param  string  $text  欲過濾的文字
    * @return string         已過濾的文字
    */
    protected function securityFilter($text = '')
    {
        return preg_replace('/%20--%20.*/', '', htmlspecialchars(strip_tags($text), ENT_QUOTES));
    }

    /**
     * 預設的頁面參數
     * @param bool $isGetHotKeywordList 是否取得熱門關鍵字
     * @return array
     */
    protected function defaultPageParam($isGetHotKeywordList = true)
    {
        $pageParam = [];

        // 判斷是否要取得熱門關鍵字
        if ($isGetHotKeywordList) {
            $hotKeywordResult = $this->apiService->curl('hot-keywords', 'GET');
            if (
                isset($hotKeywordResult['return_code'])
                && $hotKeywordResult['return_code'] == '0000'
                && !empty($hotKeywordResult['data'])
            ) {
                $pageParam['hotKeywordList'] = $hotKeywordResult['data'];
            }
        }

        // 已登入 且 無點數資訊 且 無購物金資訊，取得用戶資訊
        if (!empty($_COOKIE['t']) && !isset($_COOKIE['u_p']) && !isset($_COOKIE['u_b'])) {
            $headerParam = [
                'Authorization' => sprintf('Bearer %s', $_COOKIE['t']),
            ];
            $userInfoResult = $this->apiService->curl('get-user-info', 'GET', [], [], $headerParam);

            // 判斷是否成功取得用戶資訊
            if (isset($userInfoResult['return_code'])
                && $userInfoResult['return_code'] == '0000'
                && !empty($userInfoResult['data'])
            ) {
                $info = $userInfoResult['data']['email'] ?? $userInfoResult['data']['mobile'] ?? ''; // 用戶的資訊
                $point = $userInfoResult['data']['points'] ?? 0; // 點數
                $bonus = $userInfoResult['data']['bonus'] ?? 0; // 購物金
                $expriyTs = time() + Config('setting.cookie.oneMinuteTs') * 5; // 預設五分鐘的 cookie 有效時間

                session(['userInfo' => $info]);
                setcookie('u_p', $point, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
                setcookie('u_b', $bonus, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
                $_COOKIE['u_p'] = $point;
                $_COOKIE['u_b'] = $bonus;
            } else {
                $pageParam['autoLogout'] = '請重新登入～'; // 自動登出的訊息
            }
        }

        // 登入資訊
        $pageParam['isLoggedIn'] = !empty($_COOKIE['t']); // 是否已登入
        $pageParam['userInfo'] = session('userInfo', ''); // 用戶的資訊
        $pageParam['userPoint'] = $_COOKIE['u_p'] ?? 0; // 用戶的點數
        $pageParam['userBonus'] = $_COOKIE['u_b'] ?? 0; // 用戶的購物金

        // 預設不顯示 mm header sidemenu
        $pageParam['isShowSidemenu'] = false;

        // 預設 mm header “上一頁”按鈕的文字及連結
        $pageParam['goBack']['link'] = '/';
        $pageParam['goBack']['text'] = '回首頁';

        // 預設顯示非簡化的 header 及 footer
        $pageParam['isShowMicroHeader'] = false;
        $pageParam['isShowLightHeader'] = false;
        $pageParam['isShowHeader'] = true;
        $pageParam['isShowFooter'] = true;

        // 目前年份，用於 footer -> copyright 部分
        $pageParam['currentYear'] = date('Y');

        // 預設 canonical 值
        $pageParam['meta']['canonicalUrl'] = sprintf(Config::get('setting.usagiDomain') . '%s', $this->filterQueryUri());

        // 因 cookie 的 httpOnly = true，JS 無法存取 cookie，所以在 server 端取 cookie 的值
        $pageParam['searchKeywords'] = $_COOKIE['search-keywords'] ?? ''; // 搜尋紀錄
        $pageParam['gcCity'] = $_COOKIE['gc_city'] ?? 0; // 城市編號
        $pageParam['gmcSitePay'] = $_COOKIE['gmc_site_pay'] ?? ''; // 返利網

        return $pageParam;
    }

    /**
    * 判斷是否為app開啟
    * @return bool
    */
    protected function checkFromMobileApp()
    {
        $this->setMobileAppCookie();
        $detect = new Mobile_Detect();
        if ($detect->isMobile()
            && ! $detect->isTablet()
            && ((
                    ! empty($_SERVER['HTTP_X_GOMAJI_DEVICETYPE'])
                    && ! empty($_SERVER['HTTP_X_GOMAJI_VERSION'])
                    && ! empty($_SERVER['HTTP_X_GOMAJI_DEVICEID'])
                )
                || (
                    ! empty($_COOKIE['cmd'])
                    && ! empty($_COOKIE['version'])
                )
            )) {
            $_COOKIE['fromMobileApp'] = time();
            setcookie('fromMobileApp', time(), 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
            return true;
        }
        return false;
    }

    /**
     * 將APP的資訊存入cookie
     * (cmd, version, device_id, gm_uid)
     */
    protected function setMobileAppCookie()
    {
        if (!empty($_GET['cmd'])) {
            $cmd = $this->securityFilter($_GET['cmd']);
            $_COOKIE['cmd'] = $cmd;
            setcookie('cmd', $cmd, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        }
        if (!empty($_GET['version'])) {
            $version = $this->securityFilter($_GET['version']);
            $_COOKIE['version'] = $version;
            setcookie('version', $version, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        }
        if (!empty($_GET['device_id'])) {
            $deviceId = $this->securityFilter($_GET['device_id']);
            $_COOKIE['device_id'] = $deviceId;
            setcookie('device_id', $deviceId, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        }
        if (!empty($_SERVER['HTTP_X_GOMAJI_MEMBERID'])) {
            $gmUid = $this->securityFilter($_SERVER['HTTP_X_GOMAJI_MEMBERID']);
            $_COOKIE['gm_uid'] = $gmUid;
            setcookie('gm_uid', $gmUid, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        }
    }

    /**
     * 將使用者手機的相關資訊存至cookie
     * @return bool
     * */
    protected function setMobileInfo()
    {
        $gmUid    = $_SERVER['HTTP_X_GOMAJI_MEMBERID'] ?? 0;
        $deviceId = $_SERVER['HTTP_X_GOMAJI_DEVICEID'] ?? '';
        $device   = $_SERVER['HTTP_X_GOMAJI_DEVICETYPE'] ?? '';

        // 手機過來的用戶只要 header 有值就可以取 gmuid
        if (! empty($gmUid) && is_numeric($gmUid) && ! empty($deviceId) && ! empty($device)) {
            $ts = time();
            $token = md5(sprintf('in%sfor%s%smat%sion', $gmUid, $deviceId, $device, $ts));
            setcookie('m', $gmUid, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
            setcookie('di', $deviceId, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
            setcookie('d', $device, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
            setcookie('s', $ts, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
            setcookie('t', $token, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
            return true;
        }

        return false;
    }

    /**
     * 取得使用者手機資訊
     * @param string gmUid    會員編號
     * @param string deviceId 裝置編號
     * @param string device   裝置類型
     */
    protected function getMobileInfo(&$gmUid, &$deviceId, &$device)
    {
        if (! empty($_COOKIE['m'])
            && ! empty($_COOKIE['s'])
            && ! empty($_COOKIE['t'])
            && ! empty($_COOKIE['d'])
            && ! empty($_COOKIE['di'])
            && is_numeric($_COOKIE['m'])
            && is_numeric($_COOKIE['s'])) {

            $token = md5(sprintf('in%sfor%s%smat%sion', $_COOKIE['m'], $_COOKIE['di'], $_COOKIE['d'], $_COOKIE['s']));
            // 檢查 token 是否正確
            if ($token == $_COOKIE['t']) {
                $gmUid    = $_COOKIE['m'];
                $deviceId = $_COOKIE['di'];
                $device   = $_COOKIE['d'];
            }
        }
    }
}
