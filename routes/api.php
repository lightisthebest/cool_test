<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/**
 * @uses \App\Http\Controllers\ApiController::createNewMessage()
 */
Route::middleware(['set_locale', 'throttle:30'])->post('send-message', '\App\Http\Controllers\ApiController@createNewMessage');

/**
 * @uses \App\Http\Controllers\ApiController::resetMyIp()
 */
Route::get('reset', '\App\Http\Controllers\ApiController@resetMyIp');

/**
 * @uses \App\Http\Controllers\ApiController::genDocs()
 */
Route::get('gen_docs', '\App\Http\Controllers\ApiController@genDocs');
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
