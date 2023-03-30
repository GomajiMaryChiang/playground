<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\JsonldService;
use Config;

class KolController extends Controller
{
    protected $apiService;
    protected $jsonldService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, JsonldService $jsonldService)
    {
        $this->apiService = $apiService;
        $this->jsonldService = $jsonldService;
    }

    /**
     * 網紅 IG推薦
     */
    public function __invoke($ch = 'rs')
    {
        // 錯誤的頻道編號，頁面導至首頁
        if (!in_array($ch, ['rs', 'bt', 'es', 'youtube', 'stores'])) {
            $this->warningAlert('操作錯誤', '/');
            exit;
        }

        $data = $this->defaultPageParam(false);

        switch ($ch) {
            case 'rs':
                $template = 'publicize.kol.kol-rs';
                break;
            case 'bt':
                $template = 'publicize.kol.kol-bt';
                break;
            case 'es':
                $template = 'publicize.kol.kol-es';
                break;
            case 'youtube':
                $template = 'publicize.kol.youtube';
                break;
            case 'stores':
                $template = 'publicize.kol.stores';
                break;
        }

        // app 開啟的不顯示 header & footer
        $data['isShowLightHeader'] = !$this->checkFromMobileApp();
        $data['isShowHeader'] = !$this->checkFromMobileApp();
        $data['isShowFooter'] = !$this->checkFromMobileApp();

        $data['inApp'] = $this->checkFromMobileApp() ? 1 : 0;
        $data['mmTitle'] = '網紅推薦';
        
        // meta -- start --
        $data['meta']['title'] = Config::get('meta.kol.title');
        $data['meta']['description'] = Config::get('meta.kol.description');
        $data['meta']['keywords'] = Config::get('meta.kol.keywords');
        // meta -- end --

        // jsonld
        $jsonldData = [
            'pageTitle' => '網紅推薦',
            'pageUrl' => $data['meta']['canonicalUrl'] ?? '',
        ];
        $data['webType'] = 'kol';
        $data['jsonld'] = $this->jsonldService->getJsonldData('Kol', $jsonldData);


        return view($template, $data);
    }
}
