<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Resepsionis\DashboardController as ResepsionisDashboardController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Resepsionis\ResepsionisProfileController; 

// =================== Redirect root ke login ===================
Route::get('/', fn() => redirect()->route('login'));

// =================== Login Routes ===================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =================== Admin ===================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('laporan-keuangan')->name('laporan_keuangan.')->group(function() {
        Route::get('/', [LaporanKeuanganController::class, 'index'])->name('index');
        Route::get('/cetak', [LaporanKeuanganController::class, 'cetakPdf'])->name('cetak');
        Route::get('/export', [LaporanKeuanganController::class, 'exportExcel'])->name('export');
    });

    Route::resource('activities', ActivityLogController::class)->only(['index', 'show']);
    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('users', UserController::class)->except('show');
    Route::resource('payments', PaymentController::class);

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'show'])->name('show');
        Route::get('/edit', [AdminProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [AdminProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [AdminProfileController::class, 'showChangePasswordForm'])->name('change-password.show');
        Route::post('/change-password', [AdminProfileController::class, 'changePassword'])->name('change-password');
    });
});

// =================== Resepsionis ===================
Route::prefix('resepsionis')->name('resepsionis.')->middleware(['auth', 'check.role:resepsionis'])->group(function () {
    Route::get('/dashboard', [ResepsionisDashboardController::class, 'index'])->name('dashboard');
    Route::resource('rooms', RoomController::class)->except(['destroy']);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('payments', PaymentController::class);

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ResepsionisProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ResepsionisProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ResepsionisProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ResepsionisProfileController::class, 'showChangePasswordForm'])->name('change-password.show');
        Route::match(['put', 'post'], '/change-password', [ResepsionisProfileController::class, 'changePassword'])->name('change-password');
    });
});

// =================== SHARED (Admin & Resepsionis) ===================
Route::middleware(['auth', 'admin_resepsionis'])->group(function () {
    // Payment untuk Admin
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('payments', PaymentController::class);
    });
    
    // Payment untuk Resepsionis
    Route::prefix('resepsionis')->name('resepsionis.')->group(function() {
        Route::resource('payments', PaymentController::class);
    });
});