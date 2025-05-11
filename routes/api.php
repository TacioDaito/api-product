<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::middleware(['client', 'throttle:api'])->group(function () 
{
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index');
        Route::post('/user/show', 'show');
        Route::post('/user/store', 'store');
        Route::put('/user/update', 'update');
        Route::delete('/user/delete', 'destroy');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order', 'index');
        Route::post('/order/show', 'show');
        Route::post('/order/store', 'store');
        Route::put('/order/update', 'update');
        Route::delete('/order/delete', 'destroy');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product', 'index');
        Route::post('/product/show', 'show');
        Route::post('/product/store', 'store');
        Route::put('/product/update', 'update');
        Route::delete('/product/delete', 'destroy');
    });
});