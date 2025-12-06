<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laporan;

class HomeController extends Controller
{
    public function __construct()
    {
        // PERBAIKAN: Tambahkan 'verified' agar controller ini mengecek status verifikasi
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard.index');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.beranda'); 
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    }

    public function adminDashboard()
    {
        $totalUsers = User::count();
        $totalLaporan = Laporan::count();
        $laporanPending = Laporan::where('status', 'Belum Diproses')->count();
        $laporanSelesai = Laporan::where('status', 'Selesai')->count();
        $recentLaporan = Laporan::with('user')->latest()->take(5)->get();
        
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalLaporan', 
            'laporanPending', 
            'laporanSelesai', 
            'recentLaporan', 
            'recentUsers'
        ));
    }

    public function petugasDashboard()
    {
        $totalLaporan          = Laporan::count();
        $laporanBelumDiproses  = Laporan::where('status', 'Belum Diproses')->count();
        $laporanDiproses       = Laporan::where('status', 'Diproses')->count();
        $laporanSelesai        = Laporan::where('status', 'Selesai')->count();

        $progressPercentage = $totalLaporan > 0
            ? round(($laporanSelesai / $totalLaporan) * 100, 1)
            : 0;

        $recentLaporan = Laporan::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        $today = today();
        $todayLaporan = Laporan::whereDate('created_at', $today)->count();
        $ditanganiHariIni = Laporan::whereIn('status', ['Diproses', 'Selesai'])
            ->whereDate('updated_at', $today)
            ->count();
        $selesaiHariIni = Laporan::where('status', 'Selesai')
            ->whereDate('updated_at', $today)
            ->count();

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

    public function mahasiswaBeranda()
    {
        $userId = Auth::id();

        // Statistik
        $totalLaporan   = Laporan::where('user_id', $userId)->count();
        $laporanPending = Laporan::where('user_id', $userId)->where('status', 'Belum Diproses')->count();
        $laporanProses  = Laporan::where('user_id', $userId)->where('status', 'Diproses')->count();
        $laporanSelesai = Laporan::where('user_id', $userId)->where('status', 'Selesai')->count();

        // Riwayat
        $riwayatTerbaru = Laporan::where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact(
            'totalLaporan', 
            'laporanPending', 
            'laporanProses', 
            'laporanSelesai', 
            'riwayatTerbaru'
        )); 
    }
}