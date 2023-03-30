<?php

namespace App\Http\Middleware;

use App\Services\ApiService;
use Closure;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefCookie
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
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->paramsValidation($request->all()); // 參數驗證
        // 過濾參數
        $ref = htmlspecialchars(trim($request->input('ref', 0)));
        $refType = htmlspecialchars(trim($request->input('ref_type', '')));
        $clickId = htmlspecialchars(trim($request->input('Click_ID', ''))); // 美安用
        $rId = htmlspecialchars(trim($request->input('RID', ''))); // 美安用
        $transactionId = htmlspecialchars(trim($request->input('transaction_id', ''))); // shopback 用
        $ecId = htmlspecialchars(trim($request->input('ecid', ''))); // line 用
        $cId = htmlspecialchars(trim($request->input('cid', ''))); // line 旅遊 用
        $tag = htmlspecialchars(trim($request->input('tag', ''))); // line 旅遊 用 tag 追蹤碼
        $gid = htmlspecialchars(trim($request->input('gid', ''))); // ichannels 用
        $site = sprintf('ref_%d', $ref);
        $expriyTs = time() + Config('setting.cookie.oneHourTs'); // 預設的 cookie 有效時間

        // 檢查返利網是否為大於零的數值
        if (empty($ref) || !is_numeric($ref) || $ref <= 0) {
            return $next($request);
        }

        // 取得返利網 cookie 有效時間
        $apiParam = ['ref' => $site];
        $siteResult = $this->apiService->curl('get-ref-expriytime', 'GET', $apiParam);
        if ($siteResult['return_code'] == '0000' && !empty($siteResult['data']['refExpiryTime'])) {
            $expriyTs = time() + $siteResult['data']['refExpiryTime'] * Config('setting.cookie.oneHourTs');
        }

        // 設定 cookie
        $this->setRefCookie('gmc_site_pay', $site, $expriyTs);
        $this->setRefCookie('shop_ts', $expriyTs, $expriyTs);
        if (!empty($refType)) {
            $this->setRefCookie('gmc_ref_type', $refType, $expriyTs);
        }

        // 依不同的返利網設定 cookie
        switch ($ref) {
            case Config('ref.id.maShop'):
                $affiliateid = 131;
                $this->setRefCookie('click_id', $clickId, $expriyTs);
                $this->setRefCookie('rid', $rId, $expriyTs);
                $this->setRefCookie('affiliateid', $affiliateid, $expriyTs);
                break;
            case Config('ref.id.shopback'):
                $this->setRefCookie('transaction_id', $transactionId, $expriyTs);
                break;
            case Config('ref.id.line'):
                $this->setRefCookie('line_ecid', $ecId, $expriyTs);
                break;
            case Config('ref.id.ichannels'):
                $this->setRefCookie('ichannels_gid', $gid, $expriyTs);
                break;
            case Config('ref.id.lineTrav'):
                $this->setRefCookie('line_ecid', $tag, $expriyTs);
                break;
        }

        return $next($request);
    }

    /**
     * 設定返利網 cookie
     *
     * @param  string  $key       鍵值
     * @param  string  $value     內容值
     * @param  int     $expriyTs  到期時間
     */
    private function setRefCookie($key = '', $value = '', $expriyTs = 0)
    {
        $setResult = setcookie($key, $value, $expriyTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        if (!$setResult) {
            $this->warningAlert('本網站透過使用“Cookies”記錄與您的相關的訊息，目前無法成功讀取及寫入，要麻煩請您打開“Cookies”；如有疑問敬請洽詢客服 02-27111758', '/404');
        }

        $_COOKIE[$key] = $value;
    }

    /**
     * 訊息跳窗（會中斷程式！）
     *
     * @param  string  $message  跳窗訊息
     * @param  string  $url      關閉跳窗後導頁的網址
     */
    private function warningAlert($message = '', $url = '')
    {
        $goto = !empty($url)
            ? sprintf('location.href="%s";', $url)
            : 'history.go(-1);';

        $script = sprintf(
            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><script>alert("%s");%s</script>',
            addslashes($message),
            $goto
        );

        exit($script);
    }

    /**
     * 參數驗證
     * @param array $requestAry 參數陣列
     */
    private function paramsValidation($requestAry = [])
    {
        // 檢查的參數
        $input = [
            'ref' => $requestAry['ref'] ?? 0,
            'refType' => $requestAry['ref_type'] ?? '',
            'clickId' => $requestAry['Click_ID'] ?? '',
            'rId' => $requestAry['RID'] ?? '',
            'transactionId' => $requestAry['transaction_id'] ?? '',
            'ecid' => $requestAry['ecid'] ?? '',
            'gid' => $requestAry['gid'] ?? '',
        ];

        // 檢查規則
        $rules = [
            'ref' => 'numeric|gte:0',
            'refType' => 'string',
            'clickId' => 'string',
            'rId' => 'string',
            'transactionId' => 'string',
            'ecid' => 'string',
            'gid' => 'string',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'ref.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.refNumeric')),
            'ref.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.refGte')),
            'refType.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.refTypeString')),
            'clickId.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.clickIdString')),
            'rId.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.rIdString')),
            'transactionId.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.transactionIdString')),
            'ecid.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.ecidString')),
            'gid.string' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.gidString')),
        ];

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors(); // 驗證錯誤訊息
            $inspectParams = array_keys($input); // 檢查對象
            foreach ($inspectParams as $inspect) {
                // 該項目錯誤訊息內容不為空
                if (!empty($errors->get($inspect)[0])) {
                    $this->warningAlert($errors->get($inspect)[0], '/404');
                }
            }
        }
    }
}
