<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProdukController; 
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
// Produk
// ------------------------------
// Route::resource('produk', ProdukController::class);

// Halaman About & Contact
Route::get('/about', [PageController::class, 'about'])->name('about');

// ------------------------------
// Dashboard
Route::resource('karyawan', KaryawanController::class);
Route::get('/karyawan/{id}/absensi', [KaryawanController::class, 'absensi'])
    ->name('karyawan.absensi');
// ------------------------------
// Auth: Login / Register
Route::middleware('auth')->group(function () {
    Route::prefix('absensi')->middleware('role:kasir')->group(function () {
        Route::post('/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
        Route::post('/keluar', [AbsensiController::class, 'keluar'])->name('absensi.keluar');
    });
    Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
    Route::post('/absensi/keluar', [AbsensiController::class, 'absenKeluar'])->name('absensi.keluar');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    // route filter sebelum resource
Route::get('treatment/filter', [TreatmentController::class, 'filter'])->name('treatment.filter');

// resource route setelah
Route::resource('treatment', TreatmentController::class);
});
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/treatment/filter-debug', [TreatmentController::class, 'filter'])->name('treatment.filter.debug');

    Route::get('/dashboard', fn() => view('dashboard.homepage'))
    ->name('dashboard');

    Route::get('/dashboard/user', fn() => view('dashboard.homepage-user'))
    ->name('dashboard.user');

});
// ------------------------------
// Form login & register
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
// 1️⃣ Form masukkan email
Route::get('/reset-password', fn() => view('otp'))->name('reset.password');
// 2️⃣ Proses kirim OTP
Route::post('/reset-password', [PasswordResetController::class, 'sendOtp'])->name('reset.password.email');
// 3️⃣ Form input OTP + password baru
Route::get('/reset-password/otp', fn(Request $request) => view('otp', ['email' => $request->email]))
    ->name('reset.password.otp');
// Verifikasi OTP
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp'])->name('otp.verify');
// Form input password baru
Route::get('/new-password', fn(Request $request) => view('new-password', [
    'email' => $request->email,
    'otp' => $request->otp
]))->name('reset.password.form');
// 4️⃣ Proses reset password
Route::post('/reset-password/otp', [PasswordResetController::class, 'resetPassword'])
    ->name('reset.password.update');