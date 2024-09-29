<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    public function index()
    {
        $parcels = Parcel::all();
        return view('parcels.index', compact('parcels'));
    }

    public function create()
    {
        return view('parcels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_product' => 'required|string',
            'name_recipient' => 'required|string',
            'address_shipper' => 'required|string',
            'name_shipper' => 'required|string',
            'address_recipient' => 'required|string'
        ]);

        Parcel::create($request->all());

        return redirect()->route('parcels.index')->with('success', 'Parcel created successfully.');
    }

    public function edit(Parcel $parcel)
    {
        return view('parcels.edit', compact('parcel'));
    }

    public function update(Request $request, Parcel $parcel)
    {
        $request->validate([
            'name_product' => 'required|string',
            'name_recipient' => 'required|string',
            'address_shipper' => 'required|string',
            'name_shipper' => 'required|string',
            'address_recipient' => 'required|string'
        ]);

        $parcel->update($request->all());

        return redirect()->route('parcels.index')->with('success', 'Parcel updated successfully.');
    }

    public function destroy(Parcel $parcel)
    {
        $parcel->delete();
        return redirect()->route('parcels.index')->with('success', 'Parcel deleted successfully.');
    }
}
