<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\EventService;
use App\Services\CityService;
use App\Services\JsonldService;
use App\Services\ProductService;
use Config;
use Mobile_Detect;

class IndexController extends Controller
{
    protected $apiService;
    protected $cityService;
    protected $productService;
    protected $jsonldService;
    protected $eventService;

    /**
     * Dependency Injection
     */
    public function __construct(ApiService $apiService, CityService $cityService, ProductService $productService, JsonldService $jsonldService, EventService $eventService)
    {
        $this->apiService = $apiService;
        $this->cityService = $cityService;
        $this->productService = $productService;
        $this->jsonldService = $jsonldService;
        $this->eventService = $eventService;
    }

    /**
     * 首頁
     */
    public function __invoke(Request $request)
    {
        // 參數驗證
        $this->paramsValidation($request->all());
        $page = htmlspecialchars(trim($request->input('page', 1)));
        $cityId = $this->cityService->getCityValue($request, 'city', 'city', 1);
        $distGroupId = $this->cityService->getCityValue($request, 'dist_group', 'dist_group', 0);
        $date = htmlspecialchars(trim($request->input('date', date('Y-m-d H:i:s'))));
        $epaper = htmlspecialchars(trim($request->input('epaper', 0)));
        $cityData = $this->cityService->getCityData(0, $cityId); // 取得城市資訊
        $this->cityService->checkCityValue(0, $cityData['cityList'], $cityId, $distGroupId); // 檢查城市相關參數的內容值

        // 取得今日上架資訊
        $apiParam = ['page' => $page];
        $recommendData = [];
        $recommendDataResult = $this->apiService->curl('home-recommend-list', 'GET', $apiParam, [$cityId]);

        if (isset($recommendDataResult['return_code'])
            && $recommendDataResult['return_code'] == '0000'
            && !empty($recommendDataResult['data'])
        ) {
            $recommendData = $recommendDataResult['data'];
        }

        // 今日上架
        $recommendList = [];
        $promoAfterCount = 0; // special block 位置的前置設定
        $promoIndex = -1; // special block 位置的前置設定
        $promoList = [];
        if (!empty($recommendData['product'])) {
            $recommendList = $this->productService->handleProduct($promoAfterCount, $promoIndex, $promoList, $recommendData['product']);
        }
        $totalPage = $recommendData['total_page'] ?? 0;

        // 判斷是否為分頁
        if ($page != 1) {
            $html = '';
            if (!empty($recommendList)) {
                $pageParam['recommendList'] = $recommendList; // 今日上架
                $pageParam['totalPage'] = $totalPage; // 今日上架總分頁數
                $html = view('layouts.product.recommend', $pageParam)->render();
            }

            $result = [
                'code' => 1,
                'message' => '',
                'totalPage' => $totalPage,
                'html' => $html,
            ];

            exit(json_encode($result));
        }

        // 取首頁資訊
        $homeData = [];
        $homeDataResult = $this->apiService->curl('home-data', 'GET', [], [$cityId]);
        if (isset($homeDataResult['return_code'])
            && $homeDataResult['return_code'] == '0000'
            && !empty($homeDataResult['data'])
        ) {
            $homeData = $homeDataResult['data'];
        }

        // ===== Announcement 公告 =====
        $announceContent = (!empty($homeData['announcement']))
            ? $this->eventService->setAnnounce($homeData['announcement'], $date)
            : '';
        // ===== End: Announcement 公告 =====

        // ===== Banner =====
        $bannerList = [];
        if (!empty($homeData['banner'])) {
            $bannerList = $homeData['banner'];
            foreach ($bannerList as $key => $value) {
                $bannerList[$key]['link'] = $this->productService->getBannerLink($value);
            }
        }
        $secondBannerList = [];
        if (!empty($homeData['second_banner'])) {
            $secondBannerList = $homeData['second_banner'];
            foreach ($secondBannerList as $key => $value) {
                $secondBannerList[$key]['link'] = $this->productService->getBannerLink($value);
            }
        }
        $thirdBannerList = [];
        if (!empty($homeData['third_banner'])) {
            $thirdBannerList = $homeData['third_banner'];
            foreach ($thirdBannerList as $key => $value) {
                $thirdBannerList[$key]['link'] = $this->productService->getBannerLink($value);
            }
        }
        // ===== End: Banner =====

        // ===== 頻道列表 =====
        // 取得頻道列表
        $channelList = $this->eventService->getChannelList($date);

        // 處理返利網
        $disablecChList = Config::get('ref.disablecCh');
        $ref = $_COOKIE['gmc_site_pay'] ?? '';
        if (!empty($ref) && isset($disablecChList[$ref])) {
            foreach ($channelList as $key => $value) {
                $chId = $key;
                // 檢查返利網來的是否顯示頻道
                if (in_array($chId, $disablecChList[$ref])) {
                     unset($channelList[$chId]);
                     continue;
                }
                // 美安需加上 s_banner=85shop 參數
                if ($chId == Config::get('channel.id.buy123') && $ref == 'ref_' . Config::get('ref.id.maShop')) {
                    $channelList[$chId]['url'] .= '?s_banner=85shop';
                }
            }
        }

        // 處理 icon＆頻道標
        $icon = $homeData['channel_icon_badge']['icon'] ?? [];
        $badge = $homeData['channel_icon_badge']['badge'] ?? [];
        if (!empty($icon) || !empty($badge)) {
            $count = 0;
            foreach ($channelList as $key => $value) {
                $channelList[$key]['icon'] = $icon[$count] ?? $value['icon']; // icon
                $channelList[$key]['badge'] = $badge[$key] ?? $value['badge']; // 頻道標
                $count++;
            }
        }

        // 處理生活市集
        if (isset($channelList[Config::get('channel.id.buy123')])) {
            // 如為 mweb，調整生活市集的網址
            $detect = new Mobile_Detect();
            if ($detect->isMobile() && !$detect->isTablet()) {
                $channelList[Config::get('channel.id.buy123')]['url'] = 'https://mbuy123.gomaji.com/';
            }
        }
        // ===== End: 頻道列表 =====

        // 大 DD
        $todaySpecialList = [];
        if (!empty($homeData['today_special_list'])) {
            $todaySpecialList = $homeData['today_special_list'];
            foreach ($todaySpecialList as $key => $value) {
                $todaySpecialList[$key]['link'] = $this->productService->getProductLink($value);
                $todaySpecialList[$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE);
                $todaySpecialList[$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE);
                $todaySpecialList[$key]['display_desc'] = $this->productService->getDisplayDesc($value);
                $todaySpecialList[$key]['status'] = $this->productService->getProductStatus($value);
                $todaySpecialList[$key]['count_down'] = (!empty($value['expiry_date']) ? strtotime($value['expiry_date']) - time() : 0); // 倒數計時的秒數
            }
        }

        // 小 DD
        $todaySubSpecialList = [];
        if (!empty($homeData['today_sub_special_list'])) {
            $todaySubSpecialList = $homeData['today_sub_special_list'];
            foreach ($todaySubSpecialList as $key => $value) {
                $todaySubSpecialList[$key]['link'] = $this->productService->getProductLink($value);
                $todaySubSpecialList[$key]['org_price'] = $this->productService->getProductPrice($value, $this->productService::ORIGINAL_PRICE);
                $todaySubSpecialList[$key]['price'] = $this->productService->getProductPrice($value, $this->productService::SELLING_PRICE);
                $todaySubSpecialList[$key]['display_desc'] = $this->productService->getDisplayDesc($value);
                $todaySubSpecialList[$key]['status'] = $this->productService->getProductStatus($value);
            }
        }

        // 星級飯店/品牌餐廳
        $rsBrandList = [];
        if (!empty($homeData['rsBrand']['category'])) {
            $rsBrandList['carouel_id'] = 'brands-carouel';
            $rsBrandList['title'] = $homeData['rsBrand']['title'] ?? '星級飯店/品牌餐廳';
            $rsBrandList['more_link'] = '/brand';
            $rsBrandList['icon'] = 'i-brands';
            $rsBrandList['picture'] = $homeData['rsBrand']['category'];
            foreach ($rsBrandList['picture'] as $key => $value) {
                $rsBrandList['picture'][$key]['link'] = sprintf('/brand/%s', $value['pa_id']);
                $rsBrandList['picture'][$key]['name'] = $value['title'] ?? '';
                $rsBrandList['picture'][$key]['img'] = $value['small_icon'] ?? '';
            }
        }

        // 熱門類別
        $hotCatList = [];
        $mmHotCatList = [];
        if (!empty($homeData['hot_cat_list'])) {
            $hotCatList = $homeData['hot_cat_list'];
            foreach ($hotCatList as $key => $value) {
                $hotCatChId = ($value['ch_id'] == Config::get('channel.id.lf') ? Config::get('channel.id.lfn') : $value['ch_id']);
                $hotCatList[$key]['link'] = sprintf('/ch/%s?city=%s&category=%s', $hotCatChId, $value['city_id'], $value['category_id']);
                $hotCatList[$key]['active'] = false;
            }
            $mmHotCatList = array_chunk($hotCatList, 8);
        }

        // 聰明賺點
        $affiliateList = [];
        if (!empty($homeData['affiliates']['list'])) {
            // 以 '(' 區分標題及副標題
            $affiliateTitle = $homeData['affiliates']['title'] ?? '聰明賺點';
            $keyword = '(';
            $keywordIndex = mb_strpos($affiliateTitle, $keyword, 0, 'utf-8');
            if ($keywordIndex === false) {
                $affiliateList['title'] = $affiliateTitle;
            } else {
                $affiliateList['title'] = mb_substr($affiliateTitle, 0, $keywordIndex, 'utf-8');
                $affiliateList['sub_title'] = mb_substr($affiliateTitle, $keywordIndex, mb_strlen($affiliateTitle, 'utf-8') - $keywordIndex, 'utf-8');
            }

            $affiliateList['carouel_id'] = 'makemoney-carousel';
            $affiliateList['more_link'] = '/earnpoint';
            $affiliateList['picture'] = $homeData['affiliates']['list'];
            foreach ($affiliateList['picture'] as $key => $value) {
                $affiliateList['picture'][$key]['link'] = sprintf('/earnpoint/%s', $value['store_id']);
                $affiliateList['picture'][$key]['name'] = $value['store_name'] ?? '';
                $affiliateList['picture'][$key]['img'] = $value['store_logo'] ?? '';
            }
        }

        // 熱銷宅配
        $esForeignList = [];
        if (!empty($homeData['esForeign']['product'])) {
            $esForeignList['carouel_id'] = 'buy-carouel';
            $esForeignList['title'] = $homeData['esForeign']['title'] ?? '熱銷宅配生鮮美食';
            $esForeignList['more_link'] = '/es_foreign';
            $esForeignList['picture'] = $homeData['esForeign']['product'];
            foreach ($esForeignList['picture'] as $key => $value) {
                $esForeignList['picture'][$key]['link'] = $this->productService->getProductLink($value);
                $esForeignList['picture'][$key]['name'] = $value['store_name'] ?? '';
                $esForeignList['picture'][$key]['img'] = $value['img'][0] ?? '';
            }
        }

        // 旅遊行程推薦
        $esMarketList = [];
        if (!empty($homeData['esMarket']['product'])) {
            $esMarketList['carouel_id'] = 'trip-carouel';
            $esMarketList['carouel_class'] = 'trip-carouel';
            $esMarketList['title'] = $homeData['esMarket']['title'] ?? '旅遊行程推薦';
            $esMarketList['more_link'] = $channelList[Config::get('channel.id.esMarket')]['url'];
            $esMarketList['more_link_class'] = 'goChannelPage';
            $esMarketList['ch_id'] = Config::get('channel.id.esMarket');
            $esMarketList['picture'] = $homeData['esMarket']['product'];
            foreach ($esMarketList['picture'] as $key => $value) {
                $esMarketList['picture'][$key]['link'] = $this->productService->getProductLink($value);
                $esMarketList['picture'][$key]['name'] = $value['store_name'] ?? '';
                $esMarketList['picture'][$key]['img'] = $value['img'][0] ?? '';
                $esMarketList['picture'][$key]['subject_tag'] = $value['store_name'] ?? '';
            }
        }

        // 好站★好讚
        $awesomeWebsites = [];
        if (!empty($homeData['awesome_websites']['product'])) {
            $awesomeWebsites['carouel_id'] = 'awesomeWebsites-carouel';
            $awesomeWebsites['carouel_class'] = 'trip-carouel';
            $awesomeWebsites['title'] = $homeData['awesome_websites']['title'] ?? '好站★好讚';
            $awesomeWebsites['more_link'] = 'https://ozways.com/en-tw?utm_source=gomaji-website&utm_medium=gomaji-homepage-banner&utm_campaign=gomaji-ozways&utm_id=gomaji';
            $awesomeWebsites['picture'] = $homeData['awesome_websites']['product'];
            foreach ($awesomeWebsites['picture'] as $key => $value) {
                $awesomeWebsites['picture'][$key]['link'] = $value['mobile_url'] ?? '';
                $awesomeWebsites['picture'][$key]['more_link_class'] = 'goAwesomeWebsites';
                $awesomeWebsites['picture'][$key]['name'] = $value['store_name'] ?? '';
                $awesomeWebsites['picture'][$key]['img'] = $value['img'][0] ?? '';
                $awesomeWebsites['picture'][$key]['subject_tag'] = $value['store_name'] ?? '';
                $awesomeWebsites['picture'][$key]['chId'] = $value['ch_id'] ?? '';
            }
        }

        // 特別企劃
        $specialList = [];
        if (!empty($homeData['special_list'])) {
            $specialList['carouel_id'] = 'special-carouel';
            $specialList['title'] = '特別企劃';
            $specialList['more_link'] = '/special';
            $specialList['picture'] = $homeData['special_list'];
            foreach ($specialList['picture'] as $key => $value) {
                $specialList['picture'][$key]['link'] = sprintf('/special/%s?city=%s', $value['id'], $value['city_id']);
                $specialList['picture'][$key]['name'] = $value['name'] ?? '';
                $specialList['picture'][$key]['img'] = $value['image'] ?? '';
                $specialList['picture'][$key]['subject_tag'] = $value['name'] ?? '';
            }
        }

        // 排行榜
        $rankingList = [];
        if (!empty($homeData['ranking_list'])) {
            $rankingList['carouel_id'] = 'billboard-carouel';
            $rankingList['title'] = '排行榜';
            $rankingList['more_link'] = '/top';
            $rankingList['picture'] = $homeData['ranking_list'];
            foreach ($rankingList['picture'] as $key => $value) {
                $rankingList['picture'][$key]['link'] = sprintf('/top/%s', $value['id']);
                $rankingList['picture'][$key]['name'] = $value['name'] ?? '';
                $rankingList['picture'][$key]['img'] = $value['image'] ?? '';

                // 標籤文字裡的 'Top' 字串前加上換行符號
                $keyword = 'Top';
                $keywordIndex = mb_strpos($value['name'], $keyword, 0, 'utf-8');
                $rankingList['picture'][$key]['subject_tag'] = $keywordIndex !== false
                    ? sprintf(
                        '%s<br>%s',
                        mb_substr($value['name'], 0, $keywordIndex, 'utf-8'),
                        mb_substr($value['name'], $keywordIndex, mb_strlen($value['name'], 'utf-8') - $keywordIndex, 'utf-8')
                    )
                    : $value['name'];
            }
        }

        // 100元做公益
        $welfareList = [];
        if (!empty($homeData['welfare_list'])) {
            $welfareList['carouel_id'] = 'welfare-carousel';
            $welfareList['title'] = '100元做公益';
            $welfareList['more_link'] = '/510';
            $welfareList['picture'] = $homeData['welfare_list'];
            foreach ($welfareList['picture'] as $key => $value) {
                $welfareList['picture'][$key]['link'] = $this->productService->getProductLink($value);
                $welfareList['picture'][$key]['name'] = $value['name'] ?? '';
                $welfareList['picture'][$key]['img'] = $value['image'] ?? '';
            }
            $welfareList['picture'][] = [
                'link' => 'https://510.org.tw/donations',
                'name' => '公益',
                'img' => '/images/charity_pic20201231.jpg',
                'isBlank' => true,
            ];
        }

        // 浮水印
        $activityAd = [];
        if (!empty($homeData['activity_ad'])) {
            $activityData = $homeData['activity_ad'];
             // 若浮水印行為是網址連結
            if ($activityData['action'] == 'url') {
                $activityAd = [
                    'enable' => $activityData['enable'] ?? 0,
                    'img' => $activityData['img'] ?? '',
                    'link' => $activityData['link_url'] ?? '#',
                    'alt' => $activityData['subject'] ?? '',
                    'display' => true, // 顯示浮水印
                    'action' => 'url' // 行為是網址連結
                ];
            }
        }

        // Cookie
        $cookieAry = [
            't' => $_COOKIE['t'] ?? '',
            'gb_el' => $_COOKIE['gb_el'] ?? '',
            'gb_sel' => $_COOKIE['gb_sel'] ?? '',
        ];

        /* ===== 頁面參數 ===== */
        // header
        $pageParam = $this->defaultPageParam(false);
        $pageParam['cityData'] = $cityData; // 城市列表
        $pageParam['isShowSidemenu'] = true; // 顯示 mm header sidemenu
        $pageParam['goBack'] = []; // 不顯示 mm header “上一頁”的按鈕
        $pageParam['meta']['canonicalUrl'] = sprintf('%s?city=%d', url()->current(), $cityId);

        // content
        $pageParam['hotKeywordList'] = $homeData['hot_keywords'] ?? []; // 熱門關鍵字
        $pageParam['bannerList'] = $bannerList; // 左 Banner
        $pageParam['secondBannerList'] = $secondBannerList; // 右上 Banner
        $pageParam['thirdBannerList'] = $thirdBannerList; // 右下 Banner
        $pageParam['channelList'] = array_chunk($channelList, 2, true); // 頻道列表（頁面需兩個兩個分群顯示）
        $pageParam['todaySpecialList'] = $todaySpecialList; // 大 DD
        $pageParam['todaySpecialClass'] = (count($todaySpecialList) <= 1 ? 'pc-no-owl-nav' : ''); // 大 DD 要加上的 class 名稱
        $pageParam['todaySubSpecialList'] = $todaySubSpecialList; // 小 DD
        $pageParam['rsBrandList'] = $rsBrandList; // 星級飯店/品牌餐廳
        $pageParam['hotCatList'] = $hotCatList; // 熱門類別
        $pageParam['mmHotCatList'] = $mmHotCatList; // mm 熱門類別
        $pageParam['affiliateList'] = $affiliateList; // 聰明賺點
        $pageParam['esForeignList'] = $esForeignList; // 熱銷宅配
        $pageParam['esMarketList'] = $esMarketList; // 旅遊行程推薦
        $pageParam['awesomeWebsites'] = $awesomeWebsites; // 好站★好讚
        $pageParam['specialList'] = $specialList; // 特別企劃
        $pageParam['rankingList'] = $rankingList; // 排行榜
        $pageParam['welfareList'] = $welfareList; // 100元做公益
        $pageParam['activityAd'] = $activityAd; // 浮水印
        $pageParam['recommendTitle'] = $recommendData['title'] ?? ''; // 今日上架標題
        $pageParam['recommendList'] = $recommendList; // 今日上架
        $pageParam['totalPage'] = $totalPage; // 今日上架總分頁數
        $pageParam['announcement'] = $announceContent; // 公告跳窗的期間文字
        $pageParam['isShowEpaper'] = ($epaper == 1); // 是否跳電子報跳窗
        $pageParam['theme'] = $this->eventService->getEventTheme($date);
        $pageParam['cookieAry'] = $cookieAry;

        // jsonld
        $pageParam['webType'] = 'index';
        $pageParam['jsonld'] = $this->jsonldService->getJsonldData('Index', $pageParam);
        /* ===== End: 頁面參數 ===== */

        return view('main.index', $pageParam);
    }

