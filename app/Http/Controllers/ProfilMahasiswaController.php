<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class ProfilMahasiswaController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // PERBAIKAN: Langsung ambil data (bersih)
        $laporanSaya = Laporan::where('user_id', $user->id)->count();
        $laporanSelesai = Laporan::where('user_id', $user->id)->where('status', 'Selesai')->count();
        $laporanProses = Laporan::where('user_id', $user->id)->where('status', 'Diproses')->count();

        return view('mahasiswa.profil.index', compact('user', 'laporanSaya', 'laporanSelesai', 'laporanProses'));
    }

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