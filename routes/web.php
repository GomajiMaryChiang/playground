<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\About\AboutUsController;
use App\Http\Controllers\About\PrivacyController;
use App\Http\Controllers\About\StakeHolderController;
use App\Http\Controllers\About\TermsController;
use App\Http\Controllers\Api\RatingController as ApiRatingController;
use App\Http\Controllers\Api\ContactController as ApiContactController;
use App\Http\Controllers\Contact\AccountController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Contact\EpaperController;
use App\Http\Controllers\Contact\HelpController;
use App\Http\Controllers\Contact\InformationController;
use App\Http\Controllers\Contact\StoreHighPriceController;
use App\Http\Controllers\Contact\StoreViolationController;
use App\Http\Controllers\Errors\DisappearController;
use App\Http\Controllers\Errors\ServerErrorController;
use App\Http\Controllers\Event\RebateController;
use App\Http\Controllers\Listing\BrandController;
use App\Http\Controllers\Listing\BrandDetailController;
use App\Http\Controllers\Listing\ProductListController;
use App\Http\Controllers\Listing\SpecialListController;
use App\Http\Controllers\Main\ChannelController;
use App\Http\Controllers\Main\CheckoutController;
use App\Http\Controllers\Main\IndexController;
use App\Http\Controllers\Main\LoginController;
use App\Http\Controllers\Main\ProductDetailController;
use App\Http\Controllers\Main\StoreController;
use App\Http\Controllers\Publicize\AnnouncementController;
use App\Http\Controllers\Publicize\AppController;
use App\Http\Controllers\Publicize\KolController;
use App\Http\Controllers\Secondary\EarnpointController;
use App\Http\Controllers\Secondary\RatingController;
use App\Http\Controllers\Secondary\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ===== About =====
Route::get('/about', [AboutUsController::class, 'introduction']); // 關於 關於我們
Route::get('/about/introduction', [AboutUsController::class, 'introduction']); // 關於 關於我們
Route::get('/about/event', [AboutUsController::class, 'event']); // 關於 公司記事
Route::get('/about/newsroom', [AboutUsController::class, 'newsroom']); // 關於 媒體報導
Route::get('/privacy', PrivacyController::class); // 隱私權政策
Route::get('/stakeholder', StakeHolderController::class); // 投資人管理專區
Route::get('/terms', TermsController::class); // 服務條款
// ===== End: About =====


// ===== Api =====
Route::post('/sendRatingForm', [ApiRatingController::class, 'form']); // 新增評價
Route::middleware(['throttle.custom:api.custom'])->post('/sendContact', [ApiContactController::class, 'contact']); // 店家合作、客服信箱
// ===== End: Api =====


// ===== Contact =====
Route::get('/account', AccountController::class); // 會員資料搜集頁
Route::get('/help/contact', ContactController::class);      // 聯絡我們 預設「店家合作」項目
Route::get('/help/contact/{id}', ContactController::class); // 聯絡我們 指定項目
Route::any('/captchaReload', [ContactController::class, 'captchaReload']); // 更新驗證碼
Route::get('/help/contact_record', [ContactController::class, 'message']); // 客服留言瀏覽頁
Route::get('/epaper', EpaperController::class); // 取消訂閱電子報頁
Route::get('/help', HelpController::class); // 客服中心
Route::get('/information', InformationController::class); // 創市際問券 基本資料填寫頁
Route::get('/store_highPrice/pid/{productId}', StoreHighPriceController::class); // 價高通報
Route::get('/store_violation/pid/{productId}', StoreViolationController::class); // 店家洗單通報
// ===== End: Contact =====


// ===== Errors =====
Route::get('/404', DisappearController::class); // 404 頁面不存在
Route::fallback([DisappearController::class, 'redirectToEvent']); // 沒有被定義的路徑導到event.gomaji.com
Route::get('/500', ServerErrorController::class); // 500 錯誤頁
// ===== End: Errors =====


// ===== Event =====
Route::get('/rebate', RebateController::class); // 核銷登記活動頁面
// ===== Event =====


