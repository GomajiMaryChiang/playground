<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;
use Mobile_Detect;

class CheckoutController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 規格選擇頁
     */
    public function __invoke($pid, $spid, Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all(), $pid, $spid);

        if (empty($pid) || !isset($spid)) {
            $this->warningAlert('操作錯誤', '/404');
        }
        $preview = (!empty($_GET['preview']) && $_GET['preview'] == 1) ? 1 : 0;
        $shareCode = !empty($_GET['share_code']) ? $_GET['share_code'] : '' ; // 單檔 MGM 贈點的分享碼
        $ref = (!empty($_COOKIE['gmc_site_pay']) && preg_match('/^ref_[0-9]+$/', $_COOKIE['gmc_site_pay'])) ? $_COOKIE['gmc_site_pay'] : ''; // 返利網 cookie 的值
        $refNum = explode('ref_', $ref)[1] ?? 0;
        $refNum = (is_numeric($refNum) && $refNum > 0) ? $refNum : 0; // 返利網編號

        $data = $this->defaultPageParam();

        // PC or Mobile 判斷
        $data['platform'] = 0;
        $detect = new Mobile_Detect();
        if ($detect->isMobile() && !$detect->isTablet()) {
            $data['platform'] = 1;
        }

        // 商品資訊
        $curlParam = [
            'product_id' => $pid,
            'preview' => $preview,
        ];

        $curlWork = $this->apiService->curl('product-info', 'GET', $curlParam);
        if (!empty($curlWork) && $curlWork['return_code'] == 0000) {
            $data['productInfo'] = $curlWork['data'];
        } else {
            $this->warningAlert('操作錯誤', '/404');
        }

        // 詳細規格
        $curlParam = [
            'pid' => $pid,
            'sp_id' => $spid,
        ];
        $curlWork = $this->apiService->curl('get-inventory', 'GET', $curlParam);
        $quantity = [];
        $data['groupId'] = ''; // 進入頁面預設的 group_id
        $data['specUnits'] = []; // 進入頁面預設 group_id 的規格
        $data['table'] = []; // 儲存規格選擇方案的表格陣列

        if (!empty($curlWork) && $curlWork['return_code'] == 0000) {
            $data['specInfo'] = $curlWork['data'] ?? [];
            if ((isset($data['productInfo']['sp_flag']) && $data['productInfo']['sp_flag'] == 1 && isset($data['productInfo']['sub_products']) && count($data['productInfo']['sub_products']) > 0 && !empty($data['specInfo']['inventory_list']))
                || (isset($data['productInfo']['sub_products']) && count($data['productInfo']['sub_products']) == 0 && $data['productInfo']['inventory'] == 1)
            ) {
                $data['groupId'] = $data['specInfo']['inventory_list'][0]['rows'][0]['group_id'] ?? ''; // 進入頁面預設的 group_id
                $data['specUnits'] = $data['specInfo']['inventory_list'][0]['rows'][0]['units'] ?? []; // 進入頁面預設 group_id 的規格
                // 規格選擇表格欄位 開始
                foreach ($data['specInfo']['inventory_list'] as $list) {
                    if ($list['sp_id'] == $spid) {
                        foreach ($list['rows'] as $row) {
                            // <th> 開始
                            $data['table']['group_' . $row['group_id']]['specTh'] = '<th scope="col" class="text-center">項目</th>';
                            foreach ($row['units'] as $unit) {
                                $data['table']['group_' . $row['group_id']]['specTh'] .= sprintf('<th scope="col" class="text-center">%s</th>', $unit['unit_name']);
                            }
                            $data['table']['group_' . $row['group_id']]['specTh'] .= '<th scope="col" class="text-center">數量</th>';
                            // <th> 結束

                            // <td> 開始
                            $data['table']['group_' . $row['group_id']]['specTd'] = '<td><select id="group_id" name="group_id" class="group_id form-control check-select">';
                            foreach ($list['rows'] as $value) {
                                $data['table']['group_' . $row['group_id']]['specTd'] .= sprintf('<option value="%s">%s</option>', $value['group_id'], $value['item_name']);
                            }
                            $data['table']['group_' . $row['group_id']]['specTd'] .= '</select></td>';
                            foreach ($row['units'] as $unit) {
                                $data['table']['group_' . $row['group_id']]['specTd'] .= sprintf('
                                    <td>
                                        <select name="punit[%s]" class="form-control check-select input_css">
                                            <option value="0" selected>請選擇</option>
                                ', $row['group_id']);
                                foreach ($unit['punits'] as $punit) {
                                    $soldout = ($punit['sold_out'] == 1) ? 'disabled' : '';
                                    $soldoutWord = ($punit['sold_out'] == 1) ? ' (售完)' : '';
                                    $data['table']['group_' . $row['group_id']]['specTd'] .= sprintf('<option value="%s" %s>%s%s</option>', $punit['punit_id'], $soldout, $punit['punit_val'], $soldoutWord);
                                }
                                $data['table']['group_' . $row['group_id']]['specTd'] .= '
                                        </select>
                                    </td>
                                ';
                            }
                            $data['table']['group_' . $row['group_id']]['specTd'] .= '
                                <td class="relative">
                                    <select name="inventory_quantity" class="form-control check-select d-inline-block">
                                            <option value="0" selected>請選擇</option>
                                    </select>
                                    <input type="hidden" name="inventory_ids">
                                </td>
                            ';
                            // <td> 結束
                        }
                    }
                }
                // 規格選擇表格欄位 結束
                $data['inventory'] = $data['specInfo']['inventory_ids'];
                if (!empty($data['inventory'])) {
                    foreach ($data['inventory'] as $key => $value) {
                        $quantity[$value['punit_id']] = [
                            'inventoryId' => $value['inventory_id'],
                            'maxNo' => intval($value['max_order_no']) - intval($value['order_no']),
                            'selectedNo' => 0,
                        ];
                    }
                }
                $data['tableJSON'] = json_encode($data['table']) ?? '';
                $data['quantity'] = json_encode($quantity) ?? '';
            } else {
                $data['groupId'] = $data['productInfo']['group_id'] ?? 0;
            }
        } else {
            $this->warningAlert('操作錯誤', '/404');
        }

        $data['pid'] = $pid;
        $data['spid'] = $spid;
        $data['preview'] = ($preview) ?? 0;
        $data['shareCode'] = ($shareCode) ?? '';
        $data['ref'] = $refNum;
        $data['sendLink'] = ($preview == 1) ? Config::get('setting.usagiDomain') : 'javascript: void(0);';
        return view('main.checkout', $data);
    }

    /**
     * 參數驗證
     * @param array $request 參數陣列
     * @param int $pid  商品ID
     * @param int $spid 商品子方案ID
     */
    private function paramsValidation($request, $pid = 0, $spid = 0)
    {
        // 檢查的參數
        $input = [
            'pid' => $pid ?? 0,
            'sp_id' => $spid ?? 0,
            'preview' => $request['preview'] ?? 0,
        ];

        // 檢查規則
        $rules = [
            'pid' => 'required|numeric|gt:0',
            'sp_id' => 'required|numeric',
            'preview' => 'numeric',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'pid.required' => '參數錯誤（' . Config::get('errorCode.productIdEmpty') . '）',
            'pid.numeric' => '參數錯誤（' . Config::get('errorCode.productIdNumeric') . '）',
            'pid.gt' => '參數錯誤（' . Config::get('errorCode.productIdGt') . '）',
            'sp_id.required' => '參數錯誤（' . Config::get('errorCode.spIdEmpty') . '）',
            'sp_id.numeric' => '參數錯誤（' . Config::get('errorCode.spIdNumeric') . '）',
            'preview.numeric' => '參數錯誤（' . Config::get('errorCode.previewNumeric') . '）',
        ];

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
