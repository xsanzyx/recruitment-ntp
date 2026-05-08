<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\HRJobVacancyController;
use App\Http\Controllers\HR\HRApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Route;


// =============================================
//  PUBLIC ROUTES
// =============================================
Route::get('/', function () {
    $vacancies = JobVacancy::where('status', 'open')->latest()->take(3)->get();
    return view('pages.guest.home', compact('vacancies'));
})->name('home');

Route::get('/lowongan', function () {
    $vacancies   = \App\Models\JobVacancy::where('status', 'open')->latest()->get();
    $departments = \App\Models\JobVacancy::where('status', 'open')->distinct()->pluck('department');
    $divisions   = \App\Models\JobVacancy::where('status', 'open')->distinct()->pluck('division');
    return view('pages.guest.lowongan', compact('vacancies', 'departments', 'divisions'));
})->name('lowongan');
Route::get('/proses-rekrutmen', fn() => view('pages.guest.proses-rekrutmen'))->name('proses-rekrutmen');
Route::get('/tentang',          fn() => view('pages.guest.tentang'))->name('tentang');
Route::get('/kontak',           fn() => view('pages.guest.kontak'))->name('kontak');
Route::post('/kontak',          [ContactController::class, 'send'])->name('kontak.send');

// =============================================
//  GUEST ROUTES (belum login)
// =============================================
Route::middleware('guest')->group(function () {
    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login'])->name('login.post');

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
});

// =============================================
//  AUTHENTICATED ROUTES
// =============================================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['kandidat'])->group(function () {
        Route::get('/lowongan/{id}/lamar',  [ApplicationController::class, 'create'])->name('apply.create');
        Route::post('/lowongan/{id}/lamar', [ApplicationController::class, 'store'])->name('apply.store');

        Route::get('/profile',  [ProfileController::class, 'show'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/resume',   [ProfileController::class, 'deleteResume'])->name('profile.deleteResume');
        Route::delete('/profile/document', [ProfileController::class, 'deleteDocument'])->name('profile.deleteDocument');
    });
});

// =============================================
//  HR ROUTES
// =============================================
Route::prefix('hr')->name('hr.')->middleware(['auth', 'hr'])->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');

    Route::resource('vacancies', HRJobVacancyController::class);
    Route::patch('vacancies/{id}/toggle-status', [HRJobVacancyController::class, 'toggleStatus'])
        ->name('vacancies.toggle');

    Route::get('applications',               [HRApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{id}',          [HRApplicationController::class, 'show'])->name('applications.show');
    Route::patch('applications/{id}/status', [HRApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::patch('applications/bulk-status', [HRApplicationController::class, 'bulkStatus'])->name('applications.bulkStatus');
    Route::get('applications/{id}/download/{type}/{docIndex?}', [HRApplicationController::class, 'downloadFile'])->name('applications.download');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])   // 'admin' = AdminMiddleware alias di Kernel.php
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen User
        Route::resource('users', UserManagementController::class);
    });
