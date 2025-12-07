<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Otp;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        $incomeWallet = Wallet::where('user_id', $user->id)
            ->where('type', 'commission')
            ->value('balance') ?? 0;

        $investmentWallet = Wallet::where('user_id', $user->id)
            ->where('type', 'investment')
            ->value('balance') ?? 0;

        // $incomeWallet = $user->wallets()->where('type', 'commission')->first();
        // $investmentWallet = $user->wallets()->where('type', 'investment')->first();

        return view('wallet.withdrawal', compact('user', 'incomeWallet', 'investmentWallet'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'amount'               => 'required|numeric|min:10',
            'wallet_type'          => 'required|in:commission,investment',
            'transaction_password' => 'required|string',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password' => 'Invalid Transaction Password'])
                ->withInput();
        }

        $wallet = $user->wallets()->where('type', $request->wallet_type)->first();

        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance!');
        }

        session([
            'withdraw_data' => [
                'amount'                           => $request->amount,
                'withdraw_from'                    => $request->wallet_type, // <- from wallet_type
                'transaction_password_verified_at' => now(),
            ]
        ]);

        $recentOtp = Otp::where('user_id', $user->id)
            ->where('type', 'withdraw')
            ->where('expires_at', '>', now())
            ->first();

        if ($recentOtp) {
            return back()
                ->with('error', 'OTP already sent! Wait before requesting again.')
                ->withInput();
        }

        $otpCode = rand(100000, 999999);

        Otp::create([
            'user_id'    => $user->id,
            'type'       => 'withdraw',
            'identifier' => $user->email,
            'otp_code'   => $otpCode,
            'attempts'   => 0,
            'expires_at' => now()->addMinutes(5),
        ]);

        \Mail::raw("Your CWG withdrawal OTP is: $otpCode", function ($msg) use ($user) {
            $msg->to($user->email)->subject('Withdrawal OTP');
        });

        return back()
            ->with('success', 'OTP sent to your email!')
            ->with('show_otp_modal', true)
            ->withInput();
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = auth()->user();
        $otp = Otp::where('user_id', $user->id)
                  ->where('type', 'withdraw')
                  ->where('expires_at', '>', now())
                  ->latest()
                  ->first();

        if (!$otp || $otp->otp_code != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP'])
                         ->with('show_otp_modal', true);
        }

        $data = session('withdraw_data');

        if (!$data) {
            return back()->with('error', 'Session expired! Try again.');
        }

        DB::beginTransaction();

        try {
            $wallet = $user->wallets()->where('type', $data['withdraw_from'])->first();

            if ($wallet->balance < $data['amount']) {
                return back()->with('error', 'Insufficient balance!');
            }

            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $data['amount'],
                'currency' => 'USDT',
                'payout_method' => $data['withdraw_from'],
                'payout_details' => [
                    'wallet_address' => $user->crypto_address ?? 'Not set',
                ],
                'status' => 'pending',
                'transaction_password_verified_at' => now(),
            ]);

            // Reduce from selected wallet
            $before = $wallet->balance;
            $wallet->balance -= $data['amount'];
            $wallet->save();

            // Add Transaction
            $user->transactions()->create([
                'wallet_id' => $wallet->id,
                'tx_type' => 'debit',
                'source_type' => 'withdrawal',
                'source_id' => $withdrawal->id,
                'amount' => $data['amount'],
                'balance_before' => $before,
                'balance_after' => $wallet->balance,
                'currency' => 'USDT',
                'remark' => 'Withdrawal Request Submitted',
            ]);

            DB::commit();
            session()->forget('withdraw_data');
            $otp->delete();

            return redirect()->route('withdrawal.history')->with('success', 'Withdrawal request submitted!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error submitting request!');
        }
    }

    public function history()
    {
        $withdrawals = Withdrawal::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wallet.withdrawal_history', compact('withdrawals'));
    }
}
