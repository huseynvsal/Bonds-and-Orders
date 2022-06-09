<?php

use App\Http\Controllers\BondController;
use App\Http\Controllers\OrderController;
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

Route::get('/bond/{id}/payouts', [BondController::class, 'interest_dates'])->name('interest_dates');
Route::post('/bond/{id}/order', [OrderController::class, 'bond_order'])->name('bond_order');
Route::post('/bond/order/{order_id}', [OrderController::class, 'interest_payments'])->name('interest_payments');

