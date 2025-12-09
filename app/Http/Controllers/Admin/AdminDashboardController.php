<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // 🔹 Deposits
        $totalDepositAmount = Deposit::where('status', 'approved')->sum('amount');
        $pendingDepositAmount = Deposit::where('status', 'pending')->sum('amount');
        $pendingDepositCount  = Deposit::where('status', 'pending')->count();

        // 🔹 Withdrawals
        $totalWithdrawalAmount = Withdrawal::where('status', 'completed')->sum('amount');
        $pendingWithdrawalAmount = Withdrawal::where('status', 'pending')->sum('amount');
        $pendingWithdrawalCount  = Withdrawal::where('status', 'pending')->count();

        // 🔹 Today income (all credit transactions today)
        $todayIncome = Transaction::where('tx_type', 'credit')
            ->whereDate('created_at', $today)
            ->sum('amount');

        // 🔹 Total revenue (all credit transactions)
        $totalRevenue = Transaction::where('tx_type', 'credit')->sum('amount');

        // 🔹 Users
        $totalUsers = User::count();
        $newUsersToday = User::whereDate('created_at', $today)->count();
        $activeUsers = User::where('status', 'active')->count();

        // 🔹 Business misc
        $totalDepositsCount = Deposit::count();
        $totalSponsorIncome = Transaction::where('source_type', 'referral_bonus')->sum('amount');
        $rejectedCount = Deposit::where('status', 'rejected')->count()
            + Withdrawal::where('status', 'rejected')->count();

        return view('admin.admin_dashboard', compact(
            'totalDepositAmount',
            'pendingDepositAmount',
            'pendingDepositCount',
            'totalWithdrawalAmount',
            'pendingWithdrawalAmount',
            'pendingWithdrawalCount',
            'todayIncome',
            'totalRevenue',
            'totalUsers',
            'newUsersToday',
            'activeUsers',
            'totalDepositsCount',
            'totalSponsorIncome',
            'rejectedCount'
        ));
    }

    public function userList(Request $request)
    {
        $query = User::query()
            ->with(['sponsor', 'roles']);

        // ---- FILTER: status ----
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // ---- FILTER: role ----
        if ($roleSlug = $request->get('role')) {
            $query->whereHas('roles', function ($q) use ($roleSlug) {
                $q->where('slug', $roleSlug);
            });
        }

        // ---- FILTER: country ----
        if ($country = $request->get('country')) {
            $query->where('country', $country);
        }

        // ---- FILTER: search (name / user_code / username / email / mobile) ----
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('user_code', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // ---- FILTER: date range (registered at) ----
        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Order newest first
        $query->orderByDesc('created_at');

        // Pagination
        $users = $query->paginate(25)->appends($request->query());

        // For filter dropdowns
        $roles = Role::orderBy('name')->get();
        $countries = config('countries', []); // from config/countries.php

        // Some quick stats for header (optional)
        $totalUsers   = User::count();
        $activeUsers  = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();

        return view('admin.users.index', compact(
            'users',
            'roles',
            'countries',
            'totalUsers',
            'activeUsers',
            'inactiveUsers'
        ));
    }
}