// ===== Listing =====
Route::get('/brand', BrandController::class); // 星級飯店＆品牌餐廳
Route::get('/sh_brand', [BrandController::class, 'delivery']); // SH 名店美食
Route::get('/brand/{brand}', BrandDetailController::class); // 星級飯店＆品牌餐廳 檔次列表
Route::get('/coffee/brand/{groupId}', [BrandDetailController::class, 'coffee']); // 咖啡品牌列表
Route::get('/sh_brand/{brand}', BrandDetailController::class); // SH 名店美食 檔次列表
Route::get('/category/{categoryId}', ProductListController::class);           // 檔次列表 主題頁
Route::get('/event_list', ProductListController::class);                    // 檔次列表 活動頁
Route::get('/special/{id}', [ProductListController::class, 'special']);     // 檔次列表 特別企劃
Route::get('/top/{id}', [ProductListController::class, 'special']);         // 檔次列表 排行榜
Route::get('/510', [ProductListController::class, 'publicWelfare']);        // 檔次列表 公益
Route::get('/es_foreign', [ProductListController::class, 'esForeign']);     // 檔次列表 宅配生鮮
Route::get('/flash_sale', [ProductListController::class, 'rsSpecial']);     // 檔次列表 RS限時搶購
Route::get('/new_open', [ProductListController::class, 'rsSpecial']);       // 檔次列表 RS首次開賣
Route::get('/drinks', [ProductListController::class, 'rsSpecial']);         // 檔次列表 RS喝飲料
Route::get('/bt_flash_sale', [ProductListController::class, 'btSpecial']);  // 檔次列表 BT限時搶購
Route::get('/bt_chain_store', [ProductListController::class, 'btSpecial']); // 檔次列表 BT連鎖品牌
Route::get('/travel_fair', [ProductListController::class, 'esSpecial']);    // 檔次列表 ES線上旅展
Route::get('/sh_special', [ProductListController::class, 'shSpecial']);     // 檔次列表 SH限時優惠
Route::get('/special', [SpecialListController::class, 'special']); // 特別企劃
Route::get('/top', [SpecialListController::class, 'top']); // 排行榜
// ===== End: Listing =====


// ===== Main =====
Route::get('/ch/{ch}', ChannelController::class);      // 頻道頁
Route::get('/channel/{ch}', ChannelController::class); // 頻道頁別名，「/channel/restaurant」、「/channel/beauty」之類的舊稱
Route::get('/checkout/pid/{pid}/spid/{spid}', CheckoutController::class); // 宅配商品規格選擇頁面
Route::get('/', IndexController::class); // 首頁
Route::get('/login', LoginController::class); // 登入頁
Route::get('/store/{storeId}/pid/{productId}', ProductDetailController::class); // 檔次頁
Route::get('/coffee/brand/{groupId}/pid/{productId}', ProductDetailController::class); // 檔次頁 麻吉咖啡
Route::get('/preview', [ProductDetailController::class, 'preview']); // 預覽檔次頁
Route::get('/redirect', [ProductDetailController::class, 'redirect']); // 轉跳頁
Route::get('/store/{storeId}', StoreController::class); // 店家頁
Route::get('/store/{storeId}/branch/{branchId}', StoreController::class); // 店家頁 指定分店
Route::get('/store/{storeId}/intro', [StoreController::class, 'intro']); // 店家介紹頁
// ===== End: Main =====


// ===== Publicize =====
Route::get('/announcement', AnnouncementController::class); // 公告頁
Route::get('/app', AppController::class);    // APP 下載頁
Route::get('/invite', AppController::class); // APP 邀請頁
Route::post('/app/sendAppSms', [AppController::class,'sendAppSms']); // 傳送簡訊
Route::get('/kol', KolController::class); // 網紅推薦
Route::get('/kol/{ch}', KolController::class); // 網紅推薦 指定Tab
// ===== End: Publicize =====


// ===== Secondary =====
Route::get('/earnpoint', [EarnpointController::class, 'list']); // 聰明賺點列表
Route::get('/earnpoint/{storeId}', [EarnpointController::class, 'detail']); // 聰明賺點詳細頁
Route::post('/earnpoint/jumpthirdparty', [EarnpointController::class, 'jump']); // 聰明賺點跳轉頁
Route::get('/rating-form', [RatingController::class, 'form']); // 評價頁
Route::post('/rating-done', [RatingController::class, 'done']); // 評價完成頁
Route::get('/view-rating', [RatingController::class, 'view']); // 編輯評價頁
Route::get('/search', SearchController::class); // 搜尋結果頁
// ===== End: Secondary =====