    /**
     * 參數驗證
     * @param array $requestAry 參數陣列
     */
    private function paramsValidation($requestAry = [])
    {
        // 檢查的參數
        $input = [
            'page' => $requestAry['page'] ?? 1,
            'cityId' => $requestAry['city'] ?? 1,
            'distGroupId' => $requestAry['dist_group'] ?? 0,
            'date' => $requestAry['date'] ?? date('Y-m-d H:i:s'),
            'epaper' => $requestAry['epaper'] ?? 0,
        ];

        // 檢查規則
        $rules = [
            'page' => 'numeric|gt:0',
            'cityId' => 'numeric|gt:0',
            'distGroupId' => 'numeric|gte:0',
            'date' => 'date',
            'epaper' => 'numeric|gte:0',
        ];

        // 驗證的錯誤訊息
        $messages = [
            'page.numeric' => '參數錯誤（' . Config::get('errorCode.pageNumeric') . '）',
            'page.gt' => '參數錯誤（' . Config::get('errorCode.pageGt') . '）',
            'cityId.numeric' => '參數錯誤（' . Config::get('errorCode.cityIdNumeric') . '）',
            'cityId.gt' => '參數錯誤（' . Config::get('errorCode.cityIdGt') . '）',
            'distGroupId.numeric' => '參數錯誤（' . Config::get('errorCode.distGroupIdNumeric') . '）',
            'distGroupId.gte' => '參數錯誤（' . Config::get('errorCode.distGroupIdGte') . '）',
            'date.date' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.dateDate')),
            'epaper.numeric' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.epaperNumeric')),
            'epaper.gte' => sprintf('%s（%d）', '參數錯誤', Config::get('errorCode.epaperGte')),
        ];

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
