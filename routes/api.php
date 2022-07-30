<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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


Route::group(['prefix' => 'customer'], function () {
    Route::get('/{id?}', [CustomerController::class, 'get']);
    Route::post('/', [CustomerController::class, 'save']);
    Route::put('/', [CustomerController::class, 'save']);
    Route::delete('/', [CustomerController::class, 'destroy']);
});


Route::group(['prefix' => 'product'], function () {
    Route::get('/{id?}', [ProductController::class, 'get']);
    Route::post('/', [ProductController::class, 'save']);
    Route::put('/', [ProductController::class, 'save']);
    Route::delete('/', [ProductController::class, 'destroy']);
});


Route::group(['prefix' => 'order'], function () {
    Route::get('/{id?}', [OrderController::class, 'get']);
    Route::post('/', [OrderController::class, 'save']);
    Route::put('/', [OrderController::class, 'save']);
    Route::delete('/', [OrderController::class, 'destroy']);
});
