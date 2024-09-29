<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('product', ProductController::class);
    Route::get('order/{order_id}', [OrderController::class,'show']);
    Route::apiResource('order', OrderController::class);
    Route::get('/product/{id}/address', [ProductController::class, 'getAddressByProduct']);
});


