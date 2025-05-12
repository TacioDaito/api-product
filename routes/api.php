<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::middleware(['oauth_client', 'throttle:api'])->group(function () 
{
    Route::apiResources([
        'client' => ClientController::class,
        'order' => OrderController::class,
        'product' => ProductController::class,
    ]);
});