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
        $this->middleware(['auth', 'role:petugas']);
    }

    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'kategori']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            // Konversi search term menjadi huruf kecil untuk perbandingan yang konsisten
            $searchTerm = '%' . strtolower($request->search) . '%';
            
            $query->where(function ($q) use ($searchTerm) {
                // Menggunakan DB::raw('lower(kolom)') untuk memastikan pencarian case-insensitive 
                // di tingkat database pada kolom 'judul' dan 'lokasi'.

                // Cari berdasarkan Judul (diketik kecil)
                $q->whereRaw('lower(judul) like ?', [$searchTerm])
                // Cari berdasarkan Lokasi (diketik kecil)
                ->orWhereRaw('lower(lokasi) like ?', [$searchTerm])
                
                // Cari berdasarkan Nama Pelapor (relasi user)
                ->orWhereHas('user', function ($subQuery) use ($searchTerm) {
                    // Cari nama user (diketik kecil)
                    $subQuery->whereRaw('lower(name) like ?', [$searchTerm]);
                });
            });
        }

        $laporan = $query->latest()->paginate(10)->withQueryString();

        return view('petugas.laporan.index', compact('laporan'));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load(['user', 'kategori', 'komentar.user']);

        return view('petugas.laporan.show', compact('laporan'));
    }

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