<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AbsensiController extends Controller
{
    // Tombol absen masuk
    public function absenMasuk(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // cek role kasir langsung di controller
        if ($user->role !== 'kasir') {
            abort(403, 'Unauthorized');
        }

        $today = now()->format('Y-m-d');

        // Cek apakah sudah absen hari ini
        $absen = Absensi::firstOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['jam_masuk' => now(), 'status' => 'Hadir']
        );

        return response()->json(['success' => true, 'message' => 'Absen masuk tercatat']);
    }

    // Tombol absen keluar
    public function absenKeluar(Request $request)
    {
        $user = Auth::user();

        // cek role kasir
        if ($user->role !== 'kasir') {
            abort(403, 'Unauthorized');
        }

        $today = now()->format('Y-m-d');

        $absen = Absensi::where('user_id', $user->id)
                        ->where('tanggal', $today)
                        ->first();

        if($absen){
            $absen->update(['jam_keluar' => now()]);
            return response()->json(['success' => true, 'message' => 'Absen keluar tercatat']);
        }

        return response()->json(['success' => false, 'message' => 'Belum absen masuk']);
    }
}