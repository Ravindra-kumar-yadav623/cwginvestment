<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdminDepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('user')->latest()->get();
        return view('admin.deposits.index', compact('deposits'));
    }

    public function approve($id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit is already processed.');
        }

        // Update main wallet balance
        $wallet = Wallet::where('user_id', $deposit->user_id)
                    ->where('type', 'main')
                    ->first();

        if ($wallet) {
            $wallet->balance += $deposit->amount;
            $wallet->save();
        }

        // Update deposit status
        $deposit->update(['status' => 'approved']);

        return back()->with('success', 'Deposit approved & wallet balance updated.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_remark' => 'required'
        ]);

        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit is already processed.');
        }

        $deposit->update([
            'status'       => 'rejected',
            'admin_remark' => $request->admin_remark
        ]);

        return back()->with('success', 'Deposit rejected successfully.');
    }
}
