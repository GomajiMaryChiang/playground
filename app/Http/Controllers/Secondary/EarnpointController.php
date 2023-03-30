<?php

namespace App\Http\Controllers\Secondary;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\CityService;
use App\Services\JsonldService;
use App\Services\ProductService;
use Config;

class EarnpointController extends Controller
{
    const TYPE_LIST = 'list';
    const TYPE_DETAIL = 'detail';
    const TYPE_JUMP = 'jump';

    protected $apiService;
    protected $cityService;
    protected $jsonldService;
    protected $productService;

    public function __construct(ApiService $apiService, CityService $cityService, JsonldService $jsonldService, ProductService $productService)
    {
        $this->apiService = $apiService;
        $this->cityService = $cityService;
        $this->jsonldService = $jsonldService;
        $this->productService = $productService;
    }

    /*
     * 聰明賺點列表
     */
    public function list(Request $request)
    {
        $this->checkChannelEnable(); // 判斷返利網來的是否要阻擋進入此頁面
        $this->paramsValidation(self::TYPE_LIST, $request->all()); // 參數驗證

        $cityId = $this->cityService->getCityValue($request, 'city', 'city', 1);
        $isFromApp = $this->checkFromMobileApp(); // 是否從 APP 來的
        $isFromAppReward = htmlspecialchars(trim($request->input('app_reward', false))); // 是否從 APP 的賺取點數來的

        // ===== 聰明賺點店家列表 =====
        $earnpointList = [];
        $apiParam = ['plat' => ($isFromApp ? 1 : 0)];
        $apiResult = $this->apiService->curl('affiliate-stores', 'GET', $apiParam);
        if ($apiResult['return_code'] == '0000' && !empty($apiResult['data'])) {
            $earnpointList = $apiResult['data'];
        }
        foreach ($earnpointList as $key => $value) {
            $link = sprintf('/earnpoint/%d', $value['store_id']);
            // 如果從 app 的賺取點數來，需轉換為 deeplink
            if ($isFromAppReward) {
                $link = $this->getDeepLink($link);
            }
            $earnpointList[$key]['link'] = $link;
        }
        // ===== End: 聰明賺點店家列表 =====

        // ===== Banner =====
        $bannerData = [];
        $apiParam = [
            'ch_id' => Config::get('channel.id.aff'),
            'city_id' => $cityId,
            'type' => 5
        ];
        $bannerDataResult = $this->apiService->curl('banner-list', 'GET', $apiParam);
        if ($bannerDataResult['return_code'] == '0000' && !empty($bannerDataResult['data'])) {
            $bannerData = $bannerDataResult['data'];
        }

        $bannerList = [];
        if (!empty($bannerData['banners'])) {
            $bannerList = $bannerData['banners'];
            foreach ($bannerList as $key => $value) {
                $link = $this->productService->getBannerLink($value);
                // 如果從 app 的賺取點數來，需轉換為 deeplink
                if ($isFromAppReward) {
                    $link = $this->getDeepLink($link);
                }
                $bannerList[$key]['link'] = $link;
            }
        }
        $secondBannerList = [];
        if (!empty($bannerData['second_banner'])) {
            $secondBannerList = $bannerData['second_banner'];
            foreach ($secondBannerList as $key => $value) {
                $link = $this->productService->getBannerLink($value);
                // 如果從 app 的賺取點數來，需轉換為 deeplink
                if ($isFromAppReward) {
                    $link = $this->getDeepLink($link);
                }
                $secondBannerList[$key]['link'] = $link;
            }
        }
        $thirdBannerList = [];
        if (!empty($bannerData['third_banner'])) {
            $thirdBannerList = $bannerData['third_banner'];
            foreach ($thirdBannerList as $key => $value) {
                $link = $this->productService->getBannerLink($value);
                // 如果從 app 的賺取點數來，需轉換為 deeplink
                if ($isFromAppReward) {
                    $link = $this->getDeepLink($link);
                }
                $thirdBannerList[$key]['link'] = $link;
            }
        }
        // ===== End: Banner =====

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam();
        $pageParam['mmTitle'] = '聰明賺點';
        $pageParam['isShowHeader'] = !$isFromApp; // 從 APP 來的不顯示 header
        $pageParam['isShowFooter'] = !$isFromApp; // 從 APP 來的不顯示 footer

        // meta
        $pageParam['meta']['title'] = 'GOMAJI 最大吃喝玩樂平台 | 聰明賺點，消費再贈 GOMAJI 點數回饋';
        $pageParam['meta']['ogSiteName'] = 'GOMAJI 最大吃喝玩樂平台 | 聰明賺點，消費再贈 GOMAJI 點數回饋';
        $pageParam['meta']['description'] = 'GOMAJI 全台最大吃喝玩樂平台！網羅國內外網站最新優惠，消費再贈 GOMAJI 點數回饋，讓你省上加省，購物最超值！';
        $pageParam['meta']['keywords'] = '點數回饋,賺點,贈點,回饋,返利,優惠,折抵,特賣,好康,購物,線上購物,訂房,線上訂房,線上購物,省錢';

        // jsonld
        $jsonldData = [
            'pageTitle' => '聰明賺點',
            'pageUrl' => $pageParam['meta']['canonicalUrl'] ?? '',
            'products' => $earnpointList,
        ];
        $pageParam['webType'] = 'earnpoint';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('Earnpoint', $jsonldData);

        // content
        $pageParam['bannerList'] = $bannerList; // 左 Banner
        $pageParam['secondBannerList'] = $secondBannerList; // 右上 Banner
        $pageParam['thirdBannerList'] = $thirdBannerList; // 右下 Banner
        $pageParam['earnpointList'] = $earnpointList; // 聰明賺點店家列表
        /* ===== End: 頁面參數 ===== */

        return view('secondary.earnpoint.list', $pageParam);
    }

