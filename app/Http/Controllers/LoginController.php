<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // show login page
    public function showLoginForm()
    {
        return view('frontend.login');
    }

    // handle login submit
    public function  login(Request $request)
    {
        // 1. Validate fields
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Prepare credentials array (we login using username column)
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember = $request->filled('remember'); // checkbox

        // 3. Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // prevent session fixation

            // optional: check user status (only allow active)
            // if (auth()->user()->status !== 'active') {
            //     Auth::logout();
            //     return back()->withErrors([
            //         'username' => 'Your account is not active. Please contact support.',
            //     ]);
            // }

            return redirect()->route('dashboard');
        }

        // 4. If login fails
        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->withInput([
            'username' => $request->username,
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
