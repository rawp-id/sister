<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{
    public function show($id)
    {
        $token = config('services.product_app_key');

        $produk = Http::withToken($token)
            ->get('http://localhost:6060/api/product')
            ->json();
        // dd($produk);
        $produk = collect($produk)->where('id', $id)->first();
        
        $user = User::find(Auth::id());
        // dd($user->address);

        return view('produk.show', compact('produk', 'user'));
    }
}