    /*
     * 聰明賺點詳細頁
     */
    public function detail($storeId = 0)
    {
        $this->checkChannelEnable(); // 判斷返利網來的是否要阻擋進入此頁面
        $this->paramsValidation(self::TYPE_DETAIL, ['storeId' => $storeId]); // 參數驗證

        $isFromApp = $this->checkFromMobileApp(); // 是否從 APP 來的

        /* ===== 聰明賺點店家詳細資訊 ===== */
        $earnpointData = [];
        $apiParam = ['plat' => ($isFromApp ? 1 : 0)];
        $apiResult = $this->apiService->curl('affiliate-stores-detail', 'GET', $apiParam, [$storeId]);
        if ($apiResult['return_code'] != '0000' || empty($apiResult['data'])) {
            $this->warningAlert('此頁面不存在', '/');
        }
        $earnpointData = $apiResult['data'];
        /* ===== End: 聰明賺點店家詳細資訊 ===== */

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam();
        $pageParam['mmTitle'] = '聰明賺點';
        $pageParam['goBack']['link'] = '/earnpoint';
        $pageParam['goBack']['text'] = '回上頁';
        $pageParam['isShowHeader'] = !$isFromApp; // 從 APP 來的不顯示 header
        $pageParam['isShowFooter'] = !$isFromApp; // 從 APP 來的不顯示 footer

        // meta
        $pageParam['meta']['title'] = 'GOMAJI 最大吃喝玩樂平台 | 聰明賺點，消費再贈 GOMAJI 點數回饋';
        $pageParam['meta']['ogSiteName'] = 'GOMAJI 最大吃喝玩樂平台 | 聰明賺點，消費再贈 GOMAJI 點數回饋';
        $pageParam['meta']['description'] = 'GOMAJI 全台最大吃喝玩樂平台！網羅國內外網站最新優惠，消費再贈 GOMAJI 點數回饋，讓你省上加省，購物最超值！';
        $pageParam['meta']['keywords'] = '點數回饋,賺點,贈點,回饋,返利,優惠,折抵,特賣,好康,購物,線上購物,訂房,線上訂房,線上購物,省錢';

        // jsonld
        $jsonldData = [
            'pageTitle' => $earnpointData['store_name'] ?? '',
            'pageUrl' => $pageParam['meta']['canonicalUrl'] ?? '',
        ];
        $pageParam['webType'] = 'earnpointDetail';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('EarnpointDetail', $jsonldData);

        // content
        $pageParam['earnpointData'] = $earnpointData; // 聰明賺點店家資訊
        $pageParam['isLogin'] = !empty($this->getGmUid()); // 是否已登入
        $pageParam['redirectData'] = $this->getRedirectUri($earnpointData['store_id']); // 轉跳資訊
        /* ===== End: 頁面參數 ===== */

        return view('secondary.earnpoint.detail', $pageParam);
    }

    /*
     * 聰明賺點跳轉頁
     */
    public function jump(Request $request)
    {
        $this->checkChannelEnable(); // 判斷返利網來的是否要阻擋進入此頁面
        $this->paramsValidation(self::TYPE_JUMP, $request->all()); // 參數驗證

        $storeId = $request->input('storeId');
        $isFromApp = $this->checkFromMobileApp(); // 是否從 APP 來的


        /* ===== 判斷是否已登入 ===== */
        $gmUid = $this->getGmUid();
        if (empty($gmUid)) {
            $this->warningAlert('請先登入呦～', '/');
        }
        /* ===== End: 判斷是否已登入 ===== */


        /* ===== 聰明賺點店家詳細資訊 ===== */
        $earnpointData = [];
        $apiParam = ['plat' => ($isFromApp ? 1 : 0)];
        $apiResult = $this->apiService->curl('affiliate-stores-detail', 'GET', $apiParam, [$storeId]);
        if ($apiResult['return_code'] != '0000' || empty($apiResult['data'])) {
            $this->warningAlert('此頁面不存在', '/');
        }
        $earnpointData = $apiResult['data'];
        /* ===== End: 聰明賺點店家詳細資訊 ===== */


        /* ===== 整理頁面參數 ===== */
        $mainReward = $earnpointData['reward_info']['main_reward'] ?? '';
        $storeWebsite = $earnpointData['passing_page']['store_website'] ?? '#';
        $logo = $earnpointData['passing_page']['passing_page_logo'] ?? '';
        $note = $earnpointData['passing_page']['passing_page_note'] ?? '';
        /* ===== End: 整理頁面參數 ===== */


        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam();
        $pageParam['mmTitle'] = '聰明賺點';
        $pageParam['isShowHeader'] = false;
        $pageParam['isShowFooter'] = false;

        // content
        $pageParam['storeWebsite'] = preg_replace('/{gm_uid}/', $gmUid, $storeWebsite); // 第三方網址
        $pageParam['logo'] = $this->securityFilter($logo); // 第三方 logo 圖
        $pageParam['note'] = $this->securityFilter($note); // 注意事項
        $pageParam['mainReward'] = $this->securityFilter($mainReward); // 點數回饋
        /* ===== End: 頁面參數 ===== */

        return view('secondary.earnpoint.jumpThirdparty', $pageParam);
    }

