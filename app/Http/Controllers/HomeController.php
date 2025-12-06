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
                return redirect()->route('mahasiswa.beranda'); 
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    }

    // ====================================================================
    // FUNGSI KHUSUS DASHBOARD
    // ====================================================================

    /**
     * ADMIN DASHBOARD
     */
    public function adminDashboard()
    {
        $totalUsers = User::count();
        
        if (class_exists(Laporan::class)) {
            $totalLaporan = Laporan::count();
            $laporanPending = Laporan::where('status', 'Belum Diproses')->count();
            $laporanSelesai = Laporan::where('status', 'Selesai')->count();
            $recentLaporan = Laporan::with('user')->latest()->take(5)->get();
        } else {
            $totalLaporan = 0;
            $laporanPending = 0;
            $laporanSelesai = 0;
            $recentLaporan = collect();
        }
        
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

    /**
     * PETUGAS DASHBOARD
     */
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

    /**
     * MAHASISWA BERANDA (UPDATE)
     * Menampilkan statistik dan riwayat laporan milik mahasiswa yang login.
     */
    public function mahasiswaBeranda()
    {
        $userId = Auth::id();

        // Ambil statistik laporan saya
        $totalLaporan   = Laporan::where('user_id', $userId)->count();
        $laporanPending = Laporan::where('user_id', $userId)->where('status', 'Belum Diproses')->count();
        $laporanProses  = Laporan::where('user_id', $userId)->where('status', 'Diproses')->count();
        $laporanSelesai = Laporan::where('user_id', $userId)->where('status', 'Selesai')->count();

        // Ambil 3 laporan terakhir untuk ditampilkan di widget riwayat
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