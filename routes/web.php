<?php

use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController; 
use App\Http\Controllers\LoginController;
use App\Http\Controllers\{DepositController, WalletTransferController, WithdrawalController, TeamController};
use App\Http\Controllers\Admin\AdminDepositController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;

// Route::get('/', function () {
//     return view('frontend/layout');
// });

// Route::get('/',[HomeController::class,'index']);
Route::get('/',[HomeController::class,'frontend']);
Route::get('/about',[HomeController::class, 'about']);
Route::get('/shop',[HomeController::class, 'shop']);
Route::get('/faq',[HomeController::class, 'faq']);
Route::get('/contact',[HomeController::class, 'contact']);

// ---------- Guest (not logged in) ----------
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// ---------- Authenticated (logged in) ----------
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update basic profile (name, country, mobile) – require transaction password
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    // Change login password
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Change email – require transaction password
    Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');

    // OTP routes
    Route::post('/profile/otp/profile', [ProfileController::class, 'sendProfileOtp'])->name('profile.otp.profile');
    Route::post('/profile/otp/email', [ProfileController::class, 'sendEmailOtp'])->name('profile.otp.email');

    Route::get('/deposit', [DepositController::class, 'create'])->name('deposit.create');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');
    Route::get('/deposit/history', [DepositController::class, 'history'])->name('deposit.history');

     // Show transfer form page
    Route::get('/wallet/transfer', [WalletTransferController::class, 'index'])
        ->name('wallet.transfer');

    Route::post('/wallet/transfer/send-otp', [WalletTransferController::class, 'sendOtp'])
        ->name('wallet.transfer.sendOtp');

    Route::post('/wallet/transfer/submit', [WalletTransferController::class, 'submit'])
        ->name('wallet.transfer.submit');

    // Transfer history
    Route::get('/wallet/transfer/history', [WalletTransferController::class, 'history'])
        ->name('wallet.transfer.history');

    // NEW: transfer funds to another user
    Route::get('/wallet/transfer-funds', [WalletTransferController::class, 'userTransferForm'])
        ->name('wallet.transfer.user');

    Route::post('/wallet/transfer-funds/send-otp', [WalletTransferController::class, 'sendOtpUserTransfer'])
        ->name('wallet.transfer.user.sendOtp');

    Route::post('/wallet/transfer-funds/submit', [WalletTransferController::class, 'submitUserTransfer'])
        ->name('wallet.transfer.user.submit');

    Route::get('/wallet/transfer-funds/history', [WalletTransferController::class, 'userTransferHistory'])
        ->name('wallet.transfer.user.history');

    Route::get('/wallet/received-funds/history', [WalletTransferController::class, 'receivedTransferHistory'])
        ->name('wallet.transfer.received.history');

    Route::get('/withdrawal', [WithdrawalController::class, 'create'])->name('withdrawal');
    Route::post('/withdrawal/send-otp', [WithdrawalController::class, 'sendOtp'])->name('withdrawal.sendOtp');
    Route::post('/withdrawal/submit', [WithdrawalController::class, 'store'])->name('withdrawal.submit');

    Route::get('/withdrawal-history', [WithdrawalController::class, 'history'])
        ->name('withdrawal.history');

    Route::get('/team/direct', [TeamController::class, 'direct'])->name('team.direct');
    Route::get('/team/all',    [TeamController::class, 'all'])->name('team.all');
    Route::get('/team/business-history', [TeamController::class, 'businessHistory'])->name('team.business_history');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.admin_dashboard');
    })->name('admin.dashboard');

    // Deposit Approval Panel
    Route::get('/admin/deposits', [AdminDepositController::class, 'index'])->name('admin.deposits');
    Route::post('/admin/deposits/approve/{id}', [AdminDepositController::class, 'approve'])->name('admin.deposits.approve');
    Route::post('/admin/deposits/reject/{id}', [AdminDepositController::class, 'reject'])->name('admin.deposits.reject');
});

Route::prefix('admin')
    ->middleware(['auth', 'admin']) // add your admin middleware here e.g. 'admin'
    ->group(function () {

        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])
            ->name('admin.withdrawals.index');

        Route::post('/withdrawals/approve/{withdrawal}', [AdminWithdrawalController::class, 'approve'])
            ->name('admin.withdrawals.approve');

        Route::post('/withdrawals/reject/{withdrawal}', [AdminWithdrawalController::class, 'reject'])
            ->name('admin.withdrawals.reject');
});