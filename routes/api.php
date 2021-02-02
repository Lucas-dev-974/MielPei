<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\ordinateursController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\VendorsController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'vendors'
], function ($router) {
    Route::post('add', [VendorsController::class, 'add_vendor']);
    Route::post('update', [VendorsController::class, 'updateShopName']);
    Route::post('delete', [VendorsController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'products'
], function ($router) {
    Route::post('add', [ProductsController::class, 'add']);
});

