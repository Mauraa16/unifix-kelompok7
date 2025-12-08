<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Komentar; 
use App\Models\KategoriLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KelolaLaporanController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,petugas']);
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search'); 

        $query = Laporan::with('user', 'kategori')->latest();

        if ($status && $status != '') {
            $query->where('status', $status);
        }

        if ($search) {
            $searchWildcard = '%' . strtolower($search) . '%'; 

            $query->where(function ($q) use ($searchWildcard) {
                
                $q->whereRaw('LOWER(judul) LIKE ?', [$searchWildcard])
                  
                  ->orWhereRaw('LOWER(lokasi) LIKE ?', [$searchWildcard])
                  
                  ->orWhereHas('user', function ($q_user) use ($searchWildcard) {
                      $q_user->whereRaw('LOWER(name) LIKE ?', [$searchWildcard]);
                  })
                  
                  ->orWhereHas('kategori', function ($q_kategori) use ($searchWildcard) {
                      $q_kategori->whereRaw('LOWER(nama_kategori) LIKE ?', [$searchWildcard]);
                  });
            });
        }

        $laporan = $query->paginate(10)->withQueryString();
        
        return view('admin.laporan.index', compact('laporan'));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('user', 'kategori', 'komentar.user'); 
        return view('admin.laporan.show', compact('laporan'));
    }

    public function storeKomentar(Request $request, Laporan $laporan)
    {
        $request->validate([
            'isi_komentar' => 'required|string|min:3',
        ]);

        Komentar::create([
            'laporan_id' => $laporan->id,
            'user_id' => Auth::id(), 
            'isi_komentar' => $request->isi_komentar,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}