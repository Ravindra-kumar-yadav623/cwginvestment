<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;

class SponsorIncomeService
{
    /**
     * Distribute sponsor income up the upline chain.
     *
     * @param  \App\Models\User  $investor   The user who invested
     * @param  float             $amount     Invested amount (100$ etc.)
     * @param  string|null       $referenceNo Optional reference (e.g. TRF2025...)
     * @return void
     */
    public static function distribute(User $investor, float $amount, ?string $referenceNo = null): void
    {
        // Percent on each level (1st sponsor to 6th)
        $levels = [1.0, 0.6, 0.4, 0.3, 0.2, 0.1]; // in %

        $current = $investor;

        foreach ($levels as $levelIndex => $percent) {
            $sponsor = $current->sponsor;   // move to next sponsor

            if (!$sponsor) {
                break; // no more upline
            }

            $commissionAmount = round($amount * ($percent / 100), 8);
            if ($commissionAmount <= 0) {
                $current = $sponsor;
                continue;
            }

            // Commission wallet of sponsor
            $wallet = Wallet::where('user_id', $sponsor->id)
                ->where('type', 'commission')
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                $current = $sponsor;
                continue;
            }

            $before = $wallet->balance;
            $after  = $before + $commissionAmount;

            // Log in transactions table
            Transaction::create([
                'user_id'      => $sponsor->id,
                'wallet_id'    => $wallet->id,
                'tx_type'      => 'credit',
                'source_type'  => 'referral_bonus',
                'source_id'    => $investor->id, // who caused this income
                'amount'       => $commissionAmount,
                'balance_before' => $before,
                'balance_after'  => $after,
                'currency'     => 'USDT',
                'reference_no' => $referenceNo,
                'remark'       => sprintf(
                    'Sponsor income level %d from %s (%s)',
                    $levelIndex + 1,
                    $investor->name,
                    $investor->user_code
                ),
                'transaction_password_verified_at' => now(),
            ]);

            // Update wallet balance
            $wallet->balance = $after;
            $wallet->save();

            // Go one level up for next loop
            $current = $sponsor;
        }
    }
}