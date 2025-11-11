@extends('layouts.app')

@section('content')


<style>
/* ==== GLOBAL STYLE ==== */
body {
    font-family: 'Inter', sans-serif;
    background: #f8fafc;
    color: #1f2937;
}

/* ==== PAGE HEADER ==== */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0 40px;
    text-align: center;
    border-radius: 0 0 24px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.page-header .page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.page-header .page-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 20px;
}

.page-header .breadcrumb {
    display: inline-flex;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    padding: 8px 20px;
    border-radius: 30px;
    list-style: none;
    margin: 0;
    font-size: 14px;
}

.page-header .breadcrumb a {
    color: #fff;
    text-decoration: none;
}

.page-header .breadcrumb a:hover {
    text-decoration: underline;
}

.page-header .breadcrumb li {
    color: rgba(255,255,255,0.8);
}

/* ==== DASHBOARD STATS ==== */
.dashboard-stats {
    padding: 40px 0;
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.stat-card {
    background: linear-gradient(135deg, #ffffff, #f3f4f6);
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    font-size: 28px;
    color: #667eea;
    margin-bottom: 10px;
}

.stat-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.stat-content p {
    color: #6b7280;
    margin: 0;
}

/* ==== REPORT SECTION ==== */
.reports-section {
    padding: 60px 0;
    background: #f9fafb;
}

.reports-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    max-width: 1100px;
    margin-left: auto;
    margin-right: auto;
    padding: 0 20px;
}

.reports-title h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
}

.reports-title p {
    color: #6b7280;
    font-size: 0.95rem;
}

.reports-actions .btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: 0.3s;
}

.reports-actions .btn-primary:hover {
    box-shadow: 0 4px 12px rgba(118, 75, 162, 0.3);
    transform: translateY(-1px);
}

/* ==== REPORT CARD ==== */
.reports-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 24px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.report-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
}

.report-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.report-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px 0 20px;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-belum-diproses {
    background: #fff3cd;
    color: #856404;
}

.status-diproses {
    background: #cfe2ff;
    color: #084298;
}

.status-selesai {
    background: #d1e7dd;
    color: #0f5132;
}

.report-content {
    padding: 16px 20px;
}

.report-title {
    font-weight: 700;
    color: #1f2937;
    font-size: 1.25rem;
    margin-bottom: 8px;
}

.report-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 8px;
}

.report-description {
    color: #4b5563;
    font-size: 0.95rem;
    margin-bottom: 12px;
}

.report-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}

.report-actions {
    padding: 0 20px 20px 20px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-outline-primary, .btn-outline-warning, .btn-outline-danger {
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-outline-primary {
    color: #667eea;
    border: 1px solid #667eea;
}
.btn-outline-primary:hover {
    background: #667eea;
    color: #fff;
}
.btn-outline-warning {
    color: #d97706;
    border: 1px solid #d97706;
}
.btn-outline-warning:hover {
    background: #d97706;
    color: #fff;
}
.btn-outline-danger {
    color: #dc2626;
    border: 1px solid #dc2626;
}
.btn-outline-danger:hover {
    background: #dc2626;
    color: #fff;
}

/* ==== EMPTY STATE ==== */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}
.empty-state-icon {
    font-size: 50px;
    color: #a5b4fc;
    margin-bottom: 20px;
}
.empty-state-content h3 {
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 8px;
}
.empty-state-content p {
    color: #6b7280;
    margin-bottom: 16px;
}
</style>

<!-- ==== HEADER ==== -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <i class="fas fa-clipboard-list" style="font-size: 36px; margin-bottom: 8px;"></i>
            <h1 class="page-title">Kelola Laporan</h1>
            <p class="page-subtitle">Pantau dan kelola semua laporan kerusakan fasilitas universitas dengan mudah</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>/</li>
                    <li class="active">Kelola Laporan</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- ==== STATISTIC CARDS ==== -->
<section class="dashboard-stats">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-content">
                <h3>{{ $laporan->count() }}</h3>
                <p>Total Laporan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-content">
                <h3>{{ $laporan->where('status', 'Belum Diproses')->count() }}</h3>
                <p>Belum Diproses</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-cogs"></i></div>
            <div class="stat-content">
                <h3>{{ $laporan->where('status', 'Diproses')->count() }}</h3>
                <p>Sedang Diproses</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content">
                <h3>{{ $laporan->where('status', 'Selesai')->count() }}</h3>
                <p>Sudah Selesai</p>
            </div>
        </div>
    </div>
</section>

<!-- ==== MAIN REPORTS ==== -->
<section class="reports-section">
    <div class="reports-header">
        <div class="reports-title">
            <h2>Daftar Laporan</h2>
            <p>Kelola semua laporan kerusakan yang telah Anda buat</p>
        </div>
        <div class="reports-actions">
            <a href="{{ route('laporan.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
        </div>
    </div>

    @if($laporan->count() > 0)
    <div class="reports-grid">
        @foreach($laporan as $item)
        <div class="report-card">
            @if($item->foto)
            <div class="report-image">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan">
            </div>
            @endif
            <div class="report-header">
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $item->status)) }}">
                    @if($item->status == 'Belum Diproses')
                        <i class="fas fa-clock"></i>
                    @elseif($item->status == 'Diproses')
                        <i class="fas fa-cogs"></i>
                    @else
                        <i class="fas fa-check-circle"></i>
                    @endif
                    {{ $item->status }}
                </span>
                <small><i class="fas fa-calendar-alt"></i> {{ $item->created_at->format('d/m/Y') }}</small>
            </div>
            <div class="report-content">
                <h3 class="report-title">{{ $item->judul }}</h3>
                <div class="report-meta">
                    <span><i class="fas fa-tags"></i> {{ $item->kategori->nama_kategori }}</span>
                    <span><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}</span>
                </div>
                <div class="report-description">
                    {{ Str::limit($item->deskripsi, 120) }}
                </div>
            </div>
            <div class="report-actions">
                <a href="{{ route('laporan.show', $item) }}" class="btn-outline-primary">
                    <i class="fas fa-eye"></i> Detail
                </a>
                @if($item->status == 'Belum Diproses')
                <a href="{{ route('laporan.edit', $item) }}" class="btn-outline-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form method="POST" action="{{ route('laporan.destroy', $item) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-outline-danger" onclick="return confirm('Yakin hapus laporan ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-clipboard-list"></i></div>
        <div class="empty-state-content">
            <h3>Belum Ada Laporan</h3>
            <p>Anda belum membuat laporan apapun. Laporkan kerusakan fasilitas universitas agar bisa segera diperbaiki.</p>
            <a href="{{ route('laporan.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Buat Laporan Pertama
            </a>
        </div>
    </div>
    @endif
</section>
@endsection
