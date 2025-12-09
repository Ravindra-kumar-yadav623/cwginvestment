<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Wallets
        $incomeWallet = $user->wallets()->where('type', 'commission')->value('balance') ?? 0;
        $pocketWallet = $user->wallets()->where('type', 'main')->value('balance') ?? 0;

        // Income and Withdrawals
        $totalIncome = \App\Models\Transaction::where('user_id', $user->id)
                        ->where('tx_type', 'credit')
                        ->sum('amount');

        $totalWithdrawal = \App\Models\Withdrawal::where('user_id', $user->id)
                            ->where('status', 'completed')
                            ->sum('amount');

        // Business / Network Details
        $directTeamCount = \App\Models\User::where('sponsor_id', $user->id)->count();
        $leftRightBusiness = [
            'left'  => rand(200, 1000), 
            'right' => rand(200, 1000)
        ];

        $referralLink = url('/register?ref='.$user->user_code);

        return view('admin.index', compact(
            'user',
            'incomeWallet',
            'pocketWallet',
            'totalIncome',
            'totalWithdrawal',
            'directTeamCount',
            'leftRightBusiness',
            'referralLink'
        ));
    }
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
            'otp'                  => 'required|string',
        ]);

        // Check OTP
        $otpResult = $this->verifyOtp($user, $request->otp, 'profile_update', 'otp');
        if (! $otpResult['ok']) {
            return back()
                ->withErrors($otpResult['error'])
                ->withInput()
                ->with('active_tab', 'profile');
        }

        // Save profile
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
            'otp_email'            => 'required|string',
        ]);

        // Check transaction password
        if (! Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password_email' => 'Invalid transaction password.'])
                ->withInput()
                ->with('active_tab', 'email');
        }

        // Check OTP (type email_update)
        $otpResult = $this->verifyOtp($user, $request->otp_email, 'email_update', 'otp_email');
        if (! $otpResult['ok']) {
            return back()
                ->withErrors($otpResult['error'])
                ->withInput()
                ->with('active_tab', 'email');
        }

        $user->email = $request->email;
        $user->save();

        return back()
            ->with('success_email', 'Email updated successfully.')
            ->with('active_tab', 'email');
    }

    public function sendProfileOtp(Request $request)
    {
        
        $user = auth()->user();

        $request->validate([
            'name'                 => 'required|string|max:255',
            'country'              => 'required|string|max:100',
            'mobile'               => 'required|string|max:20|unique:users,mobile,' . $user->id,
            'transaction_password' => 'required|string',
        ]);

        if (!Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password' => 'Invalid transaction password'])
                ->withInput()
                ->with('active_tab', 'profile');
        }

        // Check cooldown
        $check = $this->canSendOtp($user, 'profile_update');
        if (! $check['ok']) {
            return back()
                ->with('active_tab', 'profile')
                ->withErrors(['otp' => $check['error']]);
        }

        // Generate OTP
        $code = random_int(100000, 999999);

        Otp::create([
            'user_id'    => $user->id,
            'identifier' => $user->email,
            'type'       => 'profile_update',
            'otp_code'   => $code,
            'attempts'   => 0,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send email queued
        Mail::to($user->email)->queue(new OtpMail($code));

        return back()
            ->withInput()
            ->with('active_tab', 'profile')
            ->with('success_profile', 'OTP sent to your email.')
            ->with('show_otp_modal', true); // trigger modal

    }

    public function sendEmailOtp(Request $request)
    {
        $user = auth()->user();

        $check = $this->canSendOtp($user, 'email_update');
        if (! $check['ok']) {
            return back()
                ->with('active_tab', 'email')
                ->withErrors(['otp_email' => $check['error']]);
        }

        $code = random_int(100000, 999999);

        Otp::create([
            'user_id'    => $user->id,
            'identifier' => $user->email, // send to current email
            'type'       => 'email_update',
            'otp_code'   => $code,
            'attempts'   => 0,
            'expires_at' => now()->addMinutes(10),
        ]);

   Mail::to($user->email)->queue(new OtpMail($code));

        return back()
            ->with('active_tab', 'email')
            ->with('success_email', 'OTP sent! Please check your email.');
    }

    protected function verifyOtp($user, string $code, string $type, string $errorKey = 'otp')
    {
        $otp = Otp::where('user_id', $user->id)
            ->where('type', $type)
            ->whereNull('used_at')
            ->where('expires_at', '>=', now())
            ->latest()
            ->first();

        if (! $otp || $otp->otp_code !== $code) {
            if ($otp) {
                $otp->increment('attempts');
            }

            return [
                'ok'    => false,
                'error' => [$errorKey => 'Invalid or expired OTP.'],
            ];
        }

        // Mark used
        $otp->used_at = now();
        $otp->save();

        return ['ok' => true];
    }

    protected function canSendOtp($user, string $type)
    {
        $lastOtp = Otp::where('user_id', $user->id)
            ->where('type', $type)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < 60) {
            $wait = 60 - $lastOtp->created_at->diffInSeconds(now());
            return [
                'ok'    => false,
                'error' => "Please wait $wait seconds before requesting another OTP."
            ];
        }

        return ['ok' => true];
    }

}
