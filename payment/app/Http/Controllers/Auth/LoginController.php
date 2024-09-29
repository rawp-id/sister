<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'pin');

        // Validate request
        $request->validate([
            'email' => 'required|string|email',
            'pin' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->pin, $user->pin)) {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }

        // Authenticate user and start session
        Auth::login($user);

        return redirect()->intended('/beranda'); // Redirect to intended or default page
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect to login page
    }
}
