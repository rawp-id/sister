<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showUserRegistrationForm()
    {
        return view('users.auth.register'); // Create a Blade view for user registration
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|unique:users',
            'pin' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'pin' => Hash::make($request->pin),
        ]);

        return redirect()->route('beranda.index')->with('success', 'User registered successfully');
    }

    public function showPatnerRegistrationForm()
    {
        return view('users.auth.register_patner'); // Create a Blade view for partner registration
    }

    public function registerPatner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patners',
            'phone_number' => 'required|string|unique:patners',
            'pin' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $patner = Patner::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'pin' => Hash::make($request->pin),
        ]);

        return redirect()->route('beranda.index')->with('success', 'Patner registered successfully');
    }
}
