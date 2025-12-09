<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNetwork;
use App\Models\Wallet;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('frontend.register');
    }

    public function register(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'mobile'                => 'required|string|max:20|unique:users,mobile',
            'country'               => 'required|string|max:100',
            'username'              => 'required|string|max:50|alpha_num|unique:users,username',

            'password'              => 'required|string|min:6|confirmed',
            'transaction_password'  => 'required|string|min:4|confirmed',

            'sponsor_code'          => 'required|string|exists:users,user_code',
            'position'              => 'required|in:left,right',
            'mt5_account_no'        => 'nullable|string|max:100|unique:users,mt5_account_no',
        ], [
            'sponsor_code.exists'   => 'Sponsor code not found.',
        ]);

        

       DB::beginTransaction();

        try {
            // 2. Find sponsor if given
            $sponsor = null;
            if ($request->filled('sponsor_code')) {
                $sponsor = User::where('user_code', $request->sponsor_code)->first();
            }

            // 3. Create user
            $user = new User();
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->mobile       = $request->mobile;
            $user->country      = $request->country;
            $user->username     = $request->username;

            // password & transaction password will be hashed by mutators (if you used them)
            $user->password                 = $request->password;
            $user->transaction_password     = $request->transaction_password;
            $user->transaction_password_set_at = now();

            $user->sponsor_id   = $sponsor ? $sponsor->id : null;
            $user->position     = $request->position; // optional, we also store detailed network in UserNetwork

            $user->mt5_account_no = $request->mt5_account_no;

            $user->kyc_status   = 'pending';
            $user->status       = 'inactive'; // you can change to 'active' after email/OTP verification etc.

            // TEMP user_code, will update after save
            $user->user_code = 'TEMP';

            $user->save();

            // 4. Generate unique user_code (e.g. CWG000001)
            $user->user_code = $this->generateUserCode($user->id);
            $user->save();

            // 5. Create UserNetwork row (binary placement)
            UserNetwork::create([
                'user_id'    => $user->id,
                'sponsor_id' => $sponsor?->id,
                // In simple case, upline = sponsor. You can add your own placement logic here
                'upline_id'  => $sponsor?->id,
                'position'   => $request->position, // left/right
                'level'      => 0, // you can calculate actual level later
            ]);

            // 6. Attach role "user" (make sure it's created in roles table)
            $role = Role::where('slug', 'user')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }

            // 7. Create default wallets for this user
            $walletTypes = ['main', 'investment', 'commission', 'roi', 'bonus'];

            foreach ($walletTypes as $type) {
                Wallet::create([
                    'user_id' => $user->id,
                    'type'    => $type,
                    'balance' => 0,
                ]);
            }

            DB::commit();

            // 8. Login the user directly or redirect with success message
            // auth()->login($user);

            return redirect()->route('login') // change to dashboard if needed
                ->with('success', 'Registration successful! Please login.');
        } catch (\Throwable $e) {
            DB::rollBack();
            // You can log error here:
             \Log::error($e->getMessage());
            return back()->withInput()->withErrors([
                'general' => 'Something went wrong. Please try again.',
            ]);
        }
    }

    /**
     * Generate a unique user code like CWG000001
     */
    protected function generateUserCode($id)
    {
        // You can also use random string etc., this is simple & readable
        return 'CWG' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}