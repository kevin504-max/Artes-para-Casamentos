<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\frontend\FrontendController;
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

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-auth', [AuthController::class, 'getAuthUser']);


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
