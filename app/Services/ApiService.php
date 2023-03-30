<?php

namespace App\Services;

use App\Repositories\ApiRepository;
use Config;
use Mobile_Detect;

class ApiService
{
    // domain
    const DDD_DOMAIN = 'https://ddd.gomaji.com';
    const CCC_DOMAIN = 'https://ccc.gomaji.com';

    protected $apiRepository;

    // api 列表
    protected $dddApiList = [
        'account-info' => '/oneweb/profile/info', // 會員資料-GET
        'category-list' => '/oneweb/category_list', // 頻道分類
        'home-learderboard' => '/oneweb/home-learderboard',
        'home-learderboard-detail' => '/oneweb/home_learderboard_detail',
        'get-today-special-list' => '/oneweb/get_today_special_List',
        'channel-recommend' => '/oneweb/channel_recommend_content',
        'banner-list' => '/oneweb/banner-list',
        'flagship-product' => '/oneweb/flagship_product',
        'product-list' => '/oneweb/product_list',
        'rs-recommend-brand' => '/oneweb/recommend_rs_brand',
        'rs-recommend-brand-new' => '/oneweb/recommend_rs_brand_new', // 品牌頁
        'rs-recommend-special' => '/oneweb/recommend_rs_special',
        'bt-recommend-special' => '/oneweb/recommend_bt_special',
        'es-recommend-products' => '/oneweb/recommend_es_products',
        'es-recommend-foreign' => '/oneweb/recommend_es_foreign',
        'sh-recommend-brand' => '/oneweb/recommend_sh_brand', // SH 名店美食
        'sh-recommend-products' => '/oneweb/recommend_sh_products', // SH 限時優惠
        'event_list' => '/oneweb/event_list',
        'coffee-shop-list' => '/oneweb/coffee_shop_list',
        'recommend-list' => '/oneweb/recommend_list',
        'other-products' => '/oneweb/other_products', // 其他檔次列表
        'search' => '/oneweb/search',
        'preview' => '/oneweb/preview',
        'product-info' => '/oneweb/product_info',
        'brand-product-list' => '/oneweb/brand_product_list',
        'store-page' => '/oneweb/store/page', // 店家資訊
        'get-inventory' => '/oneweb/get_inventory', // 規格選擇頁
        'get-ref-expriytime' => '/oneweb/service/getRefExpiryTime',
        'get-site-cooperation' => '/oneweb/service/getSiteCooperation',
        'channel-event-setting' => '/oneweb/service/channel_event_setting',
        'contact-info' => '/oneweb/customer/contact_info',
        'faq_list' => '/oneweb/customer/faq_list',
        'history-list' => '/oneweb/customer/history_list', // 關於 公司記事
        'media-reports' => '/oneweb/customer/media_reports', // 關於 媒體報導
        'ticket-info' => '/oneweb/customer/ticket_info', // 客服留言
        'contact-highprice' => '/oneweb/support/contact_highprice',
        'contact-violations' => '/oneweb/support/contact_violations',
        'insight-xplorer-info' => '/insight-xplorer/user-info', // 創市際 用戶資料查詢
        'affiliate-stores' => '/oneweb/affiliate/stores', // 聯盟行銷列表
        'affiliate-stores-detail' => '/oneweb/affiliate/stores/%s', // 聯盟行銷詳細資訊
        'home-special-position' => '/oneweb/home_special_position', // 十週年特別版位
        'home-data' => '/oneweb/home_data/city/%s', // 首頁資訊
        'home-recommend-list' => '/oneweb/home_recommend_list/city/%s', // 首頁推薦檔次
        'hot-keywords' => '/oneweb/hot_keywords', // 熱門關鍵字
        'short-url' => '/oneweb/short_url', // Line資訊
        'is-signup' => '/arpu/is_signup', // 是否用戶已經註冊
        /*------------------------- gf -------------------------*/
        'gf-account-info' => '/oneweb/profile/info', // 會員資料-GET
        'gf-home-learderboard' => '/oneweb/gf-home-learderboard',
        'gf-home-learderboard-detail' => '/oneweb/home_learderboard_detail',
        'gf-get-today-special-list' => '/oneweb/get_gf_today_special_List',
        'gf-channel-recommend' => '/oneweb/gf_channel_recommend_content',
        'gf-banner-list' => '/oneweb/gf-banner-list',
        'gf-rs-recommend-brand' => '/oneweb/recommend_rs_brand',
        'gf-rs-recommend-brand-new' => '/oneweb/recommend_rs_brand_new', // 品牌頁
        'gf-rs-recommend-special' => '/oneweb/gf_recommend_rs_special',
        'gf-bt-recommend-special' => '/oneweb/gf_recommend_bt_special',
        'gf-es-recommend-products' => '/oneweb/gf_recommend_es_products',
        'gf-es-recommend-foreign' => '/oneweb/gf_recommend_es_foreign',
        'gf-sh-recommend-brand' => '/oneweb/recommend_sh_brand', // SH 名店美食
        'gf-sh-recommend-products' => '/oneweb/gf_recommend_sh_products', // SH 限時優惠
        'gf-event_list' => '/oneweb/event_list',
        'gf-coffee-shop-list' => '/oneweb/gf_coffee_shop_list',
        'gf-recommend-list' => '/oneweb/gf_recommend_list',
        'gf-search' => '/oneweb/gf_search',
        'gf-preview' => '/oneweb/preview',
        'gf-category-list' => '/oneweb/category_list', // 頻道分類
        'gf-product-list' => '/oneweb/gf_product_list',
        'gf-other-products' => '/oneweb/other_products', // 其他檔次列表
        'gf-product-info' => '/oneweb/gf_product_info',
        'gf-store-page' => '/oneweb/store/page', // 店家資訊
        'gf-get-inventory' => '/oneweb/get_inventory', // 規格選擇頁
        'gf-get-ref-expriytime' => '/oneweb/service/getRefExpiryTime',
        'gf-get-site-cooperation' => '/oneweb/service/getSiteCooperation',
        'gf-channel-event-setting' => '/oneweb/service/channel_event_setting',
        'gf-contact-info' => '/oneweb/customer/contact_info',
        'gf-faq_list' => '/oneweb/customer/faq_list',
        'gf-history-list' => '/oneweb/customer/history_list', // 關於 公司記事
        'gf-media-reports' => '/oneweb/customer/media_reports', // 關於 媒體報導
        'gf-ticket-info' => '/oneweb/customer/ticket_info', // 客服留言
        'gf-contact-highprice' => '/oneweb/support/contact_highprice',
        'gf-contact-violations' => '/oneweb/support/contact_violations',
        'gf-insight-xplorer-info' => '/insight-xplorer/user-info', // 創市際 用戶資料查詢
        'gf-affiliate-stores' => '/oneweb/affiliate/stores', // 聯盟行銷列表
        'gf-affiliate-stores-detail' => '/oneweb/affiliate/stores/%s', // 聯盟行銷詳細資訊
        'gf-home-special-position' => '/oneweb/gf_home_special_position', // 十週年特別版位
        'gf-home-data' => '/oneweb/gf_home_data/city/%s', // 首頁資訊
        'gf-home-recommend-list' => '/oneweb/gf_home_recommend_list/city/%s', // 首頁推薦檔次
        'gf-hot-keywords' => '/oneweb/gf_hot_keywords', // 熱門關鍵字
        'gf-short-url' => '/oneweb/short_url', // Line資訊
        'gf-is-signup' => '/arpu/is_signup', // 是否用戶已經註冊
    ];
    protected $cccApiList = [
        'account-subscribe' => '/oneweb/profile/subscribe', // 會員資料-POST
        'update-soldout-mail' => '/oneweb/update_soldout_mail',
        'contact-highprice-send' => '/oneweb/support/contact_highprice_send',
        'contact-violations-send' => '/oneweb/support/contact_violations_send',
        'epaper-subscribe' => '/oneweb/support/follow_email_send', // 訂閱電子報
        'epaper-cancel' => '/oneweb/support/follow_cancel_send',  // 取消訂閱電子報
        'store-error-report' => '/oneweb/store/report', // 店家錯誤回報
        'rating-form' => '/oneweb/user/rating-form', // 取得評價頁資訊
        'rating-history' => '/oneweb/user/rating-history', // 查看評價紀錄
        'rating-submit' => '/oneweb/user/rating-submit', // 送出評價
        'invoice_map_account' => '/oneweb/customer/invoice_map_account',
        'purchase_history' => '/oneweb/customer/purchase_history',
        'insert-contact' => '/oneweb/customer/insert_contact',
        'insert-ticket-info' => '/oneweb/customer/insert_reply_ticket', // 回覆客服留言
        'purchase-verify' => '/oneweb/customer/purchase_verify', // 聯絡客服頁 預設訂單資訊
        'get-user-info' => '/oneweb/user/get_user_info', // 取得用戶基本資訊
        'insight-xplorer-subscribe'   => '/insight-xplorer/subscribe-user',   // 創市際 用戶訂閱、修改資料
        'insight-xplorer-unsubscribe' => '/insight-xplorer/unsubscribe-user', // 創市際 用戶取消訂閱
        'member-edm-status' => '/oneweb/support/member_edm_status', // 取得訂閱EDM資訊
        'member-edm-update' => '/oneweb/support/member_edm_update', // 更新訂閱EDM資訊
        'product-rating-info' => '/oneweb/product_rating_info', // 取得商品評價資訊
        'product-rating-list' => '/oneweb/product_rating_list', // 取得篩選的商品評價資訊
        'update-soldout-mail' => '/oneweb/update_soldout_mail', // 更新搶購完畢信件
        'login' => '/oneweb/user/login', // 登入 發送手機號碼驗證碼
        'bind-email' => '/oneweb/user/bind_email', // 登入 選擇登入的Email
        'verify' => '/oneweb/user/verify', // 登入 確認驗證碼
        'login-buy123' => '/oneweb/user/get_buy123_token', // 登入 生活市集的登入
        'login-esmarket' => '/oneweb/user/get_esmarket_token', // 登入 ES商城的登入
        'login-shopify' => '/shopify/multipass_login', // 登入 shopify的登入
        'redirect-shopify' => '/shopify/multipass_redirect', // 登入 Shopify的跳轉頁連結
        'login-line' => '/oneweb/profile/line', // 登入 line的登入
        'signup' => '/arpu/signup', // 登記註冊
        /*------------------------- gf -------------------------*/
        'gf-account-subscribe' => '/oneweb/profile/subscribe', // 會員資料-POST
        'gf-update-soldout-mail' => '/oneweb/update_soldout_mail',
        'gf-contact-highprice-send' => '/oneweb/support/contact_highprice_send',
        'gf-contact-violations-send' => '/oneweb/support/contact_violations_send',
        'gf-store-error-report' => '/oneweb/store/report', // 店家錯誤回報
        'gf-insert-contact' => '/oneweb/customer/insert_contact',
        'gf-insert-ticket-info' => '/oneweb/customer/insert_reply_ticket', // 回覆客服留言
        'gf-purchase-verify' => '/oneweb/customer/purchase_verify', // 聯絡客服頁 預設訂單資訊
        'gf-insight-xplorer-subscribe'   => '/insight-xplorer/subscribe-user',   // 創市際 用戶訂閱、修改資料
        'gf-insight-xplorer-unsubscribe' => '/insight-xplorer/unsubscribe-user', // 創市際 用戶取消訂閱
        'gf-rating-form' => '/oneweb/user/rating-form', // 取得評價頁資訊
        'gf-rating-history' => '/oneweb/user/rating-history', // 查看評價紀錄
        'gf-rating-submit' => '/oneweb/user/rating-submit', // 送出評價
        'gf-get-user-info' => '/oneweb/user/get_user_info', // 取得用戶基本資訊
        'gf-member-edm-status' => '/oneweb/support/oneweb/member_edm_status', // 取得訂閱EDM資訊
        'gf-member-edm-update' => '/oneweb/support/member_edm_update', // 更新訂閱EDM資訊
        'gf-product-rating-info' => '/oneweb/product_rating_info', // 取得商品評價資訊
        'gf-product-rating-list' => '/oneweb/product_rating_list', // 取得篩選的商品評價資訊
        'gf-update-soldout-mail' => '/oneweb/update_soldout_mail', // 更新搶購完畢信件
        'gf-login' => '/oneweb/user/login', // 登入 發送手機號碼驗證碼
        'gf-bind-email' => '/oneweb/user/bind_email', // 登入 選擇登入的Email
        'gf-verify' => '/oneweb/user/verify', // 登入 確認驗證碼
        'gf-login-buy123' => '/oneweb/user/get_buy123_token', // 登入 生活市集的登入
        'gf-login-esmarket' => '/oneweb/user/get_esmarket_token', // 登入 ES商城的登入
        'gf-login-shopify' => '/shopify/multipass_login', // 登入 shopify的登入
        'gf-redirect-shopify' => '/shopify/multipass_redirect', // 登入 Shopify的跳轉頁連結
        'gf-login-line' => '/oneweb/profile/line', // 登入 line的登入
        'gf-signup' => '/arpu/signup', // 登記註冊
    ];

