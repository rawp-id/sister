<?php

use App\Models\Wallet;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;

// Route::get('/register', [RegisterController::class, 'showUserRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);

// Route::get('/register/patner', [RegisterController::class, 'showPatnerRegistrationForm'])->name('register.patner');
// Route::post('/register/patner', [RegisterController::class, 'registerPatner']);

// Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        return view('dashboard', compact('wallet'));
    })->name('dashboard');
});

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/wallet/{walletId}', [WalletController::class, 'show'])->name('wallet.show');
