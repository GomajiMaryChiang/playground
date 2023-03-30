<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;

class RatingController extends Controller
{
    protected $apiService;

    // error code
    const DATA_ERROR_CODE = '3000';
    const UNUSUAL_ERROR_CODE = '3001';

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 新增評價
     * @param object data 相關資訊
     * @return array
     */
    public function form(Request $request)
    {   
        // 過濾參數
        $c = empty($request->input('c', '')) ? '' : htmlspecialchars(trim($request->input('c', '')));
        $mod = empty($request->input('mod', '')) ? 0 : htmlspecialchars(trim($request->input('mod', '')));
        $rating = empty($request->input('rating', '')) ? 0 : htmlspecialchars(trim($request->input('rating', '')));
        $reviewId = empty($request->input('reviewId', '')) ? '' : htmlspecialchars(trim($request->input('reviewId', '')));
        $ratingType = empty($request->input('ratingType', '')) ? [] : $request->input('ratingType', '');
        $comment = empty($request->input('comment', '')) ? '' : htmlspecialchars(trim($request->input('comment', '')));
     
        if (empty($c)) {
            $result = [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => '參數有誤',
            ];
        }

        if ($rating <= 0) {
            $errorMsg = '請至少給我們總體評價';
        } else if ($rating <= 2 && mb_strlen($comment) == 0) {
            $errorMsg = '請於意見欄描述此次消費不滿意的狀況，以提供給店家改進參考，謝謝您！';
        } else if (mb_strlen($comment) > 120) {
            $errorMsg = '評價不能超過120個字喔';
        }

        if (!empty($errorMsg)) {
            $result = [
                'return_code' => self::DATA_ERROR_CODE,
                'description' => $errorMsg,
            ];
        }

        // call ccc api
        $curlParam = [
            'c'             => $c,
            'mod'           => $mod,
            'rating'        => $rating,
            'review_id'     => $reviewId,
            'rating_type'   => $ratingType,
            'comment'       => $comment,
        ];
        $result = $this->apiService->curl('rating-submit', 'POST', $curlParam);

        if (empty($result)) {
            $result = [
                'return_code' => self::UNUSUAL_ERROR_CODE,
                'description' => '異常狀況',
            ];
        }

        return $result;
    }
}
?>