<?php
namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\JsonldService;
use Config;

class BrandController extends Controller
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
     * 品牌頁
     */
    public function __invoke(Request $request)
    {
        // 麵包屑
        $breadcrumb['title'] = '星級飯店．品牌餐廳';

        // 取得星級飯店品牌餐廳資訊
        $brandData = [];
        $apiResult = $this->apiService->curl('rs-recommend-brand-new');
        if ($apiResult['return_code'] == '0000' && !empty($apiResult['data'])) {
            $brandData = $apiResult['data'];
        }

        // 整理星級飯店品牌餐廳列表
        $brandList = [];
        if (!empty($brandData)) {
            $brandList[0] = $brandData['hotels'] ?? [];
            $brandList[1] = $brandData['brands'] ?? [];
        }

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam();
        $pageParam['title'] = '星級飯店．品牌餐廳';
        $pageParam['mmTitle'] = '星級飯店．品牌餐廳';

        // meta -- start --
        $configMetaData = Config::get('meta.channelSpecial.rsBrand'); //  RS 品牌牆的 config meta 資訊
        $pageParam['meta']['title'] = $configMetaData['title'] ?? '';
        $pageParam['meta']['description'] = $configMetaData['description'] ?? '';
        $pageParam['meta']['canonicalUrl'] = url()->current();
        // meta -- end --


        // content
        $pageParam['breadcrumb'] = $breadcrumb; // 麵包屑
        $pageParam['tabList'] = ['星級飯店', '品牌餐廳']; // tab 列表
        $pageParam['brandList'] = $brandList; // 星級飯店品牌餐廳列表
        $pageParam['brandLink'] = $request->path();

        // jsonld
        $pageParam['webType'] = 'brand';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('Brand', $pageParam);
        /* ===== End: 頁面參數 ===== */

        return view('listing.brand', $pageParam);
    }

    /**
     * SH 名店美食
     */
    public function delivery(Request $request)
    {
        // 麵包屑
        $breadcrumb['title'] = Config::get('channel.homeList' . Config::get('channel.id.sh')) ?? '宅配美食';
        $breadcrumb['link'] = sprintf('/ch/%d', Config::get('channel.id.sh'));
        $breadcrumb['subTitle'] = '名店美食';

        // 取得名店美食資訊
        $brandData = [];
        $apiResult = $this->apiService->curl('sh-recommend-brand');
        if ($apiResult['return_code'] == '0000' && !empty($apiResult['data'])) {
            $brandData = $apiResult['data'];
        }

        // 整理名店美食列表
        $brandList = [];
        if (!empty($brandData)) {
            $brandList[0] = $brandData['food'] ?? [];
            $brandList[1] = $brandData['fresh'] ?? [];
        }

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam();
        $pageParam['title'] = '名店美食';
        $pageParam['mmTitle'] = '名店美食';
        $pageParam['goBack']['text'] = '回上頁';
        $pageParam['goBack']['link'] = sprintf('/ch/%d', Config::get('channel.id.sh'));

        // meta -- start --
        $configMetaData = Config::get('meta.channelSpecial.shBrand'); //  SH 宅配美食 config meta 資訊
        $pageParam['meta']['title'] = $configMetaData['title'] ?? '';
        $pageParam['meta']['description'] = $configMetaData['description'] ?? '';
        $pageParam['meta']['canonicalUrl'] = url()->current();
        // meta -- end --

        // content
        $pageParam['breadcrumb'] = $breadcrumb; // 麵包屑
        $pageParam['tabList'] = ['人氣美食', '生鮮調理']; // tab 列表
        $pageParam['brandList'] = $brandList; // 名店美食列表
        $pageParam['brandLink'] = $request->path();

        // jsonld
        $pageParam['webType'] = 'brand';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('Brand', $pageParam);

        /* ===== End: 頁面參數 ===== */

        return view('listing.brand', $pageParam);
    }
}
