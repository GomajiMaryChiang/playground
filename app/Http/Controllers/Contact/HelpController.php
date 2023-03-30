<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use App\Services\JsonldService;
use Config;

class HelpController extends Controller
{
    protected $apiService;
    protected $eventService;
    protected $jsonldService;

    public function __construct(ApiService $apiService, EventService $eventService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
        $this->jsonldService = $jsonldService;
    }

    /*
     * 客服中心
     */
    public function __invoke(Request $request)
    {
        $faqInfo = !empty($request->input('faq', '')) ? $request->input('faq', '') : ''; // 來源為商品頁兌換說明細項url參數
        $datetime = htmlspecialchars(trim($request->input('date', date('Y-m-d H:i:s')))); // 測試用的日期參數，目前為過年公告用

        // [Redmine 7293] web_客服中心自動帶入user資料
        $uinfo = htmlspecialchars($request->input('uinfo', ''));
        $data = $this->defaultPageParam(false);

        // 類別 -- start --
        $curlParam = [];
        $data['faqLists'] = [];
        $curlWork = $this->apiService->curl('faq_list', 'GET', $curlParam); // apiService
        if (!empty($curlWork) && $curlWork['return_code'] == 0000) {
            $data['faqLists'] = $curlWork['data'];
        }
        // 類別 -- end --

        $itemId = 0;
        $subItemId = 0;

        // 判斷是正整數or正浮點數
        if (!empty($faqInfo) &&
            (preg_match('/^[0-9]*[1-9][0-9]*$/', $faqInfo) ||
            preg_match('/^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\ .[0-9]+)|([0-9]*[1-9][0-9]*))$/', $faqInfo))
        ) {
            if (false == strpos($faqInfo, '.')) {
                if (is_numeric($faqInfo)) {
                    $itemId = $faqInfo;
                }
            } else {
                $faqInfo = str_replace('.', '-', $faqInfo);
                list($itemId, $subItemId) = explode('-', $faqInfo);
                if (!is_numeric($itemId)) {
                    $itemId = 0;
                    $subItemId = 0;
                }

                if (!is_numeric($subItemId)) {
                    $itemId = 0;
                    $subItemId = 0;
                }
            }
        }

        $data['faqItemId'] = $itemId;
        $data['faqSubItemId'] = (string) $subItemId;

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        // meta -- start --
        $data['meta']['title'] = Config::get('meta.help.title');
        $data['meta']['description'] = Config::get('meta.help.description');
        $data['meta']['keywords'] = Config::get('meta.help.keywords');
        // meta -- end --

        $data['mmTitle'] = '客服中心';
        $data['chTitle'] = '客服中心';
        $data['noticeData'] = $this->eventService->getNewYearNotice($datetime); // 過年公告資訊
        $data['uinfo'] = $uinfo ?? '';

        // jsonld
        $data['webType'] = 'help';
        $data['pageTitle'] = '客服中心';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Help', $data);

        return view('contact.help', $data);
    }
}
