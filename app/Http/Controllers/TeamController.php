<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserNetwork;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    // DIRECT TEAM (sponsor_id = me)
    public function direct(Request $request)
    {
        $user = Auth::user();

        $query = User::where('sponsor_id', $user->id);

        // Filters
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('user_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($from = $request->get('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $directTeam = $query->orderByDesc('created_at')
            ->paginate(20)
            ->appends($request->query());

        return view('team.direct', compact('user', 'directTeam'));
    }

    // ALL TEAM (binary downline under me; immediate downline in UserNetwork)
    public function all(Request $request)
    {
        $user = Auth::user();

        $query = UserNetwork::with('user')
            ->where('upline_id', $user->id);

        // Filters
        if ($position = $request->get('position')) {
            $query->where('position', $position); // left/right
        }

        if ($level = $request->get('level')) {
            $query->where('level', $level);
        }

        if ($status = $request->get('status')) {
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        if ($search = $request->get('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('user_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $downline = $query->orderBy('level')
            ->paginate(50)
            ->appends($request->query());

        return view('team.all', compact('user', 'downline'));
    }

    // BUSINESS HISTORY (Sponsor Income) – we already wrote this earlier,
    // leaving as-is, you can keep your existing implementation.
    public function businessHistory(Request $request)
    {
        $user = Auth::user();

        $query = Transaction::with('fromUser')
            ->where('user_id', $user->id)
            ->where('source_type', 'referral_bonus');

        // Optional filters
        if ($from = $request->get('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($min = $request->get('min_amount')) {
            $query->where('amount', '>=', $min);
        }

        if ($max = $request->get('max_amount')) {
            $query->where('amount', '<=', $max);
        }

        if ($search = $request->get('search')) {
            $query->whereHas('fromUser', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('user_code', 'like', "%{$search}%");
            });
        }

        $query->orderByDesc('created_at');

        $sponsorIncomes      = $query->paginate(50)->appends($request->query());
        $totalSponsorIncome  = (clone $query)->sum('amount');

        return view('team.business-history', compact(
            'user',
            'sponsorIncomes',
            'totalSponsorIncome'
        ));
    }
}
