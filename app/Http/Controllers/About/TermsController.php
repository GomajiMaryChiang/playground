<?php

namespace App\Http\Controllers\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use App\Services\JsonldService;
use Config;

class TermsController extends Controller
{
    protected $apiService;
    protected $jsonldService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, EventService $eventService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->eventService = $eventService;
        $this->jsonldService = $jsonldService;
    }

    /**
     * 服務條款
     */
    public function __invoke(Request $request)
    {
        $date = htmlspecialchars(trim($request->input('date', date('Y-m-d H:i:s')))); // 取得是否有網址時間參數

        // 預設參數
        $data = $this->defaultPageParam(false);

        // mm版
        $data['mmTitle'] = '服務條款';
        $data['goBack']['text'] = '';

        $data['date'] = $this->eventService->getTime($date); // 取得時間
        
        // meta
        $data['meta']['title'] = Config::get('meta.terms.title');

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        // jsonld
        $data['webType'] = 'terms';
        $data['pageTitle'] = '服務條款';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Terms', $data);

        return view('about.terms', $data);
    }
}