    /**
     * Dependency Injection
     */
    public function __construct(ApiRepository $apiRepository)
    {
        $this->apiRepository = $apiRepository;
    }

    /**
     * Call Api
     * @param string $url      請求網址名稱
     * @param string $method   請求方法
     * @param array  $param    請求參數
     * @param array  $urlParam 請求網址路徑的參數
     * @param array  $header   請求標頭
     * @return array
     */
    public function curl($url, $method = 'GET', $param = [], $urlParam = [], $header = [])
    {
        // 非指定的 api 名稱，直接 call 傳入的 url
        if (!isset($this->dddApiList[$url]) && !isset($this->cccApiList[$url])) {
            // 處理 $url 有 query string parameter 時，寫進 $param
            $urlAry = explode('?', $url);
            $realUrl = $urlAry[0] ?? '';
            if (!empty($urlAry[1])) {
                $queryStringAry = explode('&', $urlAry[1]);
                foreach ($queryStringAry as $value) {
                    $queryString = explode('=', $value);
                    $param[$queryString[0]] = $queryString[1] ?? '';
                }
            }
            return $this->apiRepository->curl($realUrl, $method, $param, $header);
        }

        // ===== 返利網 =====
        $gfType = ''; // 返利網類型
        $prefix = ''; // API 前綴字

        $this->handleRef($gfType, $prefix);

        $url = sprintf('%s%s', $prefix, $url);
        if (!empty($gfType)) {
            $param['gf_type'] = $gfType;
        }
        // ===== End: 返利網 =====

        // 判斷裝置（pc: 0, mweb: 1）
        $platform = 0;
        $detect = new Mobile_Detect();
        if ($detect->isMobile() && !$detect->isTablet()) {
            $platform = 1;
        }
        $header['X-GOMAJI-Platform'] = $platform;

        // 檢查是 ddd 的 api 還是 ccc 的
        if (isset($this->dddApiList[$url])) {
            return $this->apiRepository->curl(self::DDD_DOMAIN . vsprintf($this->dddApiList[$url], $urlParam), $method, $param, $header);
        }
        if (isset($this->cccApiList[$url])) {
            return $this->apiRepository->curl(self::CCC_DOMAIN . vsprintf($this->cccApiList[$url], $urlParam), $method, $param, $header);
        }
    }

    /**
     * 處理返利網
     * @param string $gfType 返利網類型
     * @param string $prefix API前綴字
     * @return void
     */
    protected function handleRef(&$gfType, &$prefix)
    {
        if (empty($_COOKIE['gmc_site_pay'])) {
            return;
        }

        switch ($_COOKIE['gmc_site_pay']) {
            case 'ref_' . Config('ref.id.maShop'):
                $gfType = 'ma';
                $prefix = 'gf-';
                break;
            case 'ref_' . Config('ref.id.shopback'):
                $gfType = 'sb';
                $prefix = 'gf-';
                break;
            case 'ref_' . Config('ref.id.line'):
                $gfType = 'line';
                $prefix = 'gf-';
                break;
            case 'ref_' . Config('ref.id.ichannels'):
                $gfType = 'ichannels';
                $prefix = 'gf-';
                break;
            case 'ref_' . Config('ref.id.lineTrav'):
                $gfType = 'line_trav';
                $prefix = 'gf-';
                break;
        }

        return;
    }
}
