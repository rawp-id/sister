@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Parcels</h1>
        <a href="{{ route('parcels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Parcel
        </a>
        <div class="overflow-x-auto mt-5">
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Product Name</th>
                        <th class="py-3 px-6 text-left">Recipient Name</th>
                        <th class="py-3 px-6 text-left">Shipper Name</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($parcels as $parcel)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $parcel->name_product }}</td>
                            <td class="py-3 px-6 text-left">{{ $parcel->name_recipient }}</td>
                            <td class="py-3 px-6 text-left">{{ $parcel->name_shipper }}</td>
                            <td class="py-3 px-6 text-left">{{ $parcel->status }}</td>
                            <td class="py-3 px-6 text-center">
                                <a type="button" href="{{ route('parcels.edit', $parcel->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-4 rounded me-3">
                                    Edit
                                </a>
                                <form action="{{ route('parcels.destroy', $parcel->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
