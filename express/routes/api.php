<?php

use App\Http\Controllers\Api\ParcelController;
use App\Http\Middleware\CheckCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('parcels', ParcelController::class)->names([
    'index' => 'api.parcels.index',
    'store' => 'api.parcels.store',
    'show' => 'api.parcels.show',
    'update' => 'api.parcels.update',
    'destroy' => 'api.parcels.destroy',
])->middleware('auth:sanctum');

// Route::get('/hello', function () {
//     return Response::json(['message' => 'Hello World!']);
// })->middleware(CheckCors::class);
