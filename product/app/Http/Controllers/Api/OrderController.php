<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::with('product')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchaser' => 'required|string|max:255', // Validate purchaser
            'address' => 'required|string|max:255',   // Validate address
        ]);

        $product = Product::findOrFail($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'purchaser' => $request->purchaser, // Set purchaser
            'address' => $request->address,     // Set address
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'success' => true,
            'data' => $order->custom_id,
        ],201);
    }

    /**
     * Display the specified order.
     *
     * @param  Order  $order
     * @return JsonResponse
     */
    public function show($order_id): JsonResponse
    {
        $order= Order::with('product')->where('custom_id', $order_id)->first();
        return response()->json($order);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  Request  $request
     * @param  Order  $order
     * @return JsonResponse
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
            'status' => 'nullable|in:pending,completed,cancelled',
            'address' => 'nullable|string|max:255', // Validate address
        ]);

        if ($request->has('quantity')) {
            $order->quantity = $request->quantity;
            $order->total_price = $order->product->price * $request->quantity;
        }

        if ($request->has('status')) {
            $order->status = $request->status;
        }

        if ($request->has('address')) {
            $order->address = $request->address; // Update address
        }

        $order->save();

        return response()->json($order);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  Order  $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully.']);
    }
}

