<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use App\Models\Laporan;

class ProfilMahasiswaController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
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
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('foto_profil')->store('profile-photos', 'public');
            $dataToUpdate['foto_profil'] = $path;
        }

        $user->update($dataToUpdate);

        return redirect()->route('mahasiswa.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->foto_profil) {
            if (Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $user->foto_profil = null;
            $user->save();

            $user->touch();

            return redirect()->route('mahasiswa.profil')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->route('mahasiswa.profil')->with('error', 'Tidak ada foto profil untuk dihapus.');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $user = Auth::user();
        $file = $request->file('foto_profil');

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $path = $file->store('profile-photos', 'public');

        $user->foto_profil = $path;
        $user->save();

        return redirect()->route('mahasiswa.profil')->with('success', 'Foto profil berhasil diunggah dan disimpan!');
    }
}