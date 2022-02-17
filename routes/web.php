<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
]);

Route::get('/pos', [App\Http\Controllers\HomeController::class, 'pos'])->name('pos');
Route::post('/order_summary', [App\Http\Controllers\HomeController::class, 'orderSummary'])
    ->name('order.summary');
Route::post('/process_order', [App\Http\Controllers\HomeController::class, 'processOrder'])->name('process.order');

// route withou loading
Route::post('/add_order', [App\Http\Controllers\HomeController::class, 'addOrder']);
Route::post('/remove_order_menu', [App\Http\Controllers\HomeController::class, 'removeOrderMenu']);
Route::post('/reset_order', [App\Http\Controllers\HomeController::class, 'resetOrder']);
Route::post('/apply_coupon', [App\Http\Controllers\HomeController::class, 'applyCoupon']);

Route::get('/order_transactions', [App\Http\Controllers\HomeController::class, 'orders'])->name('order_transactions');