<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==============================
    // WEB LOGIN (TETAP DIPAKAI)
    // ==============================
    public function showLoginForm()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin' || Auth::user()->role == 'kasir') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard.user');
            }
        }

        return back()->with('error', 'Username atau password salah!');
    }

    // ==============================
    // 🔥 API LOGIN (UNTUK FLUTTER)
    // ==============================
    public function loginApi(Request $request)
    {
        if (!Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login gagal'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role
            ]
        ]);
    }

    // ==============================
    // REGISTER (WEB)
    // ==============================
    public function showRegisterForm()
    {
        return view('auth');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'pelanggan',
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ]);

        return redirect()->route('auth')
            ->with('success', 'Akun berhasil dibuat. Silahkan login!');
    }

    // ==============================
    // LOGOUT
    // ==============================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth');
    }
}
