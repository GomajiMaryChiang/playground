<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EpaperController;
use App\Http\Controllers\Api\HealthCheckController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\InvestigateController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RebateController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\StoreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ===== Account =====
Route::post('/account', [AccountController::class, 'account']); // 會員資料蒐集
// ===== End: Account =====


// ===== Contact =====
Route::post('/message', [ContactController::class, 'message']); // 回覆客服留言
// ===== End: Contact =====


// ===== Epaper =====
Route::post('/epaper', [EpaperController::class, 'subscribe']); // 訂閱電子報
Route::put('/epaper', [EpaperController::class, 'update']); // 更新訂閱電子報
Route::delete('/epaper', [EpaperController::class, 'cancel']); // 取消訂閱電子報
// ===== End: Epaper =====


// ===== HealthCheck =====
Route::get('/healthy', [HealthCheckController::class, 'check']); // 服務健康檢查
// ===== End: HealthCheck =====


// ===== History =====
Route::get('/sendHistory', [HistoryController::class, 'history']); // 購買歷史查詢
Route::get('/sendInvoice', [HistoryController::class, 'invoice']); // 發票歸戶查詢
// ===== End: History =====


// ===== Inventory =====
Route::get('/inventory', [InventoryController::class, 'inventory']); // 規格選擇內容
// ===== End: Inventory =====


// ===== Investigate =====
Route::post('/investigate', [InvestigateController::class, 'attend']); // 參與創市際問券 基本資料填寫頁
Route::delete('/investigate', [InvestigateController::class, 'cancel']); // 取消創市際問券 基本資料填寫頁
// ===== End: Investigate =====


// ===== Login =====
Route::post('/login', [LoginController::class, 'login']); // 發送驗證碼
Route::post('/bindEmail', [LoginController::class, 'bindEmail']); // 選擇登入的Email
Route::post('/verify', [LoginController::class, 'verify']); // 確認驗證碼
Route::post('/loginBuy123', [LoginController::class, 'loginBuy123']); // 生活市集的登入
Route::post('/loginEsmarket', [LoginController::class, 'loginEsmarket']); // ES商城的登入
Route::post('/loginShopify', [LoginController::class, 'loginShopify']); // Shopify的登入
Route::post('/redirectShopify', [LoginController::class, 'redirectShopify']); // Shopify的跳轉頁連結
Route::post('/loginLine', [LoginController::class, 'loginLine']); // line的登入
Route::post('/logout', [LoginController::class, 'logout']); // 登出
Route::post('/setLoginCookie', [LoginController::class, 'setLoginCookie']); // 寫入登入 cookie
// ===== End: Login =====


// ===== Product =====
Route::get('/rating', [ProductController::class, 'getRating']); // 商品評價內容資訊
Route::post('/soldOut', [ProductController::class, 'soldOut']); // 搶購完畢資訊
Route::get('/lineShare', [ProductController::class, 'lineShare']); // Line分享短網址
// ===== End: Product =====


// ===== Rebate =====
Route::post('/arpu/signup', [RebateController::class, 'signup']); // 登記註冊
// ===== End: Rebate =====


// ===== Search =====
Route::delete('/searchKeyword', [SearchController::class, 'delete']); // 刪除搜尋紀錄
// ===== End: Search =====


// ===== Store =====
Route::post('/storeViolation', [StoreController::class, 'storeViolation']); // 店家洗單通報
Route::post('/storeHighPrice', [StoreController::class, 'storeHighPrice']); // 價高通報
Route::post('/errorReport', [StoreController::class, 'errorReport']); // 店家錯誤回報
// ===== End: Store =====
