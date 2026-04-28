<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\HRJobVacancyController;
use App\Http\Controllers\HR\HRApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('pages.guest.home'))->name('home');

// =============================================
//  GUEST ROUTES (belum login)
// =============================================
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // OTP (tidak perlu auth, user belum verified)
    Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

});

// =============================================
//  AUTHENTICATED ROUTES (sudah login & verified)
// =============================================
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

// =============================================
//  HR ROUTES (role: hr / admin)
// =============================================
Route::prefix('hr')->name('hr.')->middleware(['auth', 'hr'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');

    // Lowongan (CRUD)
    Route::resource('vacancies', HRJobVacancyController::class);
    Route::patch('vacancies/{id}/toggle-status', [HRJobVacancyController::class, 'toggleStatus'])
        ->name('vacancies.toggle');

    // Kandidat / Lamaran
    Route::get('applications', [HRApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{id}', [HRApplicationController::class, 'show'])->name('applications.show');
    Route::patch('applications/{id}/status', [HRApplicationController::class, 'updateStatus'])
        ->name('applications.updateStatus');
    Route::patch('applications/bulk-status', [HRApplicationController::class, 'bulkStatus'])
        ->name('applications.bulkStatus');

});