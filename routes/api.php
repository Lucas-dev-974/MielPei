<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\ordinateursController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('attributions')->group(function () {
    Route::post('/', 'AttributionController@addAttr');
    Route::get('/{id}', 'AttributionController@deleteAttribution');
});

Route::prefix('ordinateurs')->group(function(){
    Route::get('/', 'OrdinateursController@get');
    Route::post('/', 'OrdinateursController@add');
    Route::post('/delOrdi', 'OrdinateursController@del');
    Route::post('/update', 'OrdinateursController@update');

});

Route::prefix('clients')->group(function(){
    Route::get('/search', 'ClientsController@search');
    Route::post('/add', 'ClientsController@add');
    
});