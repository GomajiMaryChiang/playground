<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;
use Mobile_Detect;

class InventoryController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 更換方案時抓取該方案產品規格
     */
    public function inventory(Request $request)
    {
        $pid = $request->input('pid');
        $spid = $request->input('spid');
        if (empty($pid) || !isset($spid)) {
            return '參數有誤';
        }

        $data = [];

        // PC or Mobile 判斷
        $platform = 0;
        $detect = new Mobile_Detect();
        if ($detect->isMobile() && !$detect->isTablet()) {
            $platform = 1;
        }

        // 商品資訊
        $curlParam = [
            'product_id' => $pid,
            'preview' => 0,
        ];
        $curlWork = $this->apiService->curl('product-info', 'GET', $curlParam);
        if (!empty($curlWork) && $curlWork['return_code'] == 0000) {
            $productInfo = $curlWork['data'];
        } else {
            $this->warningAlert('操作錯誤', '/404');
        }

        // 詳細規格
        $curlParam = [
            'pid' => $pid,
            'sp_id' => $spid,
        ];

        $curlWork = $this->apiService->curl('get-inventory', 'GET', $curlParam);
        if (!empty($curlWork) && $curlWork['return_code'] == 0000) {
            $specInfo = $curlWork['data'];
            $spFlag = $productInfo['sp_flag'] ?? 0;
            $subProducts = $productInfo['sub_products'] ?? [];
            if ($spFlag == 1 && count($productInfo['sub_products']) > 0 && !empty($specInfo['inventory_list'])) {
                // 規格選擇表格欄位 開始
                foreach ($specInfo['inventory_list'] as $list) {
                    if ($list['sp_id'] == $spid) {
                        $data['groupId'] = $specInfo['inventory_list'][0]['rows'][0]['group_id']; // 返回的預設 group_id
                        $data['table'] = []; // 儲存規格選擇方案的表格陣列
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

                if (!empty($specInfo['inventory_ids'])) {
                    foreach ($specInfo['inventory_ids'] as $key => $value) {
                        $quantity[$value['punit_id']] = [
                            'inventoryId' => $value['inventory_id'],
                            'maxNo' => intval($value['max_order_no']) - intval($value['order_no']),
                            'selectedNo' => 0,
                        ];
                    }
                }
                $data['quantity'] = !empty($quantity) ? json_encode($quantity) : '';
                // 規格選擇表格欄位 結束
            } else {
                $groupId = $productInfo['group_id'] ?? 0;
            }
        }
        return json_encode($data);
    }
}
