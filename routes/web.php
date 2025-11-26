<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Resepsionis\DashboardController as ResepsionisDashboardController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Resepsionis\ResepsionisProfileController;
use App\Http\Controllers\Admin\TipeKamarController;
use App\Http\Controllers\Admin\RatePlanController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Resepsionis\CheckInOutController;
use App\Http\Controllers\Resepsionis\RoomController as ResepsionisRoomController;

// =================== Redirect root ke login ===================
Route::get('/', fn() => redirect()->route('login'));

// =================== Login Routes ===================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =================== Admin Routes ===================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'check.role:admin'])->group(function () {
    
    // Dashboard & Analytics
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
    Route::post('/finance/invoices', [FinanceController::class, 'storeInvoice'])->name('finance.invoices.store');
    Route::post('/finance/invoices/{invoice}/mark-paid', [FinanceController::class, 'markInvoicePaid'])
    ->name('finance.invoices.mark-paid');

    // Room Management
    Route::resource('rooms', RoomController::class);
    Route::get('/rooms/{id}/edit-data', [RoomController::class, 'editData'])->name('rooms.edit-data');

    // Rate Plans
    Route::get('/rate-plans', [RatePlanController::class, 'index'])->name('rate-plans.index');
    Route::get('/rate-plans/create', [RatePlanController::class, 'create'])->name('rate-plans.create');
    Route::post('/rate-plans', [RatePlanController::class, 'store'])->name('rate-plans.store');
    Route::get('/rate-plans/{ratePlan}/edit', [RatePlanController::class, 'edit'])->name('rate-plans.edit');
    Route::put('/rate-plans/{ratePlan}', [RatePlanController::class, 'update'])->name('rate-plans.update');
    Route::delete('/rate-plans/{ratePlan}', [RatePlanController::class, 'destroy'])->name('rate-plans.destroy');

    // Coupons
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');

    // Laporan Keuangan
    Route::prefix('laporan-keuangan')->name('laporan_keuangan.')->group(function() {
        Route::get('/', [LaporanKeuanganController::class, 'index'])->name('index');
        Route::get('/cetak', [LaporanKeuanganController::class, 'cetakPdf'])->name('cetak');
        Route::get('/export', [LaporanKeuanganController::class, 'exportExcel'])->name('export');
    });

    // Activity Logs
    Route::resource('activities', ActivityLogController::class)->only(['index', 'show']);
    
    // Guest Management
    Route::resource('guests', GuestController::class);
    
    // Booking Management
    Route::resource('bookings', BookingController::class);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/bookings/{id}/checkin', [BookingController::class, 'checkin'])->name('bookings.checkin');
    Route::patch('/bookings/{id}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::patch('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');

    // User Management
    Route::resource('users', UserController::class)->except('show');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/form', [UserController::class, 'create'])->name('users.form');

    // Payments
    Route::resource('payments', PaymentController::class);

    // Facilities
    Route::resource('facilities', FacilityController::class);

    // Tipe Kamar
    Route::prefix('tipe-kamar')->name('tipe_kamar.')->group(function() {
        Route::get('/', [TipeKamarController::class, 'index'])->name('index');   
        Route::get('/form/{id?}', [TipeKamarController::class, 'form'])->name('form');      
        Route::get('/edit/{id?}', [TipeKamarController::class, 'edit'])->name('edit'); 
        Route::get('/show/{id}', [TipeKamarController::class, 'show'])->name('show');  
        Route::post('/save', [TipeKamarController::class, 'save'])->name('save');
        Route::delete('/delete/{id}', [TipeKamarController::class, 'destroy'])->name('delete');
    });

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'show'])->name('show');
        Route::get('/edit', [AdminProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [AdminProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [AdminProfileController::class, 'showChangePasswordForm'])->name('change-password.show');
        Route::post('/change-password', [AdminProfileController::class, 'changePassword'])->name('change-password');
    });

        // Guest Management
    Route::resource('guests', GuestController::class);
    
    // TAMBAHKAN ROUTE INI UNTUK GUEST DETAILS
    Route::get('/guests/{id}/details', [GuestController::class, 'getGuestDetails'])->name('guests.details');
    Route::get('/guests/{id}/show', [GuestController::class, 'showDetails'])->name('guests.show');


});

