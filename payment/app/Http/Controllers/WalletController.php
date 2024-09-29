<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show($walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $transactions = Transaction::where('wallet_id', $walletId)->get();

        return view('dashboard.wallet', compact('wallet', 'transactions'));
    }

}
