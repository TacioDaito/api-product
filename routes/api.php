<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::middleware(['client', 'throttle:api'])->group(function () 
{
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::post('/users/show', 'show');
        Route::post('/users/store', 'store');
        Route::put('/users/update', 'update');
        Route::delete('/users/delete', 'destroy');
    });
});