@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Product Details</h1>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <p class="mt-1 text-lg">{{ $product->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <p class="mt-1">{{ $product->description }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Price</label>
            <p class="mt-1">{{ $product->price }}</p>
        </div>
        @if($product->image)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <img src="{{ asset('storage/' . $product->image) }}" class="mt-2 w-48 h-48 object-cover" alt="Product Image">
            </div>
        @endif
        <div class="flex justify-end">
            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">Back to List</a>
        </div>
    </div>
</div>
@endsection
