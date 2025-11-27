<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Komentar;
use App\Models\KategoriLaporan; // <-- DITAMBAHKAN: Untuk mengambil data kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KelolaLaporanController extends Controller
{
    /**
     * Pastikan hanya admin dan petugas yang bisa akses.
     */
    public function __construct()
    {
        // Semua role (admin/petugas) bisa mengakses halaman ini
        $this->middleware(['auth', 'role:admin,petugas']);
        
        // PERBAIKAN: Tapi HANYA admin yang bisa edit, update, dan hapus
        $this->middleware(['role:admin'])->only(['edit', 'update', 'destroy']);
    }

    /**
     * Menampilkan daftar SEMUA laporan.
     */
    public function index(Request $request)
    {
        $query = Laporan::with('user', 'kategori')->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $laporan = $query->paginate(10)->withQueryString();
        
        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Menampilkan detail laporan untuk admin/petugas.
     */
    public function show(Laporan $laporan)
    {
        // Load semua relasi: pelapor, kategori, dan komentar (beserta user yg komen)
        $laporan->load('user', 'kategori', 'komentar.user');
        return view('admin.laporan.show', compact('laporan'));
    }





    /**
     * Simpan komentar baru dari admin/petugas.
     */
    public function storeKomentar(Request $request, Laporan $laporan)
    {
        $request->validate([
            'isi_komentar' => 'required|string|min:3',
        ]);

        Komentar::create([
            'laporan_id' => $laporan->id,
            'user_id' => Auth::id(), // ID Admin/Petugas yang sedang login
            'isi_komentar' => $request->isi_komentar,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }


}