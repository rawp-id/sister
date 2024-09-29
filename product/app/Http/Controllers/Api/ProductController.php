<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Display the specified product.
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function getAddressByProduct($id)
    {
        $product = Product::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'address' => $product->user->address,
        ]);
    }
}
