<?php

namespace App\Http\Controllers\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use App\Services\JsonldService;
use Config;

class PrivacyController extends Controller
{
    protected $apiService;
    protected $jsonldService;

    public function __construct(ApiService $apiService, EventService $eventService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
        $this->jsonldService = $jsonldService;
    }

    /*
     * 隱私權政策
     */
    public function __invoke(Request $request)
    {
        $date = htmlspecialchars(trim($request->input('date', date('Y-m-d H:i:s')))); // 取得是否有網址時間參數

        $data = $this->defaultPageParam(false);
        $data['mmTitle'] = '隱私權保護政策';
        $data['chTitle'] = '隱私權保護政策';
        $data['bannerTitle'] = '個人資料蒐集告知 & 隱私權保護政策';
        $data['goBack']['text'] = '';

        $data['date'] = $this->eventService->getTime($date); // 取得時間

        // meta
        $data['meta']['title'] = Config::get('meta.privacy.title');

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        // jsonld
        $data['webType'] = 'privacy';
        $data['pageTitle'] = '隱私權保護政策';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Privacy', $data);

        return view('about.privacy', $data);
    }
}
