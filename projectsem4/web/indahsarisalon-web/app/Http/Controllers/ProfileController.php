<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    // AJAX: Update Avatar
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->file('avatar')) {
            // Hapus foto lama jika ada dan bukan default
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru
            $fileName = time() . '_' . $user->id . '.' . $request->avatar->extension();
            $path = $request->file('avatar')->storeAs('avatars', $fileName, 'public');

            // Update database
            $user->update(['avatar' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui.',
                'avatar_url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah foto.'], 400);
    }

    // AJAX: Update Informasi Dasar (Nama & Username)
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'required|string|max:15',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Informasi profil berhasil diperbarui.',
            'name' => $user->name,
            'username' => $user->username,
            'phone' => $user->phone
        ]);
    }

    // AJAX: Ganti password manual (Current vs New)
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Kata sandi saat ini salah!'], 422);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['success' => true, 'message' => 'Kata sandi berhasil diperbarui.']);
    }

    // AJAX: Kirim OTP Lupa Password (saat sedang login)
    public function sendOtp(Request $request)
    {
        $user = auth()->user();
        $otp = rand(100000, 999999);

        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        Mail::to($user->email)->send(new SendOtpMail($otp));

        return response()->json(['success' => true, 'message' => 'OTP telah dikirim ke email Anda.']);
    }

    // AJAX: Verifikasi OTP & Ganti Password baru
    public function verifyAndReset(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $otpData = PasswordReset::where('email', $user->email)
                                ->where('otp', $request->otp)
                                ->first();

        if (!$otpData || $otpData->expires_at < now()) {
            return response()->json(['success' => false, 'message' => 'OTP tidak valid atau sudah kedaluwarsa!'], 422);
        }

        // Update password
        $user->update(['password' => Hash::make($request->new_password)]);
        $otpData->delete();

        return response()->json(['success' => true, 'message' => 'Kata sandi berhasil di-reset menggunakan OTP.']);
    }
}
