<?php

use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
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
});