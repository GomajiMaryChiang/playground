<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class ProductController extends Controller
{
    protected $apiService;

    // error code
    const EMAIL_ERROR_CODE = '103';
    const PID_ERROR_CODE = '105';
    const SID_ERROR_CODE = '106';
    const NAME_ERROR_CODE = '107';
    const FAIL_ERROR_CODE = '201';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 取得評價資訊
     * @param int $chId  頻道
     * @param int $groupId  分店
     * @param int $productId  商品id
     * @param int $page  頁數
     * @param int $ratingFilterValue  評價滿意程度
     * @return array
     */
    public function getRating(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('chId')) || is_array($request->input('groupId')) || is_array($request->input('productId')) || is_array($request->input('page')) || is_array($request->input('ratingFilterValue')) || is_array($request->input('apiType'))) {
            $result = [
                'return_code' => self::FAIL_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
            return $result;
        }

        // 過濾參數
        $chId = htmlspecialchars(trim($request->input('chId', 0)));
        $groupId = htmlspecialchars(trim($request->input('groupId', 0)));
        $productId = htmlspecialchars(trim($request->input('productId', 0)));
        $page = htmlspecialchars(trim($request->input('page', 0)));
        $ratingFilterValue = htmlspecialchars(trim($request->input('ratingFilterValue', 0)));
        $apiType = htmlspecialchars(trim($request->input('apiType', '')));

        // call ccc api
        $curlParam = [
            'cat_id' => 0,
            'group_id' => $groupId,
            'product_id' => $productId,
        ];

        if (!empty($page)) {
            $curlParam['page'] = $page;
        }

        if ($apiType == 'list') {
            $curlParam['rating_filter_value'] = $ratingFilterValue;
        }

        if ($apiType == 'list') {
            $curlParam['ch'] = $chId;
            $result = $this->apiService->curl('product-rating-list', 'GET', $curlParam);
        } else {
            $curlParam['ch_id'] = $chId;
            $result = $this->apiService->curl('product-rating-info', 'GET', $curlParam);
        }

        return $result;
    }

    /**
     * 寄送信箱以等待通知
     * @param int $productId  商品id
     * @param int $email 信箱
     * @param int $soldOutType 搶購完畢類別
     * @return array
     */
    public function soldOut(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('productId')) || is_array($request->input('email')) || is_array($request->input('soldOutType'))) {
            $result = [
                'return_code' => self::FAIL_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
            return $result;
        }

        // 過濾參數
        $productId = htmlspecialchars(trim($request->input('productId', 0)));
        $email = htmlspecialchars(trim($request->input('email', '')));
        $soldOutType = htmlspecialchars(trim($request->input('soldOutType', 2)));

        if (empty($productId)) {
            $result = [
                'return_code' => self::PID_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            return [
                'return_code' => self::EMAIL_ERROR_CODE,
                'description' => 'Email格式錯誤！',
            ];
        }

        // call ccc api
        $curlParam = [
            'pid' => $productId,
            'email' => $email,
            's_type' => $soldOutType,
        ];

        $result = $this->apiService->curl('update-soldout-mail', 'GET', $curlParam);

        if (empty($result)) {
            $result = [
                'return_code' => self::FAIL_ERROR_CODE,
                'description' => '異常狀況',
            ];
        }

        return $result;
    }

    /**
     * Line分享按鈕建立短網址
     * @param str $storeName  店家名稱
     * @param int $storeId    店家ID
     * @param int $productId  商品ID
     * @return array
     */
    public function lineShare(Request $request)
    {
        // 阻擋參數為陣列的內容值
        if (is_array($request->input('storeName')) || is_array($request->input('storeId')) || is_array($request->input('productId'))) {
            $result = [
                'return_code' => self::FAIL_ERROR_CODE,
                'description' => '錯誤參數來源',
            ];
            return $result;
        }

        // 過濾參數
        $storeName = htmlspecialchars(trim($request->input('storeName', '')));
        $storeId = htmlspecialchars(trim($request->input('storeId', 0)));
        $productId = htmlspecialchars(trim($request->input('productId', 0)));
        $result = [];

        if (empty($storeName)) {
            return $result = [
                'return_code' => self::NAME_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        if (empty($storeId)) {
            return $result = [
                'return_code' => self::SID_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        if (empty($productId)) {
            return $result = [
                'return_code' => self::PID_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        $apiParam = [
            'url' => sprintf(
                '%s/store/%s/pid/%s',
                Config::get('setting.usagiDomain'),
                $storeId,
                $productId
            )
        ];
        $apiResult = $this->apiService->curl('short-url', 'GET', $apiParam);

        if (empty($apiResult['return_code']) || empty($apiResult['data']['shorturl'])) {
            return $result = [
                'return_code' => self::FAIL_ERROR_CODE,
                'description' => '異常狀況',
            ];
        }

        if ($apiResult['return_code'] != 0000) {
            return $result = [
                'return_code' => $apiResult['return_code'] ?? 0,
                'description' => $apiResult['description'] ?? '',
            ];
        }

        // mm line Share
        $urlEncodeStoreName = urlencode("【" . $storeName . "】現有優惠，趕快進來瞧瞧！");
        $urlENcodeShortUrl = !empty($apiResult['data']['shorturl'])
            ? urlencode($apiResult['data']['shorturl'])
            : '';
        return $result = [
            'return_code' => '0000',
            'description' => 'Success',
            'lineUrl' => 'https://social-plugins.line.me/lineit/share?url=' . $urlEncodeStoreName . '%0D%0A' . $urlENcodeShortUrl,
        ];
    }
}
