<?php

namespace App\Http\Controllers\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Config;

class StakeHolderController extends Controller
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
     * 投資人管理專區
     */
    public function __invoke()
    {
        // 預設參數
        $data = $this->defaultPageParam(false);
        // mm版
        $data['mmTitle'] = '投資人管理專區';

        $data['isShowLightHeader'] = true;

        return view('about.stakeholder', $data);
    }
}
