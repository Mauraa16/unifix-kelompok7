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

    public function uploadPhoto(Request $request)
    {
        try {
            $request->validate([
                'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            ]);

            $user = auth()->user();

            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('foto_profil')->store('profile-photos', 'public');

            $user->foto_profil = $path;
            $user->save();

            $newUrl = asset('storage/' . $path) . '?v=' . now()->timestamp;

            return redirect()->route('admin.profil.index')->with('success', 'Foto profil berhasil diunggah!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto profil: ' . $e->getMessage());
        }
    }

    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);

            $user->foto_profil = null;
            $user->save();
        
            return redirect()->route('admin.profil.index')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki foto profil untuk dihapus.');
    }
}