<?php

namespace App\Http\Controllers\Secondary;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class RatingController extends Controller
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
     * 評價頁
     */
    public function form(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), 'form');

        $c = empty($request->input('c', '')) ? '' : htmlspecialchars(trim($request->input('c', '')));
        $mod = empty($request->input('mod', '')) ? 0 : $request->input('mod', '');
        $cmd = empty($request->input('cmd', '')) ? '' : htmlspecialchars(trim($request->input('cmd', '')));
        $version = empty($request->input('version', '')) ? '' : htmlspecialchars(trim($request->input('version', '')));
        $purchaseId = empty($request->input('purchase_id', '')) ? 0 : $request->input('purchase_id', '');
        $arrayVersion = explode('-', $version) ?? [];
        $trueVersion = (!empty($arrayVersion[2])) ? str_replace('.', '', $arrayVersion[2]) : '';

        // 預設參數
        $data = $this->defaultPageParam(false);
        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();
        // mm版
        $data['mmTitle'] = '我要評價';
        $data['goBack']['text'] = '回上頁';

        $curlParam = [
            'c' => $c,
            'mod' => $mod
        ];

        $rtCurlWork = $this->apiService->curl('rating-form', 'GET', $curlParam);

        if (($rtCurlWork['return_code'] != 0000) || empty($rtCurlWork['data'])) {
            $this->warningAlert($rtCurlWork['description'], '/');
            exit;
        }

        $data['c'] = $c;
        $data['mod'] = $mod;
        $data['use_time'] = date('Y/m/d', $rtCurlWork['data']['use_time']);
        $data['cmd'] = $cmd;
        $data['version'] = $trueVersion;
        $data['purchaseId'] = $purchaseId;
        $data['data'] = $rtCurlWork['data'];
        $data['ratingTypeNum'] = empty($data['data']['rating_history']) ? 0 : count($data['data']['rating_history']['rating_type']);
        $data['ratingTypeArr'] = empty($data['data']['rating_history']) ? '' : json_encode($data['data']['rating_history']['rating_type']);

        // [Feature #4456] UE_宅配商品好評機制
        $data['isSendPoint'] = empty($data['data']['is_sending_point']) ? 0 : 1;

        return view('secondary.rating.form', $data);
    }

    /**
     * 評價完成頁
     */
    public function done()
    {
        $cmd = empty($_POST['cmd']) ? '' : strtolower(htmlspecialchars(trim($_POST['cmd'])));
        $version = empty($_POST['version']) ? '' : htmlspecialchars(trim($_POST['version']));
        $rating = empty($_POST['rating']) ? '' : htmlspecialchars(trim($_POST['rating']));
        $purchaseId = empty($_POST['purchaseId']) ? '' : htmlspecialchars(trim($_POST['purchaseId']));
        $response = empty($_POST['response']) ? '' : json_decode($_POST['response'], true);
        $couponId = empty($_POST['coupon_id']) ? '' : htmlspecialchars(trim($_POST['coupon_id']));
        $pid = $response['pid'] ?? '';
        $gid = $response['gid'] ?? '';
        $sid = $response['sid'] ?? '';
        $ch = $response['ch'] ?? '';
        $productName = $response['product_name'] ?? '';
        $storeName = $response['store_name'] ?? '';
        $source = 2;
        $shareFlag = 0;

        $backUrl = (!empty($cmd) && !empty($version))
            ? "GOMAJI://purchase_history_detail?type=history&purchase_id={$purchaseId}"
            : "https://www.gomaji.com/my/purchase/voucher/{$purchaseId}?status=used";

        if ($rating > 3) {
            if (($cmd == 'android' && $version > '650')
                || ($cmd == 'iphone2' && $version > '633')
            ) {
                // 評價分享
                $shareFlag = 1;
                $productName = urlencode($productName);
                $storeName = urlencode($storeName);
                $redirectUrl = "GOMAJI://share_dialog?ch={$ch}&pid={$pid}&gid={$gid}&sid={$sid}&source={$source}&coupon_id={$couponId}&product_name={$productName}&store_name={$storeName}";
            } else {
                $shareFlag = 2;
            }
        }
        // 預設參數
        $data = $this->defaultPageParam(false);
        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();
        // mm版
        $data['mmTitle'] = '我要評價';
        $data['goBack']['text'] = '回上頁';
        // meta
        $data['meta']['title'] = Config::get('meta.ratingDone.title');

        $data['shareFlag'] = $shareFlag;
        $data['shareUrl'] = $redirectUrl ?? '';
        $data['cmd'] = $cmd;

        return view('secondary.rating.done', $data);
    }

    /**
     * 編輯評價頁
     */
    public function view(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), 'view');

        $purchaseId = empty($request->input('purchase_id', '')) ? 0 : $request->input('purchase_id', '');
        $ticketNo = empty($request->input('ticket_no', '')) ? '' : htmlspecialchars(trim($request->input('ticket_no', '')));
        $transactionCat = empty($request->input('transaction_cat', '')) ? '' : htmlspecialchars(trim($request->input('transaction_cat', '')));
        $cmd = empty($request->input('cmd', '')) ? '' : htmlspecialchars(trim($request->input('cmd', '')));
        $authorization = empty($_COOKIE['t']) ? '' : $_COOKIE['t'];
        
        $curlParam = [
            'purchase_id' => $purchaseId,
            'ticket_no' => $ticketNo,
            'transaction_cat' => $transactionCat,
        ];

        $headerParam = [
            'authorization' => 'Bearer ' . $authorization,
        ];

        $rtCurlWork = $this->apiService->curl('rating-history', 'GET', $curlParam, [], $headerParam);
        
        // 預設參數
        $data = $this->defaultPageParam(false);
        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();
        // mm版
        $data['mmTitle'] = '我要評價';
        $data['goBack']['text'] = '回上頁';

        if (JSON_ERROR_NONE == json_last_error() && $rtCurlWork['return_code'] == 0000) {
            $data = [
                'create_ts' => date('Y/m/d', $rtCurlWork['data']['create_ts']),
                'store_create_ts' => date('Y/m/d', $rtCurlWork['data']['store_create_ts']),
                'cmd' => $cmd,
                'data' => $rtCurlWork['data'],
            ];
        } else {
            $this->warningAlert($rtCurlWork['description'], '/');
            exit;
        }

        return view('secondary.rating.view', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     */
    private function paramsValidation($request, $type)
    {
        // 評價頁
        if ($type == 'form') {
            // 檢查的參數
            $input = [
                'c' => $request['c'] ?? '',
                'mod' => $request['mod'] ?? 0,
                'purchaseId' => $request['purchase_id'] ?? 0,
            ];

            // 檢查規則
            $rules = [
                'c' => 'required',
                'mod' => 'required|numeric',
                'purchaseId' => 'numeric',
            ];

            // 驗證的錯誤訊息
            $messages = [
                'c.required' => '參數錯誤（' . Config::get('errorCode.cEmpty') . '）',
                'mod.required' => '參數錯誤（' . Config::get('errorCode.modEmpty') . '）',
                'mod.numeric' => '參數錯誤（' . Config::get('errorCode.modNumeric') . '）',
                'purchaseId.numeric' => '參數錯誤（' . Config::get('errorCode.purchaseIdNumeric') . '）',
            ];
        } else {
            // 檢查的參數
            $input = [
                'purchaseId' => $request['purchase_id'] ?? 0,
                'ticketNo' => $request['ticket_no'] ?? '',
                'transactionCat' => $request['transaction_cat'] ?? '',
            ];

            // 檢查規則
            $rules = [
                'purchaseId' => 'required|numeric|gt:0',
                'ticketNo' => 'required',
                'transactionCat' => 'required',

            ];

            // 驗證的錯誤訊息
            $messages = [
                'purchaseId.required' => '參數錯誤（' . Config::get('errorCode.purchaseIdEmpty') . '）',
                'purchaseId.numeric' => '參數錯誤（' . Config::get('errorCode.purchaseIdNumeric') . '）',
                'purchaseId.gt' => '參數錯誤（' . Config::get('errorCode.purchaseIdGt') . '）',
                'ticketNo.required' => '參數錯誤（' . Config::get('errorCode.ticketNoEmpty') . '）',
                'transactionCat.required' => '參數錯誤（' . Config::get('errorCode.transactionCatEmpty') . '）',
            ];
        }

        $validator = Validator::make($input, $rules, $messages);

        // 驗證有出錯
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
