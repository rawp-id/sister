<?php

namespace App\Http\Controllers;

use App\Models\Patner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatnerController extends Controller
{
    public function generateToken(Request $request)
    {
        $patner = Patner::findOrFail($request->patner_id);

        $token = $patner->createToken('API Token')->plainTextToken;

        $patner->update(['token' => $token]);

        return redirect()->with('success', 'Token generated successfully');
    }
}

