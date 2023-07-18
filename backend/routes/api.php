<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-auth', [AuthController::class, 'getAuthUser']);

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('get-categories', [DashboardController::class, 'getCategories']);
    });

    Route::name('categories.')->prefix('categories')->group(function () {
        Route::get('{id}/image', [CategoryController::class, 'getImage'])->name('getImage');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::put('update', [CategoryController::class, 'update'])->name('update');
        Route::put('destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });
});
