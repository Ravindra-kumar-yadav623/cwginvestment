<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // static for now; you can move to config or DB later
        $requestForOptions = [
            [
                'label'   => 'Robo',
                'address' => '0xC45fe40D6D63809B9d7F75D2FAf378a809B28045',
            ],
        ];

        $currencies = [
            'USDT.BEP20' => 'USDT BEP20',
        ];

        return view('admin.deposit', compact('user', 'requestForOptions', 'currencies'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'request_for'         => 'required|string',
            'request_wallet'      => 'required|string',
            'currency'            => 'required|string',
            'amount'              => 'required|numeric|min:1',
            'user_crypto_address' => 'required|string|max:255',
            'proof_image'         => 'required|image|mimes:jpeg,png,jpg,gif,pdf,webp|max:2048',
            'terms'               => 'accepted',
        ]);

        // upload image
        $path = $request->file('proof_image')->store('deposits', 'public');

        Deposit::create([
            'user_id'              => $user->id,
            'request_for'          => $request->request_for,
            'request_wallet_address'=> $request->request_wallet,
            'currency'             => $request->currency,
            'amount'               => $request->amount,
            'user_crypto_address'  => $request->user_crypto_address,
            'proof_image'          => $path,
            'status'               => 'pending',
        ]);

        return redirect()
            ->route('deposit.create')
            ->with('success', 'Your deposit request has been submitted and is pending approval.');
    }

    public function history()
    {
        $user = auth()->user();

        $deposits = Deposit::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('admin.deposit_history', compact('deposits'));
    }
}
