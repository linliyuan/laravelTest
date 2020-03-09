<?php

use Illuminate\Http\Request;

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
    'prefix' => 'auth'
], function ($router) {
    Route::get('login',function (){
        return json_error_response(\App\Utils\ErrorCode::$sessionExpired,'登录信息过期，请重新登录');
    })->name('login');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
    //注册需要独立出来，未注册前没有token
//    Route::post('register','AuthController@register');
});
