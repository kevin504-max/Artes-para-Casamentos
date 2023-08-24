<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/home', [FrontendController::class, 'index']);
Route::get('{id}/featuredImage', [FrontendController::class, 'getImage']);

Route::get('get-products', [ProductController::class, 'getProducts']);
Route::get('get-product/{slug}', [ProductController::class, 'getProductBySlug']);
Route::get('{category_slug}/products', [ProductController::class, 'getProductsByCategory']);
Route::get('{id}/thumbnail', [ProductController::class, 'getThumbnail'])->name('getThumbnail');
Route::get('{id}/gallery', [ProductController::class, 'getGallery'])->name('getGallery');

Route::get('get-categories', [CategoryController::class, 'getCategories']);
Route::get('get-category/{slug}', [CategoryController::class, 'getCategoryBySlug']);
Route::get('{id}/image', [CategoryController::class, 'getImage'])->name('getImage');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('add-to-cart', [CartController::class, 'addProduct']);
Route::post('update-cart', [CartController::class, 'updateCart']);
Route::post('delete-cart-item', [CartController::class, 'removeProduct']);

Route::get('get-session/{user_id}', [CheckoutController::class, 'getSessionData']);
Route::get('success', [CheckoutController::class, 'success'])->name('checkoutSuccess');
Route::get('cancel', [CheckoutController::class, 'cancel'])->name('checkoutCancel');
Route::post('/webhook', [CheckoutController::class, 'webhook']);
Route::post('/registerMessage', [CheckoutController::class, 'registerMessage']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-auth', [AuthController::class, 'getAuthUser']);

    Route::get('cart', [CartController::class, 'viewCart']);
    Route::get('load-cart-data', [CartController::class, 'cartCount']);

    Route::get('my-orders', [UserController::class, 'getOrders']);
    Route::get('view-order/{tracking_number}', [UserController::class, 'viewOrder']);

    Route::get('get-orders', [OrderController::class, 'getOrders']);
    Route::get('view-order/{orderId}', [OrderController::class, 'viewOrder']);

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('get-categories', [DashboardController::class, 'getCategories']);
        Route::get('get-products', [DashboardController::class, 'getProducts']);
    });

    Route::name('categories.')->prefix('categories')->group(function () {
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::post('update', [CategoryController::class, 'update'])->name('update');
        Route::post('status-update', [CategoryController::class, 'updateStatus'])->name('updateStatus');
        Route::post('destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::name('products.')->prefix('products')->group(function () {
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::post('update', [ProductController::class, 'update'])->name('update');
        Route::post('status-update', [ProductController::class, 'updateStatus'])->name('updateStatus');
        Route::post('destroy', [ProductController::class, 'destroy'])->name('destroy');
    });
});
