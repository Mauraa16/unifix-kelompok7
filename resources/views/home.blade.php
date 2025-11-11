@extends('layouts.app')

@section('content')


<style>
body {
    font-family: 'Poppins', sans-serif;
}
.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* HERO SECTION */
.hero-section {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    padding: 6rem 0;
    position: relative;
}
.hero-container {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}
.hero-content {
    flex: 1 1 450px;
}
.hero-title {
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 700;
    margin-bottom: 1rem;
}
.hero-subtitle {
    font-size: clamp(1rem, 1.5vw, 1.25rem);
    opacity: 0.9;
    margin-bottom: 2rem;
}
.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}
.hero-actions .btn {
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s ease;
    text-decoration: none;
}
.btn-primary {
    background: #fff;
    color: #667eea;
    border: 2px solid #fff;
}
.btn-primary:hover {
    background: rgba(255,255,255,0.9);
    transform: translateY(-3px);
}
.btn-outline-primary {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}
.btn-outline-primary:hover {
    background: #fff;
    color: #667eea;
    transform: translateY(-3px);
}
.hero-image {
    flex: 1 1 400px;
    text-align: center;
}
.hero-illustration {
    width: 100%;
    max-width: 480px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    transition: transform 0.4s ease;
}
.hero-illustration:hover {
    transform: scale(1.03);
}

/* STATS SECTION */
.stats-section {
    padding: 60px 0;
    background: #f8fafc;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

/* FEATURES SECTION */
.features-section {
    background: #fff;
    padding: 80px 0;
}
.section-header {
    text-align: center;
    margin-bottom: 60px;
}
.section-title {
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 700;
}
.section-subtitle {
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
}
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}
.feature-card {
    background: #f9fafb;
    border-radius: 16px;
    padding: 40px 25px;
    text-align: center;
    transition: 0.3s ease;
    border: 1px solid #e5e7eb;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.feature-icon {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin: 0 auto 20px;
}

/* QUICK ACTIONS SECTION */
.quick-actions-section {
    background: #f8fafc;
    padding: 80px 0;
}
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
}
.quick-action-card {
    background: white;
    border-radius: 16px;
    display: flex;
    align-items: center;
    padding: 25px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.quick-action-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}
.quick-action-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 5px;
}
.quick-action-arrow {
    margin-left: auto;
    color: #667eea;
    font-size: 20px;
    transition: transform 0.3s ease;
}
.quick-action-card:hover .quick-action-arrow {
    transform: translateX(6px);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .hero-container {
        flex-direction: column;
        text-align: center;
    }
    .hero-actions {
        justify-content: center;
    }
}
</style>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di UNIFIX</h1>
            <p class="hero-subtitle">Sistem Pelaporan Kerusakan Fasilitas Universitas yang cepat, aman, dan efisien</p>
            <div class="hero-actions">
                @if(auth()->user()->role == 'mahasiswa')
                    <a href="{{ route('laporan.index') }}" class="btn btn-primary">
                        <i class="fas fa-clipboard-list"></i> Kelola Laporan
                    </a>
                    <a href="{{ route('laporan.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Buat Laporan Baru
                    </a>
                @endif
            </div>
        </div>
        <div class="hero-image">
            <img src="https://img.freepik.com/free-vector/maintenance-concept-illustration_114360-392.jpg"
                 alt="UNIFIX Illustration" class="hero-illustration">
        </div>
    </div>
</section>

<!-- STATS SECTION -->
@if(auth()->user()->role == 'mahasiswa')
<section class="stats-section">
    <div class="container stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h3 class="stat-number">{{ \App\Models\Laporan::where('user_id', auth()->id())->count() }}</h3>
                <p class="stat-label">Total Laporan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <h3 class="stat-number">{{ \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Belum Diproses')->count() }}</h3>
                <p class="stat-label">Belum Diproses</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <h3 class="stat-number">{{ \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Sudah Diproses')->count() }}</h3>
                <p class="stat-label">Sudah Diproses</p>
            </div>
        </div>
    </div>
</section>
@endif

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Pelaporan kerusakan fasilitas universitas yang mudah dan cepat</p>
        </div>
        <div class="features-grid">
            @foreach([
                ['fa-camera', 'Foto & Kamera', 'Ambil foto langsung atau upload gambar untuk laporan.'],
                ['fa-tags', 'Kategori Lengkap', 'Pilih kategori sesuai jenis kerusakan.'],
                ['fa-map-marker-alt', 'Lokasi Spesifik', 'Tentukan lokasi kejadian dengan akurat.'],
                ['fa-comments', 'Sistem Komentar', 'Diskusi langsung dengan admin.'],
                ['fa-mobile-alt', 'Responsive Design', 'Akses mudah di semua perangkat.'],
                ['fa-shield-alt', 'Keamanan Data', 'Data Anda terlindungi sepenuhnya.']
            ] as $index => $feature)
            <div class="feature-card">
                <div class="feature-icon"><i class="fas {{ $feature[0] }}"></i></div>
                <h3>{{ $feature[1] }}</h3>
                <p>{{ $feature[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- QUICK ACTIONS SECTION -->
@if(auth()->user()->role == 'mahasiswa')
<section class="quick-actions-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Aksi Cepat</h2>
            <p class="section-subtitle">Laporan terbaru dan aksi yang sering digunakan</p>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('laporan.create') }}" class="quick-action-card">
                <div class="quick-action-icon"><i class="fas fa-plus-circle"></i></div>
                <div class="quick-action-content">
                    <h3>Buat Laporan Baru</h3>
                    <p>Laporkan kerusakan fasilitas</p>
                </div>
                <div class="quick-action-arrow"><i class="fas fa-arrow-right"></i></div>
            </a>
            <a href="{{ route('laporan.index') }}" class="quick-action-card">
                <div class="quick-action-icon"><i class="fas fa-list"></i></div>
                <div class="quick-action-content">
                    <h3>Lihat Semua Laporan</h3>
                    <p>Kelola laporan Anda</p>
                </div>
                <div class="quick-action-arrow"><i class="fas fa-arrow-right"></i></div>
            </a>
        </div>
    </div>
</section>
@endif


@endsection
