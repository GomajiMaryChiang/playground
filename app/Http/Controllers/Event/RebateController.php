<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use Config;

class RebateController extends Controller
{
    protected $apiService;
    protected $eventService;

    /**
     * Dependency Injection
     */
    public function __construct(
        ApiService $apiService,
        EventService $eventService
    ) {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
    }

    /**
     * ARPU 核銷登記活動
     */
    public function __invoke(Request $request)
    {
        $data['t'] = !empty($request->header('t')) ? $request->header('t') : '';
        $data['gmUid'] = !empty($request->header('X-GOMAJI-MemberId')) ? $request->header('X-GOMAJI-MemberId') : 0;
        $getDate = htmlspecialchars(trim($request->input('date', date('Y-m-d H:i:s')))); // 取得是否有網址時間參數

         // 參數驗證
        $resultVal = $this->paramsValidation($data['gmUid']);

        $date = $this->eventService->getTime($getDate); // 取得時間
        $year = date('Y', strtotime($date));  // 年份
        $data['month'] = intval(date('m', strtotime($date)));  // 月份
        $data['yearMonth'] = $year . '/' . $data['month'] . '/';  // 年月份
        $data['day'] = date('t', strtotime($date));  // 最後一日

        // 視為不是從App來
        if (empty($data['gmUid']) || empty($data['t']) || $resultVal == false) {
            $data['btnStatus'] = 'popupBox';
        } else {
            // call ddd api
            $curlParam = [
                'gm_uid' => $data['gmUid'],
                't' => $data['t'],
            ];
            $result = $this->apiService->curl('is-signup', 'POST', $curlParam);

            // 已經登記或驗證不合法參數不足，按鈕反灰
            if (!empty($result['return_code']) && ($result['return_code'] == 0000 && !empty($result['data']['is_sign_up']) && $result['data']['is_sign_up'] == 1) || $result['return_code'] != 0000) {
                $data['btnStatus'] = 'finish';
            } else {
                $data['btnStatus'] = 'sign';
            }
        }

        $data['shopifyRule'] = ($date >= '2022-09-13 10:00:00')
            ? '本活動不適用「宅配嚴選」、「宅配購物+」、「旅遊行程」、「公益」、「聰明賺點」特約商店之商品。'
            : '本活動不適用「宅配購物+」、「旅遊行程」、「公益」、「聰明賺點」特約商店之商品。';

        return view('event.rebate', $data);
    }

    /**
     * 參數驗證
     * @param int $gmUid 會員id
     */
    private function paramsValidation($gmUid = 0)
    {
        // 檢查的參數
        $input = [
            'gmUid' => $gmUid,
        ];

        // 檢查規則
        $rules = [
            'gmUid' => 'required|numeric|gt:0',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'gmUid.required' => '參數錯誤（' . Config::get('errorCode.gmUidEmpty') . '）',
            'gmUid.numeric' => '參數錯誤（' . Config::get('errorCode.gmUidNumeric') . '）',
            'gmUid.gt' => '參數錯誤（' . Config::get('errorCode.gmUidGt') . '）',
        ];

        $validator = Validator::make($input, $rules, $messages);

        // 驗證有出錯
        if ($validator->fails()) {
            $errors = $validator->errors(); // 驗證錯誤訊息
            $inspectParams = array_keys($input); // 檢查對象
            foreach ($inspectParams as $inspect) {
                // 該項目錯誤訊息內容不為空
                if (!empty($errors->get($inspect)[0])) {
                    return false;
                }
            }
        }
        return true;
    }
}
