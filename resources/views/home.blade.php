@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di UNIFIX</h1>
            <p class="hero-subtitle">Sistem Pelaporan Kerusakan Fasilitas Universitas</p>
            <div class="hero-actions">
                @if(auth()->user()->role == 'mahasiswa')
                    <a href="{{ route('laporan.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-clipboard-list"></i> Kelola Laporan
                    </a>
                    <a href="{{ route('laporan.create') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-plus"></i> Buat Laporan Baru
                    </a>
                @endif
            </div>
        </div>
        <div class="hero-image">
            <img src="https://img.freepik.com/free-vector/maintenance-concept-illustration_114360-392.jpg" alt="UNIFIX Illustration" class="hero-illustration">
        </div>
    </div>
</section>

<!-- Stats Section -->
@if(auth()->user()->role == 'mahasiswa')
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ \App\Models\Laporan::where('user_id', auth()->id())->count() }}</h3>
                    <p class="stat-label">Total Laporan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Belum Diproses')->count() }}</h3>
                    <p class="stat-label">Belum Diproses</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Sudah Diproses')->count() }}</h3>
                    <p class="stat-label">Sudah Diproses</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Pelaporan kerusakan fasilitas universitas yang mudah dan cepat</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h3 class="feature-title">Foto & Kamera</h3>
                <p class="feature-description">Ambil foto langsung dari kamera atau upload gambar untuk melengkapi laporan Anda.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="feature-title">Kategori Lengkap</h3>
                <p class="feature-description">Pilih kategori yang sesuai untuk memudahkan klasifikasi dan penanganan laporan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="feature-title">Lokasi Spesifik</h3>
                <p class="feature-description">Tentukan lokasi gedung atau fakultas tempat kerusakan terjadi dengan jelas.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3 class="feature-title">Sistem Komentar</h3>
                <p class="feature-description">Komunikasi dengan admin melalui sistem komentar untuk update progress.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Responsive Design</h3>
                <p class="feature-description">Akses sistem dari berbagai perangkat dengan tampilan yang optimal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Keamanan Data</h3>
                <p class="feature-description">Data Anda aman dengan sistem autentikasi dan enkripsi yang ketat.</p>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions Section -->
@if(auth()->user()->role == 'mahasiswa')
<section class="quick-actions-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Aksi Cepat</h2>
            <p class="section-subtitle">Laporan terbaru dan aksi yang sering digunakan</p>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('laporan.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Buat Laporan Baru</h3>
                    <p>Laporkan kerusakan fasilitas</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('laporan.index') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Lihat Semua Laporan</h3>
                    <p>Kelola laporan Anda</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</section>
@endif

@endsection
