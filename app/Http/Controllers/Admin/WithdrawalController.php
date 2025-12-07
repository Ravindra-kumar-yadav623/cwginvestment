<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;


class WithdrawalController extends Controller
{
    // List all withdrawals for admin
    public function index()
    {
        $withdrawals = Withdrawal::with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    // Approve withdrawal
   public function approve(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Only pending withdrawals can be approved.');
        }

        DB::beginTransaction();
        try {

            $user       = $withdrawal->user;
            $walletType = $withdrawal->payout_method ?? 'commission'; // adjust if needed
            $wallet     = Wallet::where('user_id', $user->id)
                                ->where('type', $walletType)
                                ->lockForUpdate()
                                ->first();

            if (!$wallet) {
                throw new \Exception('User wallet not found.');
            }

            $before = $wallet->balance;
            $amount = $withdrawal->amount;

            if ($before < $amount) {
                throw new \Exception('Insufficient balance in user wallet.');
            }

            // Deduct when approved
            $wallet->balance -= $amount;
            $wallet->save();

            Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'tx_type' => 'debit',
                'source_type' => 'withdrawal',
                'source_id' => $withdrawal->id,
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $wallet->balance,
                'currency' => $withdrawal->currency,
                'reference_no' => 'W' . time(),
                'remark' => 'Admin Approved Withdrawal',
            ]);

            $withdrawal->status = 'completed';
            $withdrawal->save();

            DB::commit();

            return back()->with('success', 'Withdrawal Approved Successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Only pending withdrawals can be rejected.');
        }

        $request->validate([
            'admin_remark' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            $user   = $withdrawal->user;
            $amount = $withdrawal->amount;

            // Refund wallet
            $walletType = $withdrawal->payout_method ?? 'commission';
            $wallet = Wallet::where('user_id', $user->id)
                            ->where('type', $walletType)
                            ->lockForUpdate()
                            ->first();

            if ($wallet) {
                $before = $wallet->balance;
                $wallet->balance += $amount;
                $wallet->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'wallet_id' => $wallet->id,
                    'tx_type' => 'credit',
                    'source_type' => 'withdrawal',
                    'source_id' => $withdrawal->id,
                    'amount' => $amount,
                    'balance_before' => $before,
                    'balance_after' => $wallet->balance,
                    'currency' => $withdrawal->currency,
                    'reference_no' => 'WRF' . time(),
                    'remark' => 'Rejected Withdrawal Refund',
                ]);
            }

            $withdrawal->status = 'rejected';
            $withdrawal->admin_remark = $request->admin_remark;
            $withdrawal->save();

            DB::commit();

            return back()->with('success', 'Withdrawal Rejected and Amount Refunded!');

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e);
            return back()->with('error', 'Something went wrong');
        }
    }
}
