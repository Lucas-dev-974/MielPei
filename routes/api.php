<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandsController;
use App\Http\Controllers\MediasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\ordinateursController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ShoppingCardController;
use App\Http\Controllers\VendorsCardController;
use App\Http\Controllers\VendorsController;
use App\Models\ShoppingCard;
use App\Models\Vendors;

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
    Route::get('validToken', [AuthController::class, 'validToken']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'vendors'
], function ($router) {
    Route::post('add', [VendorsController::class, 'add_vendor']);
    Route::post('update', [VendorsController::class, 'update']);
    Route::post('delete', [VendorsController::class, 'delete']);
    Route::get('get',   [VendorsController::class, 'get']);

    Route::get('get-cards', [VendorsCardController::class, 'get_cards']);
    Route::post('add-cards', [VendorsCardController::class, 'add']);
    Route::post('update-card', [VendorsCardController::class, 'update']);
    Route::post('add-profile-img', [MediasController::class, 'set_ProfileImageVendors']);
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'products'
], function ($router) {
    Route::get('get-best-products-sold', [ProductsController::class, 'getBestProductsSold']);
    Route::post('get',    [ProductsController::class, 'getProducts']);
    Route::post('add',    [ProductsController::class, 'add']);
    Route::post('update', [ProductsController::class, 'update']);
    Route::post('delete', [ProductsController::class, 'delete']);

    Route::post('add-product-img', [MediasController::class, 'set_ImageProduct']);
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'shopping-card'
], function ($router) {
    Route::post('add', [ShoppingCardController::class, 'add']);
    Route::get('get-buyed-products', [ShoppingCardController::class, 'getBuyedCard']);
    Route::get('get-non-buyed-products', [ShoppingCardController::class, 'getNonBuyedCard']);
    Route::post('remove-to-card', [ShoppingCardController::class, 'removeToCard']);
});



Route::group([
    'middleware' => 'api',
    'prefix'     => 'commands'
], function ($router) {
    Route::post('make-command', [CommandsController::class, 'makeCommand']);
    Route::get('get', [CommandsController::class, 'get']);
   
});


Route::group([
    'middleware' => 'api',
    'prefix'     => 'admin'
], function ($router) {
    
   
});

Route::middleware('auth')->prefix('admin')->group(function(){
    Route::get('get-users', [UsersController::class, 'get_AllUsers']);
    Route::post('get-users-by-role', [UsersController::class, 'get_UserByRole']);
    Route::post('update-users-email', [UsersController::class, 'update_UserMail']);
    Route::post('delete-users-account', [UsersController::class, 'delete_UserAccount']);
    Route::post('disable-users-account', [UsersController::class, 'disable_UserAccount']); // 2 tranchant, active et désactive un compte user
    Route::post('update-users-role', [UsersController::class, 'update_UserRole']);
});
