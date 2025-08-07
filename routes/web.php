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
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\ActivityLogController; // Tambahkan ini

// =================== Redirect root ke login ===================
Route::get('/', fn() => redirect()->route('login'));

// =================== Login Routes ===================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =================== Admin ===================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan_keuangan.index');
    
    // Tambahkan route untuk activity log
    Route::get('/activities', [ActivityLogController::class, 'index'])->name('activities.index');
    
    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('users', UserController::class)->except('show');
});

// =================== Resepsionis ===================
Route::prefix('resepsionis')->name('resepsionis.')->middleware(['auth', 'check.role:resepsionis'])->group(function () {
    Route::get('/dashboard', [ResepsionisDashboardController::class, 'index'])->name('dashboard');

    Route::resource('rooms', RoomController::class)->except(['destroy']);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('payments', PaymentController::class);
});

// =================== SHARED (Admin & Resepsionis) ===================
Route::middleware(['auth', 'check.role:admin,resepsionis'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

Route::get('/admin/laporan-keuangan/cetak', [LaporanKeuanganController::class, 'cetak'])
     ->name('admin.laporan_keuangan.cetak');