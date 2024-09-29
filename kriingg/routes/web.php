<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/file', [FileController::class, 'store']);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('product.show');

