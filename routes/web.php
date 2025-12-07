<?php

use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController; 
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DepositController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', function () {
        return view('admin.index'); // your dashboard blade
    })->name('dashboard');

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
});