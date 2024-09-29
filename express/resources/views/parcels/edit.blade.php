@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Edit Parcel</h1>

        <form action="{{ route('parcels.update', $parcel->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name_product" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name_product" id="name_product" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       value="{{ old('name_product', $parcel->name_product) }}" required>
                @error('name_product')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name_recipient" class="block text-sm font-medium text-gray-700">Recipient Name</label>
                <input type="text" name="name_recipient" id="name_recipient" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       value="{{ old('name_recipient', $parcel->name_recipient) }}" required>
                @error('name_recipient')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name_shipper" class="block text-sm font-medium text-gray-700">Shipper Name</label>
                <input type="text" name="name_shipper" id="name_shipper" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       value="{{ old('name_shipper', $parcel->name_shipper) }}" required>
                @error('name_shipper')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address_shipper" class="block text-sm font-medium text-gray-700">Shipper Address</label>
                <input type="text" name="address_shipper" id="address_shipper" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       value="{{ old('address_shipper', $parcel->address_shipper) }}" required>
                @error('address_shipper')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address_recipient" class="block text-sm font-medium text-gray-700">Recipient Address</label>
                <input type="text" name="address_recipient" id="address_recipient" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       value="{{ old('address_recipient', $parcel->address_recipient) }}" required>
                @error('address_recipient')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        required>
                    <option value="" disabled>Select Status</option>
                    <option value="pending" {{ old('status', $parcel->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ old('status', $parcel->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ old('status', $parcel->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="delivered" {{ old('status', $parcel->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" 
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Update
            </button>
        </form>
    </div>
@endsection
