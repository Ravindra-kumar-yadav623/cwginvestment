<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
   public function edit()
    {
        $user = auth()->user();

        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'                 => 'required|string|max:255',
            'country'              => 'required|string|max:100',
            'mobile'               => 'required|string|max:20|unique:users,mobile,' . $user->id,
            'transaction_password' => 'required|string',
        ]);

        if (! Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password' => 'Invalid transaction password.'])
                ->withInput()
                ->with('active_tab', 'profile');
        }

        $user->name    = $request->name;
        $user->country = $request->country;
        $user->mobile  = $request->mobile;
        $user->save();

        return back()
            ->with('success_profile', 'Profile updated successfully.')
            ->with('active_tab', 'profile');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->with('active_tab', 'settings');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()
            ->with('success_password', 'Login password updated successfully.')
            ->with('active_tab', 'settings');
    }

    public function updateEmail(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email'                => 'required|email|max:255|unique:users,email,' . $user->id,
            'transaction_password' => 'required|string',
        ]);

        if (! Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password_email' => 'Invalid transaction password.'])
                ->withInput()
                ->with('active_tab', 'email');
        }

        $user->email = $request->email;
        $user->save();

        return back()
            ->with('success_email', 'Email updated successfully.')
            ->with('active_tab', 'email');
    }
}
