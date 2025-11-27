<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilPetugasController extends Controller
{
    public function __construct()
    {
        // Hanya petugas yg boleh akses controller ini
        $this->middleware(['auth', 'role:petugas']);
    }

    // ============================================================
    // 1. Menampilkan halaman profil petugas
    // ============================================================
    public function show()
    {
        $user = Auth::user();

        // Hitung total laporan yang ditangani petugas
        $totalLaporanDitangani = \App\Models\Laporan::whereHas('komentar', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        // Hitung total komentar yang diberikan
        $totalKomentar = \App\Models\Komentar::where('user_id', $user->id)->count();

        return view('petugas.profil.index', compact('totalLaporanDitangani', 'totalKomentar'));
    }

    // ============================================================
    // 2. Update profil petugas
    // ============================================================
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
