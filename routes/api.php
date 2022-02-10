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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search_menu', [App\Http\Controllers\API\ApiController::class, 'searchMenu']);
Route::post('/add_order', [App\Http\Controllers\API\ApiController::class, 'addOrder']);
Route::post('/remove_order_menu', [App\Http\Controllers\API\ApiController::class, 'removeOrderMenu']);
Route::post('/reset_order', [App\Http\Controllers\API\ApiController::class, 'resetOrder']);
Route::post('/apply_coupon', [App\Http\Controllers\API\ApiController::class, 'applyCoupon']);
