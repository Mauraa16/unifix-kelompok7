<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laporan;

class ProfilAdminController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Statistik Ringkas untuk Admin
        $totalUsers = User::count();
        $totalLaporan = Laporan::count();
        $totalLaporanSelesai = Laporan::where('status', 'Selesai')->count();

        return view('admin.profil.index', compact('user', 'totalUsers', 'totalLaporan', 'totalLaporanSelesai'));
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

        return redirect()->back()->with('success', 'Profil admin berhasil diperbarui.');
    }
}