@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Order Dashboard</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table-auto w-full bg-white shadow-md rounded border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Purchaser</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border">Product</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Total Price</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="px-4 py-2 border">{{ $order->custom_id }}</td>
                    <td class="px-4 py-2 border">{{ $order->purchaser }}</td>
                    <td class="px-4 py-2 border">{{ $order->address }}</td>
                    <td class="px-4 py-2 border">{{ $order->product->name }}</td>
                    <td class="px-4 py-2 border">{{ $order->quantity }}</td>
                    <td class="px-4 py-2 border">{{ $order->total_price }}</td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 text-sm {{ $order->status == 'pending' ? 'bg-yellow-200' : ($order->status == 'completed' ? 'bg-green-200' : 'bg-red-200') }} rounded">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('orders.edit', $order->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
