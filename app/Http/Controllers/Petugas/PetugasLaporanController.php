<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasLaporanController extends Controller
{
    public function __construct()
    {
        // Hanya petugas yg boleh akses controller ini
        $this->middleware(['auth', 'role:petugas']);
    }

    // ============================================================
    // 1. Menampilkan semua laporan
    // ============================================================
    public function index()
    {
        $laporan = Laporan::with(['user', 'kategori'])
            ->latest()
            ->paginate(10);

        return view('petugas.laporan.index', compact('laporan'));
    }

    // ============================================================
    // 2. Detail laporan
    // ============================================================
    public function show(Laporan $laporan)
    {
        $laporan->load(['user', 'kategori', 'komentar.user']);

        return view('petugas.laporan.show', compact('laporan'));
    }

    // ============================================================
    // 3. Update status laporan
    // ============================================================
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:Belum Diproses,Diproses,Selesai',
        ]);

        $laporan->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    // ============================================================
    // 4. Tambah komentar
    // ============================================================
    public function storeKomentar(Request $request, Laporan $laporan)
    {
        $request->validate([
            'isi_komentar' => 'required|min:3'
        ]);

        Komentar::create([
            'laporan_id'   => $laporan->id,
            'user_id'      => Auth::id(),
            'isi_komentar' => $request->isi_komentar
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    // ============================================================
    // 5. Filter status: Belum Diproses
    // ============================================================
    public function filterBelumDiproses()
    {
        $laporan = Laporan::where('status', 'Belum Diproses')
            ->with(['user', 'kategori'])
            ->latest()->paginate(10);

        return view('petugas.laporan.index', compact('laporan'));
    }

    // ============================================================
    // 6. Filter status: Diproses
    // ============================================================
    public function filterDiproses()
    {
        $laporan = Laporan::where('status', 'Diproses')
            ->with(['user', 'kategori'])
            ->latest()->paginate(10);

        return view('petugas.laporan.index', compact('laporan'));
    }

    // ============================================================
    // 7. Filter status: Selesai
    // ============================================================
    public function filterSelesai()
    {
        $laporan = Laporan::where('status', 'Selesai')
            ->with(['user', 'kategori'])
            ->latest()->paginate(10);

        return view('petugas.laporan.index', compact('laporan'));
    }

    // ============================================================
    // 8. Riwayat laporan yg ditangani petugas
    // ============================================================
    public function riwayat()
    {
        $userId = Auth::id();

        $laporan = Laporan::whereHas('komentar', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['user', 'kategori'])
            ->latest()
            ->paginate(10);

        return view('petugas.riwayat.index', compact('laporan'));
    }
}
