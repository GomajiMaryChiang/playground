<?php

namespace App\Http\Controllers\Errors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class DisappearController extends Controller
{
    protected $apiService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 404 頁面
     */
    public function __invoke()
    {
        $data = $this->defaultPageParam();
        $data['meta']['title'] = Config::get('meta.404.title');
        $data['mmTitle'] = '404'; // mm header 標題

        // app 開啟的不顯示 header & footer
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        // setStatusCode 將網路狀態碼改為404
        return response()->view('errors.404', $data)->setStatusCode(404);
    }

    /**
     * usagi 找不到頁面時，先導向 event.gomaji.com
     * 如果 event.gomaji.com 也找不到，會由 event.gomaji.com 回頭呼叫 usagi 的 /404
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToEvent(Request $request)
    {
        $path = $request->getPathInfo();
        $params = $request->getQueryString();
        $url = 'https://event.gomaji.com' . $path . ((empty($params)) ? '' : "?$params");
        return redirect($url);
    }
}