// =================== Resepsionis Routes ===================
Route::prefix('resepsionis')->name('resepsionis.')->middleware(['auth', 'check.role:resepsionis'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [ResepsionisDashboardController::class, 'index'])->name('dashboard');

    // =================== CHECK IN/OUT ROUTES ===================
    Route::prefix('check-in-out')->name('checkinout.')->group(function () {
        Route::get('/', [CheckInOutController::class, 'index'])->name('index');
        Route::post('/check-in/{booking}', [CheckInOutController::class, 'checkIn'])->name('checkin');
        Route::post('/check-out/{booking}', [CheckInOutController::class, 'checkOut'])->name('checkout');
        Route::post('/walkin-checkin', [CheckInOutController::class, 'walkInCheckIn'])->name('walkin.checkin');
        Route::get('/available-rooms', [CheckInOutController::class, 'getAvailableRooms'])->name('available.rooms');
    });

    // =================== NEW ROOM MANAGEMENT ROUTES ===================
    Route::prefix('room')->name('room.')->group(function () {
        // Main room status page dengan layout baru
        Route::get('/', [ResepsionisRoomController::class, 'index'])->name('index');
        
        // Get room details untuk modal
        Route::get('/{id}', [ResepsionisRoomController::class, 'show'])->name('show');
        
        // Update room status
Route::put('/{id}/status', [ResepsionisRoomController::class, 'updateRoomStatus'])->name('update-status');
        
        // Filter rooms
        Route::get('/filter/{status?}', [ResepsionisRoomController::class, 'filter'])->name('filter');
    });

    // Legacy room routes (jika masih diperlukan)
    Route::resource('rooms', RoomController::class);
    Route::get('/rooms/{id}/edit-data', [RoomController::class, 'editData'])->name('rooms.edit-data');

    // Guest Management
    Route::resource('guests', GuestController::class);
    
    // Booking Management
    Route::resource('bookings', BookingController::class); 
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/bookings/{id}/checkin', [BookingController::class, 'checkin'])->name('bookings.checkin');
    Route::patch('/bookings/{id}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::patch('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');

    // Payments
    Route::resource('payments', PaymentController::class);

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ResepsionisProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ResepsionisProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ResepsionisProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ResepsionisProfileController::class, 'showChangePasswordForm'])->name('change-password.show');
        Route::match(['put', 'post'], '/change-password', [ResepsionisProfileController::class, 'changePassword'])->name('change-password');
    });

    // Additional Resepsionis Routes
// Jika Anda ingin /cico langsung menampilkan halaman index
Route::get('/cico', [App\Http\Controllers\Resepsionis\CheckInOutController::class, 'index'])->name('cico.index');
    // Legacy room status route (redirect ke yang baru)
    Route::get('/room-status', function () {
        return redirect()->route('resepsionis.room.index');
    })->name('rooms.status');

    Route::get('/invoices', function () {
        return view('resepsionis.invoices.index');
    })->name('invoices.index');

    Route::get('/notifications', function () {
        return view('resepsionis.notifications.index');
    })->name('notifications.index');

});

    // Guest Management
    Route::resource('guests', GuestController::class);
    
    // TAMBAHKAN ROUTE INI UNTUK GUEST DETAILS
    Route::get('/guests/{id}/details', [GuestController::class, 'getGuestDetails'])->name('guests.details');
    Route::get('/guests/{id}/show', [GuestController::class, 'showDetails'])->name('guests.show');


// =================== SHARED Routes (Admin & Resepsionis) ===================
Route::middleware(['auth', 'admin_resepsionis'])->group(function () {
    
    // Payments (Shared between admin and resepsionis)
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('payments', PaymentController::class);
    });
    
    Route::prefix('resepsionis')->name('resepsionis.')->group(function() {
        Route::resource('payments', PaymentController::class);
    });

    // Guest Features (Shared)
    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/guests/calendar', [GuestController::class, 'calendar'])->name('guests.calendar');
    Route::get('/guests/timeline', [GuestController::class, 'timeline'])->name('guests.timeline');

    // Booking Features (Shared)
    Route::get('/bookings/get-guests', [BookingController::class, 'getGuests'])->name('admin.bookings.get-guests');
    Route::get('/bookings/get-rooms', [BookingController::class, 'getRooms'])->name('admin.bookings.get-rooms');
    Route::get('/bookings/get-facilities', [BookingController::class, 'getFacilities'])->name('admin.bookings.get-facilities');
});