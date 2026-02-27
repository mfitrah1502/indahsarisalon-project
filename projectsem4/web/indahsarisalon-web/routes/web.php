<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProdukController;  

Route::get('/home', function () {
    return view('home');
});
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function(Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $dummyUsername = 'admin';
    $dummyPassword = 'password';
    if ($username === $dummyUsername && $password === $dummyPassword) {
        return redirect()->route(route: 'dashboard');
    } 
    return back()->with('error', 'Invalid username or password');
})->name('login.process');