    /**
     * 取得打開手機內建的小型瀏覽器連結
     * @param string $link 連結
     * @return string 手機內建瀏覽器連結
     */
    private function getDeepLink($link = '')
    {
        // 如果連結網址不包含 domain 的話，加上大小網 domain
        if (substr($link, 0, 4) != 'http') {
            $link = Config::get('setting.usagiDomain') . $link;
        }

        $link = sprintf('GOMAJI://webpage?open_type=7&url=%s', urlencode($link));

        return $link;
    }

    /**
     * 取得會員編號
     * @return int 會員編號
     */
    private function getGmUid()
    {
        if (empty($_COOKIE['gm_uid'])) {
            return false;
        }

        return $_COOKIE['gm_uid'];
    }

    /**
     * 取得轉跳資訊
     * @param int $storeId 店家編號
     */
    private function getRedirectUri($storeId = 0)
    {
        $cmd = isset($_COOKIE['cmd']) ? strtolower($_COOKIE['cmd']) : '';
        $version = $_COOKIE['version'] ?? 0;
        $redirectUrl = sprintf('%s/earnpoint/%s', Config::get('setting.usagiDomain'), $storeId);

        if (!empty($version) && isset(explode('-', $version)[2])) {
            $version = explode('-', $version)[2];
            $version = str_replace('.', '', $version);
        }

        if ($cmd == 'android' && $version >= 502 && $version < 663) {
            $isRedirect = false;
            $uri = 'gomaji://mine';
        } elseif (!empty($cmd) && $version >= 502) {
            $isRedirect = true;
            $redirectUrl .= sprintf('?cmd=%s&version=%s', $_COOKIE['cmd'], $_COOKIE['version']);
            $uri = sprintf('GOMAJI://weblogin?nexttime_btn=0&goto=%s', urlencode($redirectUrl));
        } else {
            $isRedirect = true;
            $uri = sprintf('/login?goto=%s', $redirectUrl);
        }

        return [
            'isRedirect' => $isRedirect,
            'uri' => $uri,
        ];
    }

    /**
     * 判斷返利網來的是否要阻擋進入此頁面
     */
    private function checkChannelEnable()
    {
        $chId = Config::get('channel.id.aff');
        $ref = $_COOKIE['gmc_site_pay'] ?? '';
        $refName = Config::get('ref.name.' . $ref) ?? '';
        $disablecChList = Config::get('ref.disablecCh');

        if (!empty($ref) && isset($disablecChList[$ref]) && in_array($chId, $disablecChList[$ref])) {
            $this->warningAlert('此頻道商品不適用「' . $refName . '現金」回饋，如要購買建議您下載GOMAJI如要購買建議您下載GOMAJI APP。', '/');
        }
    }

    /**
     * 參數驗證
     * @param string $type       類型
     * @param array  $requestAry 參數陣列
     */
    private function paramsValidation($type, $requestAry = [])
    {
        $input = []; // 檢查的參數
        $rules = []; // 檢查規則
        $messages = []; // 驗證的錯誤訊息

        switch ($type) {
            case self::TYPE_LIST:
                $input['cityId'] = $requestAry['city'] ?? 1;
                $rules['cityId'] = 'numeric|gt:0';
                $messages['cityId.numeric'] = '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）';
                $messages['cityId.gt'] = '參數錯誤（' . Config::get('errorCode.cityIdGt') . '）';
                break;

            case self::TYPE_DETAIL:
            case self::TYPE_JUMP:
                $input['storeId'] = $requestAry['storeId'] ?? 0;
                $rules['storeId'] = 'required|numeric|gt:0';
                $messages['storeId.required'] = '參數錯誤（' . Config::get('errorCode.storeIdEmpty') . '）';
                $messages['storeId.numeric'] = '參數錯誤（' . Config::get('errorCode.storeIdNumeric') . '）';
                $messages['storeId.gt'] = '參數錯誤（' . Config::get('errorCode.storeIdGt') . '）';
                break;
        }

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors(); // 驗證錯誤訊息
            $inspectParams = array_keys($input); // 檢查對象
            foreach ($inspectParams as $inspect) {
                // 該項目錯誤訊息內容不為空
                if (!empty($errors->get($inspect)[0])) {
                    $this->warningAlert($errors->get($inspect)[0], '/404');
                }
            }
        }
    }
}
