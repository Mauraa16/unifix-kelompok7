<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laporan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * INDEX: "Penjaga Gerbang"
     * Mengecek role user dan melempar ke dashboard yang sesuai.
     */
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard.index');
            case 'mahasiswa':
                // Redirect ke route 'mahasiswa.beranda' (lihat fungsi di bawah)
                return redirect()->route('mahasiswa.beranda'); 
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    }

    // ====================================================================
    // FUNGSI KHUSUS DASHBOARD (Dipanggil oleh routes/web.php)
    // ====================================================================

    /**
     * ADMIN DASHBOARD
     * Mengambil data statistik dan menampilkan view admin.
     */
    public function adminDashboard()
    {
        // Ambil data untuk statistik dashboard
        $totalUsers = User::count();
        
        // Cek apakah model Laporan ada biar tidak error
        if (class_exists(Laporan::class)) {
            $totalLaporan = Laporan::count();
            $laporanPending = Laporan::where('status', 'Belum Diproses')->count();
            $laporanSelesai = Laporan::where('status', 'Sudah Diproses')->count();
            $recentLaporan = Laporan::with('user')->latest()->take(5)->get();
        } else {
            $totalLaporan = 0;
            $laporanPending = 0;
            $laporanSelesai = 0;
            $recentLaporan = collect();
        }
        
        $recentUsers = User::latest()->take(5)->get();

        // View: resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalLaporan', 
            'laporanPending', 
            'laporanSelesai', 
            'recentLaporan', 
            'recentUsers'
        ));
    }

    /**
     * Dashboard Petugas
     */
    public function petugasDashboard()
    {
        // Statistik utama
        $totalLaporan          = Laporan::count();
        $laporanBelumDiproses  = Laporan::where('status', 'Belum Diproses')->count();
        $laporanDiproses       = Laporan::where('status', 'Diproses')->count();
        $laporanSelesai        = Laporan::where('status', 'Selesai')->count();

        // Progress (%) selesai
        $progressPercentage = $totalLaporan > 0
            ? round(($laporanSelesai / $totalLaporan) * 100, 1)
            : 0;

        // Laporan terbaru (5 terakhir)
        $recentLaporan = Laporan::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        // Statistik untuk hari ini
        $today = today();

        $todayLaporan = Laporan::whereDate('created_at', $today)->count();

        $ditanganiHariIni = Laporan::whereIn('status', ['Diproses', 'Selesai'])
            ->whereDate('updated_at', $today)
            ->count();

        $selesaiHariIni = Laporan::where('status', 'Selesai')
            ->whereDate('updated_at', $today)
            ->count();

        // Kirim data ke view
        return view('petugas.dashboard.index', compact(
            'totalLaporan',
            'laporanBelumDiproses',
            'laporanDiproses',
            'laporanSelesai',
            'progressPercentage',
            'recentLaporan',
            'todayLaporan',
            'ditanganiHariIni',
            'selesaiHariIni'
        ));
    }


    /**
     * MAHASISWA BERANDA
     */
    public function mahasiswaBeranda()
    {
        // View: resources/views/home.blade.php (Sesuai screenshot kamu)
        return view('home'); 
    }
}