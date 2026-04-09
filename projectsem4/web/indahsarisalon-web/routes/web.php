<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController; 
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\CategoryController;

// ------------------------------
// Home & Landing
// ------------------------------
Route::get('/home', fn() => view('home'));

// ------------------------------
// Form login & register
// ------------------------------
Route::get('/auth', fn() => view('auth'))->name('auth');
Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register.process');

// Alternatif URL login/register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ------------------------------
// Reset Password / OTP
// ------------------------------
Route::get('/reset-password', fn() => view('otp'))->name('reset.password');
Route::post('/reset-password', [PasswordResetController::class, 'sendOtp'])->name('reset.password.email');
Route::get('/reset-password/otp', fn(Request $request) => view('otp', ['email' => $request->email]))
    ->name('reset.password.otp');
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/new-password', fn(Request $request) => view('new-password', [
    'email' => $request->email,
    'otp' => $request->otp
]))->name('reset.password.form');
Route::post('/reset-password/otp', [PasswordResetController::class, 'resetPassword'])
    ->name('reset.password.update');

// ------------------------------
// Routes yang membutuhkan auth + session timeout
// ------------------------------
Route::middleware(['auth', 'session.timeout'])->group(function () {
    // ------------------------------
    // Profile
    // ------------------------------
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('update-info');
        Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('/avatar-update', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::post('/otp-send', [App\Http\Controllers\ProfileController::class, 'sendOtp'])->name('otp.send');
        Route::post('/otp-verify', [App\Http\Controllers\ProfileController::class, 'verifyAndReset'])->name('otp.verify');
    });
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

    // ------------------------------
    // Dashboard
    // ------------------------------
    Route::get('/dashboard', fn() => view('dashboard.homepage'))->name('dashboard');
    Route::get('/dashboard/user', fn() => view('dashboard.homepage-user'))->name('dashboard.user');

    // ------------------------------
    // Produk / Pelanggan
    // ------------------------------
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('index');
        Route::get('/create', [PelangganController::class, 'create'])->name('create');
        Route::post('/', [PelangganController::class, 'store'])->name('store');
        Route::get('/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('edit');
        Route::put('/{pelanggan}', [PelangganController::class, 'update'])->name('update');
        Route::delete('/{pelanggan}', [PelangganController::class, 'destroy'])->name('destroy');
        Route::get('/{pelanggan}', [PelangganController::class, 'show'])->name('show');
    });

    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::resource('categories', CategoryController::class);

    // ------------------------------
    // Halaman About
    // ------------------------------
    Route::get('/about', [PageController::class, 'about'])->name('about');

    // ------------------------------
    // Karyawan
    // ------------------------------
    Route::resource('karyawan', KaryawanController::class);
    Route::get('/karyawan/{id}/absensi', [KaryawanController::class, 'absensi'])->name('karyawan.absensi');

    // ------------------------------
    // Absensi Kasir
    // ------------------------------
    Route::prefix('absensi')->middleware('role:karyawan')->group(function () {
        Route::post('/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
        Route::post('/keluar', [AbsensiController::class, 'keluar'])->name('absensi.keluar');
        Route::post('/absen/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
        Route::post('/absen/keluar', [AbsensiController::class, 'absenKeluar'])->name('absensi.keluar');
    });

    // ------------------------------
    // Admin only
    // ------------------------------
    Route::middleware('role:admin')->group(function () {
        // Treatment
        Route::get('treatment/filter', [TreatmentController::class, 'filter'])->name('treatment.filter');
        Route::get('/treatment/filter-debug', [TreatmentController::class, 'filter'])->name('treatment.filter.debug');
        Route::resource('treatment', TreatmentController::class);

        // Pelanggan
        Route::resource('pelanggan', PelangganController::class);

        // Booking Admin Management
        Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
        Route::patch('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
    });
    
    //Booking
    // Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    // Booking routes
// Route::prefix('booking')->name('booking.')->group(function () {
//     Route::get('/', [App\Http\Controllers\BookingController::class, 'index'])->name('index');
    
//     // Route untuk pilih treatment -> stylist & jadwal
//     Route::get('/select/{treatment}', [App\Http\Controllers\BookingController::class, 'select'])
//         ->name('select');
// });
// // Route baru untuk summary
//     Route::post('/summary', [BookingController::class, 'summary'])->name('booking.summary');
Route::middleware(['auth'])->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index'); // halaman daftar treatment
    Route::get('/booking/select/{treatmentId?}', [BookingController::class, 'select'])->name('booking.select'); // step 1
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store'); // simpan booking
    Route::get('/booking/summary/{bookingId}', [BookingController::class, 'summary'])->name('booking.summary'); // step summary
    Route::post('/booking/pay/{bookingId}', [BookingController::class, 'pay'])->name('booking.pay'); // bayar
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history'); // riwayat
    Route::post('/booking/notification', [BookingController::class, 'handleNotification'])->name('booking.notification'); // webhook
});
});