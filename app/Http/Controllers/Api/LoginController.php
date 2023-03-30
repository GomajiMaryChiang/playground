<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\GmCryptService;
use Config;

class LoginController extends Controller
{
    protected $apiService;
    protected $gmCryptService;

    // 簽章加密的 key
    const SIGN_KEY = 'gomaji_b2a60feefb2f9716cc38ba1b4399a3e';

    // error code
    const EMAIL_ERROR_CODE = '103';
    const PHONE_ERROR_CODE = '104';
    const VERIFY_ERROR_CODE = '105';
    const T_ERROR_CODE = '106';
    const URL_ERROR_CODE = '107';
    const GBSEL_ERROR_CODE = '108';
    const LINE_ID_ERROR_CODE = '109';
    const LINE_NAME_ERROR_CODE = '110';
    const GMUID_ERROR_CODE = '111';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, GmCryptService $gmCryptService)
    {
        $this->apiService = $apiService;
        $this->gmCryptService = $gmCryptService;
    }

    /**
     * 發送手機號碼的驗證碼
     * @param string $phone 手機號碼
     * @return array
     */
    public function login(Request $request)
    {
        // 過濾參數
        $phone = htmlspecialchars(trim($request->input('phone', '')));

        // 檢查參數
        if (!preg_match('/^09[0-9]{8}$/', $phone)) {
            return [
                'return_code' => self::PHONE_ERROR_CODE,
                'description' => '手機號碼格式錯誤！',
            ];
        }

        // call ccc api
        $curlParam = [
            'mobile_phone' => $phone,
        ];
        $headerParam = [
            'Content-Type' => 'application/json',
        ];
        $result = $this->apiService->curl('login', 'POST', $curlParam, [], $headerParam);

        return $result;
    }

    /**
     * 選擇登入的 Email
     * @param string $phone 手機號碼
     * @param string $email
     * @return array
     */
    public function bindEmail(Request $request)
    {
        // 過濾參數
        $phone = htmlspecialchars(trim($request->input('phone', '')));
        $email = htmlspecialchars(trim($request->input('email', '')));

        // 檢查參數
        if (!preg_match('/^09[0-9]{8}$/', $phone)) {
            return [
                'return_code' => self::PHONE_ERROR_CODE,
                'description' => '手機號碼格式錯誤！',
            ];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => 'Email格式錯誤！',
            ];
        }

        // call ccc api
        $curlParam = [
            'mobile_phone' => $phone,
            'email' => $email,
        ];
        $headerParam = [
            'Content-Type' => 'application/json',
        ];
        $result = $this->apiService->curl('bind-email', 'POST', $curlParam, [], $headerParam);

        return $result;
    }

    /**
     * 確認手機驗證碼
     * @param string $phone 手機號碼
     * @param string $verifyCode 驗證碼
     * @return array
     */
    public function verify(Request $request)
    {
        // 過濾參數
        $phone = htmlspecialchars(trim($request->input('phone', '')));
        $verifyCode = htmlspecialchars(trim($request->input('verifyCode', '')));

        // 檢查參數
        if (!preg_match('/^09[0-9]{8}$/', $phone)) {
            return [
                'return_code' => self::PHONE_ERROR_CODE,
                'description' => '手機號碼格式錯誤！',
            ];
        }
        if (!preg_match('/^[0-9]{4}$/', $verifyCode)) {
            return [
                'return_code' => self::VERIFY_ERROR_CODE,
                'description' => '驗證碼格式錯誤！',
            ];
        }

        // call ccc api
        $curlParam = [
            'mobile_phone' => $phone,
            'code' => $verifyCode,
        ];
        $headerParam = [
            'Content-Type' => 'application/json',
        ];
        $result = $this->apiService->curl('verify', 'POST', $curlParam, [], $headerParam);

        return $result;
    }

    /**
     * 登入生活市集
     * @param string $t token
     * @return array
     */
    public function loginBuy123(Request $request)
    {
        $token = htmlspecialchars(trim($request->input('t', '')));

        // 檢查參數
        if (empty($token)) {
            return [
                'return_code' => self::T_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::T_ERROR_CODE),
            ];
        }

        // call ccc api
        $headerParam = [
            'Content-Type' => 'application/json',
            'Authorization' => sprintf('Bearer %s', $token),
        ];
        $result = $this->apiService->curl('login-buy123', 'GET', [], [], $headerParam);

        return $result;
    }

    /**
     * 登入 ES 商城
     * @param string $t token
     * @return array
     */
    public function loginEsmarket(Request $request)
    {
        $token = htmlspecialchars(trim($request->input('t', '')));

        // 檢查參數
        if (empty($token)) {
            return [
                'return_code' => self::T_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::T_ERROR_CODE),
            ];
        }

        // call ccc api
        $headerParam = [
            'Content-Type' => 'application/json',
            'Authorization' => sprintf('Bearer %s', $token),
        ];
        $result = $this->apiService->curl('login-esmarket', 'GET', [], [], $headerParam);

        return $result;
    }

    /**
     * 登入 Shopify
     * @param string $t     token
     * @param string $url   登入後前往的網址
     * @param string $gb_el 加密過的email（生活市集使用）
     * @param string $email
     * @return array
     */
    public function loginShopify(Request $request)
    {
        $token = htmlspecialchars(trim($request->input('t', '')));
        $url = htmlspecialchars(trim($request->input('url', '')));
        $gbEl = htmlspecialchars(trim($request->input('gb_el', '')));
        $email = htmlspecialchars(trim($request->input('email', '')));

        // $gbEl 與 $email 互斥，擇一傳入
        if (!empty($email)) {
            $gbEl = '';
        }

        // 檢查參數
        if (empty($token)) {
            return [
                'return_code' => self::T_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::T_ERROR_CODE),
            ];
        }
        if (empty($url)) {
            return [
                'return_code' => self::URL_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::URL_ERROR_CODE),
            ];
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => 'Email格式錯誤！',
            ];
        }

        // call ccc api
        $curlParam = [
            'goto' => $url,
            'gb_el' => $gbEl,
            'email' => $email,
        ];
        $headerParam = [
            'Authorization' => sprintf('Bearer %s', $token),
        ];
        $result = $this->apiService->curl('login-shopify', 'POST', $curlParam, [], $headerParam);

        return $result;
    }

    /**
     * 取得 Shopify 的跳轉頁連結
     * @param string $t      token
     * @param string $url    登入後前往的網址
     * @param string $gb_sel 加密過的email（Shopify使用）
     * @return array
     */
    public function redirectShopify(Request $request)
    {
        $token = htmlspecialchars(trim($request->input('t', '')));
        $url = htmlspecialchars(trim($request->input('url', '')));
        $gbSel = htmlspecialchars(trim($request->input('gb_sel', '')));

        // 檢查參數
        if (empty($token)) {
            return [
                'return_code' => self::T_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::T_ERROR_CODE),
            ];
        }
        if (empty($url)) {
            return [
                'return_code' => self::URL_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::URL_ERROR_CODE),
            ];
        }
        if (empty($gbSel)) {
            return [
                'return_code' => self::GBSEL_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::GBSEL_ERROR_CODE),
            ];
        }

        // call ccc api
        $curlParam = [
            'goto' => $url,
            'gb_sel' => $gbSel,
        ];
        $headerParam = [
            'Authorization' => sprintf('Bearer %s', $token),
        ];
        $result = $this->apiService->curl('redirect-shopify', 'POST', $curlParam, [], $headerParam);

        return $result;
    }

    /**
     * 登入 line
     * @param string $l_i    加密過的line編號
     * @param string $l_n    加密過的line名字
     * @param string $l_e    加密過的line email
     * @param string $gb_el  加密過的email（生活市集使用）
     * @param string $email  使用者輸入的email
     * @param int    $gm_uid 會員編號
     * @return array
     */
    public function loginLine(Request $request)
    {
        $lineId = $this->gmCryptService->decode(htmlspecialchars(trim($request->input('l_i', ''))));
        $lineName = $this->gmCryptService->decode(htmlspecialchars(trim($request->input('l_n', ''))));
        $lineEmail = $this->gmCryptService->decode(htmlspecialchars(trim($request->input('l_e', ''))));
        $gbEl = htmlspecialchars(trim($request->input('gb_el', '')));
        $email = htmlspecialchars(trim($request->input('email', '')));
        $gmUid = htmlspecialchars(trim($request->input('gm_uid', '')));

        // 檢查參數
        if (empty($lineId)) {
            return [
                'return_code' => self::LINE_ID_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::LINE_ID_ERROR_CODE),
            ];
        }
        if (empty($lineName)) {
            return [
                'return_code' => self::LINE_NAME_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::LINE_NAME_ERROR_CODE),
            ];
        }
        if (empty($gmUid)) {
            return [
                'return_code' => self::GMUID_ERROR_CODE,
                'description' => sprintf('缺少參數（%d）', self::GMUID_ERROR_CODE),
            ];
        }

        // call ccc api
        $curlParam = [
            'line_email' => $lineEmail,
            'email' => $email,
            'gb_el' => $gbEl,
            'line_id' => $lineId,
            'display_name' => $lineName,
            'gm_uid' => $gmUid,
        ];
        $curlParam['signature'] = $this->genSignature($curlParam);
        $headerParam = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $result = $this->apiService->curl('login-line', 'POST', $curlParam, [], $headerParam);

        // 回傳加密過的 email
        $returnCode = $result['return_code'] ?? '';
        $returnEmail = $result['data']['email'] ?? '';
        if ($returnCode == '0000' && !empty($returnEmail)) {
            $result['data']['email'] = $this->gmCryptService->encode($returnEmail);
        }

        return $result;
    }

    /**
     * 登出 - 刪除登入相關的 cookie 以及 session
     */
    public function logout()
    {
        $expriyTs = time() - Config('setting.cookie.oneHourTs'); // 預設的 cookie 有效時間

        session()->forget('userInfo');
        setcookie('gm_uid', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('t', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gmm_t', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_t', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_ts', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_ets', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_el', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('reg_email', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_sel', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('u_p', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('u_b', '', $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
    }

    /**
     * 登入 - 寫入登入相關的 cookie
     */
    public function setLoginCookie(Request $request)
    {
        $t = htmlspecialchars(trim($request->input('t', '')));
        $gmm_t = htmlspecialchars(trim($request->input('gmm_t', '')));
        $gb_t = htmlspecialchars(trim($request->input('gb_t', '')));
        $gb_ts = htmlspecialchars(trim($request->input('gb_ts', '')));
        $gb_ets = htmlspecialchars(trim($request->input('gb_ets', '')));
        $gb_el = htmlspecialchars(trim($request->input('gb_el', '')));
        $reg_email = htmlspecialchars(trim($request->input('reg_email', '')));
        $gb_sel = htmlspecialchars(trim($request->input('gb_sel', '')));

        $expriyTs = time() + Config('setting.cookie.oneHourTs'); // 預設的 cookie 有效時間

        setcookie('t', $t, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gmm_t', $gmm_t, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_t', $gb_t, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_ts', $gb_ts, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_ets', $gb_ets, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_el', $gb_el, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('reg_email', $reg_email, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        setcookie('gb_sel', $gb_sel, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
    }

    /**
     * 產生簽章
     * @param array   $paramAry  欲加密的參數陣列
     * @param string  $signature 加密的key
     * @return string
     */
    private function genSignature($paramAry = [], $signature = self::SIGN_KEY)
    {
        if (empty($paramAry) || !is_array($paramAry)) {
            return '';
        }

        $queryString = '';
        ksort($paramAry);

        array_walk($paramAry, function ($v, $k) use (&$queryString) {
            $queryString .= sprintf('%s=%s', $k, $v);
        });

        return hash_hmac('sha256', $queryString, $signature);
    }
}
