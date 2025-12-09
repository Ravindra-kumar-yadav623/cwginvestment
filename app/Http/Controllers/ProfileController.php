<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\{Wallet, Transaction, Withdrawal, User, UserNetwork};

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Wallet balances
        $incomeWallet  = Wallet::where('user_id', $user->id)
            ->where('type', 'commission')   // Income wallet
            ->value('balance') ?? 0;

        $pocketWallet  = Wallet::where('user_id', $user->id)
            ->where('type', 'main')         // Pocket/Main wallet
            ->value('balance') ?? 0;

        // 🔹 CWG Investment = Investment wallet balance
        $cwgInvestment = Wallet::where('user_id', $user->id)
            ->where('type', 'investment')
            ->value('balance') ?? 0;

        // Total income (all credits)
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('tx_type', 'credit')
            ->sum('amount');

        // Total completed withdrawals
        $totalWithdrawal = Withdrawal::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        // Direct team count
        $directTeamCount = User::where('sponsor_id', $user->id)->count();

        // 🔹 Left/Right business = sum of investment wallet balances of downline
        $leftUserIds = UserNetwork::where('upline_id', $user->id)
            ->where('position', 'left')
            ->pluck('user_id');

        $rightUserIds = UserNetwork::where('upline_id', $user->id)
            ->where('position', 'right')
            ->pluck('user_id');

        $leftBusiness = Wallet::whereIn('user_id', $leftUserIds)
            ->where('type', 'investment')
            ->sum('balance');

        $rightBusiness = Wallet::whereIn('user_id', $rightUserIds)
            ->where('type', 'investment')
            ->sum('balance');

        // Matching business = both sides matched volume
        $matchingBusiness = min($leftBusiness, $rightBusiness);

        // Rank rules (you can tweak amounts as needed)
        $rankRules = [
            ['name' => 'Royal Star',        'threshold' => 1000000],
            ['name' => 'Blue Star',         'threshold' => 900000],
            ['name' => 'Super Diamond Star','threshold' => 50000],
            ['name' => 'Diamond Star',      'threshold' => 20000],
            ['name' => 'Super Golden Star', 'threshold' => 15000],
            ['name' => 'Golden Star',       'threshold' => 10000],
            ['name' => 'Silver Star',       'threshold' => 5000],
        ];

        $currentRank = null;

        foreach ($rankRules as $rule) {
            if ($matchingBusiness >= $rule['threshold']) {
                $currentRank = $rule['name'];
                break; // take highest rank first (because array is sorted desc)
            }
        }

        // Refer & Earn stats (last 6 months direct signups)
        $startDate = now()->subMonths(5)->startOfMonth();

        $referralStats = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as total')
            ->where('sponsor_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        $referChartLabels = [];
        $referChartCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $dt    = now()->subMonths($i);
            $ym    = $dt->format('Y-m');
            $label = $dt->format('M Y');

            $row = $referralStats->firstWhere('ym', $ym);

            $referChartLabels[] = $label;
            $referChartCounts[] = $row ? $row->total : 0;
        }

        // Network tree – immediate downline under this user
        $leftDownline = UserNetwork::with('user')
            ->where('upline_id', $user->id)
            ->where('position', 'left')
            ->orderBy('level')
            ->limit(5)
            ->get();

        $rightDownline = UserNetwork::with('user')
            ->where('upline_id', $user->id)
            ->where('position', 'right')
            ->orderBy('level')
            ->limit(5)
            ->get();

        // Referral link
        $referralLink = url('/register?ref='.$user->user_code);

        return view('admin.index', compact(
            'user',
            'incomeWallet',
            'pocketWallet',
            'cwgInvestment',
            'totalIncome',
            'totalWithdrawal',
            'directTeamCount',
            'leftBusiness',
            'rightBusiness',
            'referChartLabels',
            'referChartCounts',
            'leftDownline',
            'rightDownline',
            'referralLink',
            'currentRank',    
            'matchingBusiness'
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
