<?php

namespace App\Http\Controllers\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\JsonldService;
use Config;

class AboutUsController extends Controller
{
    protected $apiService;
    protected $jsonldService;

    public function __construct(ApiService $apiService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->jsonldService = $jsonldService;
    }

    /*
     * 關於我們
     */
    public function introduction()
    {
        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['mmTitle'] = '關於我們';

        // meta
        $pageParam['meta']['title'] = Config::get('meta.about.introduction.title');

        // app 開啟的不顯示 header & footer
        $pageParam['isShowLightHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowFooter'] = !$this->checkFromMobileApp();

        // jsonld
        $pageParam['webType'] = 'about';
        $pageParam['pageTitle'] = '關於我們';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('About', $pageParam);

        /* ===== End: 頁面參數 ===== */

        return view('about.aboutUs.introduction', $pageParam);
    }

    /*
     * 公司記事
     */
    public function event()
    {
        /* ===== 公司記事資訊 ===== */
        $eventList = [];
        $apiResult = $this->apiService->curl('history-list');
        if ($apiResult['return_code'] == '0000' && !empty($apiResult['data'])) {
            $eventList = $apiResult['data'];
        }

        if (!empty($eventList)) {
            foreach ($eventList as $eventKey => $event) {
                if (!empty($event['media_list'])) {
                    foreach ($event['media_list'] as $mediaKey => $media) {
                        if ($media['kind'] == 2) {
                            $eventList[$eventKey]['media_list'][$mediaKey]['url'] = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $media['url']);
                        }
                    }
                }
            }
        }
        /* ===== End: 公司記事資訊 ===== */

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['mmTitle'] = '關於我們';

        // meta
        $pageParam['meta']['title'] = Config::get('meta.about.event.title');

        // app 開啟的不顯示 header & footer
        $pageParam['isShowLightHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowFooter'] = !$this->checkFromMobileApp();

        // content
        $pageParam['eventList'] = $eventList;

        // jsonld
        $pageParam['webType'] = 'about';
        $pageParam['pageTitle'] = '公司記事';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('About', $pageParam);
        /* ===== End: 頁面參數 ===== */

        return view('about.aboutUs.event', $pageParam);
    }

    /*
     * 媒體報導
     */
    public function newsroom()
    {
        /* ===== 取得媒體報導資訊 ===== */
        $newsList = [];
        $apiResult = $this->apiService->curl('media-reports');
        if ($apiResult['return_code'] == '0000' && !empty($apiResult['data'])) {
            $newsList = $apiResult['data'];
        }
        /* ===== End: 取得媒體報導資訊 ===== */

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['mmTitle'] = '關於我們';

        // app 開啟的不顯示 header & footer
        $pageParam['isShowLightHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowHeader'] = !$this->checkFromMobileApp();
        $pageParam['isShowFooter'] = !$this->checkFromMobileApp();

        // content
        $pageParam['newsList'] = $newsList;

        // jsonld
        $pageParam['webType'] = 'about';
        $pageParam['pageTitle'] = '媒體報導';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('About', $pageParam);
        /* ===== End: 頁面參數 ===== */

        return view('about.aboutUs.newsroom', $pageParam);
    }
}
