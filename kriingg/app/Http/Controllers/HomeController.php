<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $token = config('services.product_app_key');
        // dd($token);

        $produk = Http::withToken($token)
            ->get('http://localhost:6060/api/product')
            ->json();
        // dd($produk);
        return view('home', compact('produk'));
    }
}
