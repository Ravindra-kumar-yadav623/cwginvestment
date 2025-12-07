<?php

namespace App\Http\Controllers;

use App\Mail\WalletTransferSuccessMail;
use App\Models\Otp;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class WalletTransferController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $mainWallet = $user->wallets()
            ->where('type', 'main')
            ->first();

        return view('wallet.transfer', [
            'user'    => $user,
            'balance' => $mainWallet?->balance ?? 0,
        ]);
    }

    // Step 1: validate + send OTP, store draft transfer in session
    public function sendOtp(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'amount'               => 'required|numeric|min:1',
            'transaction_password' => 'required|string',
            'remarks'              => 'nullable|string|max:255',
        ]);

        // auto self transfer (logged-in user code)
        $toUser = $user;

        // check transaction password
        if (!Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password' => 'Invalid transaction password'])
                ->withInput();
        }

        // check balance in main wallet
        $mainWallet = Wallet::where('user_id', $user->id)
            ->where('type', 'main')
            ->first();

        if (!$mainWallet || $mainWallet->balance < $request->amount) {
            return back()
                ->withErrors(['amount' => 'Insufficient pocket wallet balance'])
                ->withInput();
        }

        // store pending transfer details in session
        session([
            'pending_wallet_transfer' => [
                'from_user_id'  => $user->id,
                'to_user_id'    => $toUser->id,
                'amount'        => $request->amount,
                'remarks'       => $request->remarks,
            ],
        ]);

        // create OTP
        $code = random_int(100000, 999999);

        Otp::create([
            'user_id'    => $user->id,
            'identifier' => $user->email,
            'type'       => 'wallet_transfer',
            'otp_code'   => $code,
            'attempts'   => 0,
            'expires_at' => now()->addMinutes(10),
        ]);

        // send mail
        Mail::to($user->email)->queue(new WalletTransferSuccessMail($code, false));

        return back()
            ->withInput()
            ->with('success', 'OTP sent to your email.')
            ->with('show_transfer_otp_modal', true);
    }

    // Step 2: verify OTP + actually move wallet balances + log transactions
    public function submit(Request $request)
    {
        $user = Auth::user();
        $pending = session('pending_wallet_transfer');

        if (!$pending || $pending['from_user_id'] !== $user->id) {
            return back()
                ->withErrors(['otp' => 'Transfer session expired. Please send OTP again.']);
        }

        $request->validate([
            'otp'   => 'required|string',
            'agree' => 'accepted',
        ], [
            'agree.accepted' => 'Please confirm the checkbox before submitting.',
        ]);

        // get latest OTP
        $otp = Otp::where('user_id', $user->id)
            ->where('identifier', $user->email)
            ->where('type', 'wallet_transfer')
            ->latest()
            ->first();

        if (
            !$otp ||
            $otp->otp_code !== $request->otp ||
            $otp->expires_at->isPast()
        ) {
            return back()
                ->withErrors(['otp' => 'Invalid or expired OTP.'])
                ->with('show_transfer_otp_modal', true)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $amount = $pending['amount'];

            $fromWallet = Wallet::where('user_id', $user->id)
                ->where('type', 'main')
                ->lockForUpdate()
                ->first();

            $toWallet = Wallet::where('user_id', $pending['to_user_id'])
                ->where('type', 'investment')
                ->lockForUpdate()
                ->first();

            if (!$fromWallet || !$toWallet) {
                throw new \Exception('Wallet not found');
            }

            if ($fromWallet->balance < $amount) {
                throw new \Exception('Insufficient balance');
            }

            $refNo = 'TRF' . now()->format('YmdHis') . $user->id;

            // debit from main
            $beforeMain = $fromWallet->balance;
            $afterMain  = $beforeMain - $amount;

            Transaction::create([
                'user_id'      => $user->id,
                'wallet_id'    => $fromWallet->id,
                'tx_type'      => 'debit',
                'source_type'  => 'investment',
                'source_id'    => null,
                'amount'       => $amount,
                'balance_before' => $beforeMain,
                'balance_after'  => $afterMain,
                'currency'     => 'USDT',
                'reference_no' => $refNo,
                'remark'       => 'Pocket → Investment transfer',
                'transaction_password_verified_at' => now(),
            ]);

            $fromWallet->balance = $afterMain;
            $fromWallet->save();

            // credit to investment
            $beforeInv = $toWallet->balance;
            $afterInv  = $beforeInv + $amount;

            Transaction::create([
                'user_id'      => $user->id,
                'wallet_id'    => $toWallet->id,
                'tx_type'      => 'credit',
                'source_type'  => 'investment',
                'source_id'    => null,
                'amount'       => $amount,
                'balance_before' => $beforeInv,
                'balance_after'  => $afterInv,
                'currency'     => 'USDT',
                'reference_no' => $refNo,
                'remark'       => 'Pocket → Investment transfer',
                'transaction_password_verified_at' => now(),
            ]);

            // consume OTP + clear session
            $otp->delete();
            $toWallet->save();
            session()->forget('pending_wallet_transfer');

            DB::commit();

            // send success email
            Mail::to($user->email)->queue(new WalletTransferSuccessMail($refNo, true, $amount));

            return redirect()
                ->route('wallet.transfer.history')
                ->with('success', 'Amount transferred to investment wallet successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Wallet transfer failed: ' . $e->getMessage());

            return back()
                ->withErrors(['general' => 'Something went wrong. Please try again.'])
                ->with('show_transfer_otp_modal', true);
        }
    }

    // Transfer history (show debits from Pocket → Investment)
    public function history()
    {
        $user = Auth::user();

        $mainWallet = Wallet::where('user_id', $user->id)
            ->where('type', 'main')
            ->first();

        $transactions = Transaction::with('wallet')
            ->where('user_id', $user->id)
            ->where('wallet_id', $mainWallet?->id)
            ->where('source_type', 'investment')
            ->where('tx_type', 'debit')
            ->latest()
            ->get();

        return view('wallet.transfer_history', [
            'transactions' => $transactions,
        ]);
    }

    public function userTransferForm()
    {
        $user = Auth::user();

        $incomeWallet = $user->wallets()->where('type', 'commission')->first(); // Income
        $pocketWallet = $user->wallets()->where('type', 'main')->first();       // Pocket

        return view('wallet.transfer_to_user', [
            'user'          => $user,
            'incomeBalance' => $incomeWallet?->balance ?? 0,
            'pocketBalance' => $pocketWallet?->balance ?? 0,
        ]);
    }

    // 2. Step 1: validate + send OTP + store pending transfer in session
    public function sendOtpUserTransfer(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'wallet_type'          => 'required|in:commission,main', // income / pocket
            'to_user_code'         => 'required|string|exists:users,user_code',
            'amount'               => 'required|numeric|min:1',
            'transaction_password' => 'required|string',
            'remarks'              => 'nullable|string|max:255',
        ]);

        if (!Hash::check($request->transaction_password, $user->transaction_password)) {
            return back()
                ->withErrors(['transaction_password' => 'Invalid transaction password'])
                ->withInput();
        }

        $targetUser = User::where('user_code', $request->to_user_code)->first();

        if (!$targetUser) {
            return back()
                ->withErrors(['to_user_code' => 'User not found.'])
                ->withInput();
        }

        if ($targetUser->id === $user->id) {
            return back()
                ->withErrors(['to_user_code' => 'You cannot transfer to yourself here.'])
                ->withInput();
        }

        // check balance in selected wallet
        $fromWallet = Wallet::where('user_id', $user->id)
            ->where('type', $request->wallet_type)
            ->first();

        if (!$fromWallet || $fromWallet->balance < $request->amount) {
            return back()
                ->withErrors(['amount' => 'Insufficient balance in selected wallet'])
                ->withInput();
        }

        // store pending transfer details
        session([
            'pending_user_transfer' => [
                'from_user_id'   => $user->id,
                'from_wallet'    => $request->wallet_type,
                'to_user_id'     => $targetUser->id,
                'to_wallet'      => 'main', // always credit into recipient Pocket wallet
                'amount'         => $request->amount,
                'remarks'        => $request->remarks,
            ],
        ]);

        // create OTP
        $code = random_int(100000, 999999);

        Otp::create([
            'user_id'    => $user->id,
            'identifier' => $user->email,
            'type'       => 'wallet_user_transfer',
            'otp_code'   => $code,
            'attempts'   => 0,
            'expires_at' => now()->addMinutes(10),
        ]);

        // send email with OTP
        Mail::to($user->email)->queue(new WalletTransferSuccessMail($code, false));

        return back()
            ->withInput()
            ->with('success', 'OTP sent to your email.')
            ->with('show_user_transfer_otp_modal', true);
    }

    // 3. Step 2: verify OTP + move balance + create transactions
    public function submitUserTransfer(Request $request)
    {
        $user    = Auth::user();
        $pending = session('pending_user_transfer');

        if (!$pending || $pending['from_user_id'] !== $user->id) {
            return back()
                ->withErrors(['otp' => 'Transfer session expired. Please send OTP again.']);
        }

        $request->validate([
            'otp'   => 'required|string',
            'agree' => 'accepted',
        ], [
            'agree.accepted' => 'Please confirm the checkbox before submitting.',
        ]);

        $otp = Otp::where('user_id', $user->id)
            ->where('identifier', $user->email)
            ->where('type', 'wallet_user_transfer')
            ->latest()
            ->first();

        if (
            !$otp ||
            $otp->otp_code !== $request->otp ||
            $otp->expires_at->isPast()
        ) {
            return back()
                ->withErrors(['otp' => 'Invalid or expired OTP.'])
                ->with('show_user_transfer_otp_modal', true)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $amount   = $pending['amount'];
            $remarks  = $pending['remarks'] ?? null;

            $fromWallet = Wallet::where('user_id', $pending['from_user_id'])
                ->where('type', $pending['from_wallet'])
                ->lockForUpdate()
                ->first();

            $toWallet = Wallet::where('user_id', $pending['to_user_id'])
                ->where('type', $pending['to_wallet'])
                ->lockForUpdate()
                ->first();

            if (!$fromWallet || !$toWallet) {
                throw new \Exception('Wallet not found');
            }

            if ($fromWallet->balance < $amount) {
                throw new \Exception('Insufficient balance');
            }

            $refNo = 'UTR' . now()->format('YmdHis') . $user->id;

            // debit sender
            $beforeFrom = $fromWallet->balance;
            $afterFrom  = $beforeFrom - $amount;

            Transaction::create([
                'user_id'      => $fromWallet->user_id,
                'wallet_id'    => $fromWallet->id,
                'tx_type'      => 'debit',
                'source_type'  => 'admin_adjustment', // using existing enum
                'source_id'    => null,
                'amount'       => $amount,
                'balance_before' => $beforeFrom,
                'balance_after'  => $afterFrom,
                'currency'     => 'USDT',
                'reference_no' => $refNo,
                'remark'       => $remarks ? 'Transfer to user: '.$remarks : 'Transfer to user',
                'transaction_password_verified_at' => now(),
            ]);

            $fromWallet->balance = $afterFrom;
            $fromWallet->save();

            // credit receiver
            $beforeTo = $toWallet->balance;
            $afterTo  = $beforeTo + $amount;

            Transaction::create([
                'user_id'      => $toWallet->user_id,
                'wallet_id'    => $toWallet->id,
                'tx_type'      => 'credit',
                'source_type'  => 'admin_adjustment',
                'source_id'    => null,
                'amount'       => $amount,
                'balance_before' => $beforeTo,
                'balance_after'  => $afterTo,
                'currency'     => 'USDT',
                'reference_no' => $refNo,
                'remark'       => 'Received from user '.$user->user_code,
                'transaction_password_verified_at' => now(),
            ]);

            // consume OTP & clear session
            $otp->delete();
            session()->forget('pending_user_transfer');

            DB::commit();

            // email success to sender
            Mail::to($user->email)->queue(new WalletTransferSuccessMail($refNo, true, $amount));

            return redirect()
                ->route('wallet.transfer.user.history')
                ->with('success', 'Funds transferred to user successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('User wallet transfer failed: '.$e->getMessage());

            return back()
                ->withErrors(['general' => 'Something went wrong. Please try again.'])
                ->with('show_user_transfer_otp_modal', true);
        }
    }

    // 4. Outgoing transfer history for this feature
    public function userTransferHistory()
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->where('source_type', 'admin_adjustment')
            ->where('tx_type', 'debit')
            ->latest()
            ->get();

        return view('wallet.transfer_to_user_history', compact('transactions'));
    }

    public function receivedTransferHistory()
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->where('source_type', 'admin_adjustment')
            ->where('tx_type', 'credit')
            ->latest()
            ->with(['wallet', 'user'])
            ->get();

        return view('wallet.received_funds_history', compact('transactions'));
    }
}
