<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use Config;

class AnnouncementController extends Controller
{
    protected $apiService;
    protected $eventService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, EventService $eventService)
    {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
    }

    /**
     * 公告頁
     */
    public function __invoke()
    {
        $isFromApp = $this->checkFromMobileApp(); // 是否從 APP 來的

        /* ===== 宅配嚴選頻道連結 ===== */
        $channelList = $this->eventService->getChannelList(); // 頻道列表
        $shopifyUrl = $channelList[Config::get('channel.id.shopify')]['url'];
        if ($isFromApp) {
            $shopifyUrl = sprintf('GOMAJI://new_sh?url=%s', urlencode($shopifyUrl));
        }
        /* ===== End: 宅配嚴選頻道連結 ===== */


        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['mmTitle'] = '公告';
        $pageParam['isShowLightHeader'] = !$isFromApp;
        $pageParam['isShowHeader'] = !$isFromApp;
        $pageParam['isShowFooter'] = !$isFromApp;

        // meta
        $pageParam['meta']['title'] = '公告 | GOMAJI 最大吃喝玩樂平台';
        
        // content
        $pageParam['shopifyUrl'] = $shopifyUrl; // 宅配嚴選頻道連結
        /* ===== End: 頁面參數 ===== */


        return view('publicize.announcement', $pageParam);
    }
}
