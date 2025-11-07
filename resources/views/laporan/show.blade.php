@extends('layouts.app')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1 class="page-title">🧾 Detail Laporan</h1>
            <p class="page-subtitle">Informasi lengkap tentang laporan kerusakan fasilitas</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">🏠 Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">📋 Kelola Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Laporan</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Report Detail Section -->
<section class="reports-section">
    <div class="container">
        <div class="report-detail-card">
            <div class="report-detail-header">
                <div class="report-detail-actions">
                    <a href="{{ route('laporan.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>

            <div class="report-detail-content">
                <div class="report-detail-main">
                    <div class="report-detail-info">
                        <h2 class="report-detail-title">{{ $laporan->judul }}</h2>

                        <div class="report-detail-meta">
                            <div class="meta-item">
                                <i class="fas fa-tags"></i>
                                <span><strong>Kategori:</strong> {{ $laporan->kategori->nama_kategori }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><strong>Lokasi:</strong> {{ $laporan->lokasi }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span><strong>Tanggal Dibuat:</strong> {{ $laporan->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <div class="report-detail-status">
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $laporan->status)) }}">
                                @if($laporan->status == 'Belum Diproses')
                                    <i class="fas fa-clock"></i>
                                @elseif($laporan->status == 'Diproses')
                                    <i class="fas fa-cogs"></i>
                                @else
                                    <i class="fas fa-check-circle"></i>
                                @endif
                                {{ $laporan->status }}
                            </span>
                        </div>
                    </div>

                    @if($laporan->foto)
                        <div class="report-detail-image">
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan" loading="lazy">
                        </div>
                    @endif
                </div>

                <div class="report-detail-description">
                    <h3 class="description-title">
                        <i class="fas fa-align-left"></i> Deskripsi Lengkap
                    </h3>
                    <div class="description-content">
                        <p>{{ $laporan->deskripsi }}</p>
                    </div>
                </div>

                @if($laporan->komentar->count() > 0)
                    <div class="report-comments">
                        <h3 class="comments-title">
                            <i class="fas fa-comments"></i> Komentar ({{ $laporan->komentar->count() }})
                        </h3>
                        <div class="comments-list">
                            @foreach($laporan->komentar as $komentar)
                                <div class="comment-item">
                                    <div class="comment-header">
                                        <div class="comment-author">
                                            <i class="fas fa-user-circle"></i>
                                            <span>{{ $komentar->user->name }}</span>
                                        </div>
                                        <div class="comment-date">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $komentar->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>{{ $komentar->isi_komentar }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
/* ==== General Style ==== */
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #2e2e2e;
}

/* ==== Page Header ==== */
.page-header {
    padding: 60px 0 30px;
    text-align: center;
    color: white;
}

.page-title {
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.page-subtitle {
    font-size: 1rem;
    opacity: 0.9;
}

.breadcrumb {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin-top: 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 30px;
    padding: 8px 20px;
}

.breadcrumb-item a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item.active {
    color: #ffd6ff;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    margin: 0 8px;
    color: #fff;
}

/* ==== Report Detail Card ==== */
.report-detail-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 30px 40px;
    margin: 40px auto;
    color: white;
    max-width: 900px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    animation: fadeIn 0.8s ease-in-out;
}

/* ==== Buttons ==== */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: 2px solid #fff;
    border-radius: 8px;
    color: #fff;
    padding: 8px 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-back:hover {
    background: rgba(255,255,255,0.2);
    transform: translateX(-4px);
}

/* ==== Detail Info ==== */
.report-detail-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.report-detail-meta {
    display: grid;
    gap: 10px;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.meta-item i {
    margin-right: 6px;
    color: #ffd6ff;
}

/* ==== Status Badge ==== */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 6px 14px;
    border-radius: 50px;
    margin-top: 5px;
}

.status-belum-diproses {
    background: #ffb347;
    color: #333;
}

.status-diproses {
    background: #6dd5ed;
    color: #333;
}

.status-selesai {
    background: #9df89d;
    color: #333;
}

/* ==== Image ==== */
.report-detail-image img {
    width: 100%;
    border-radius: 15px;
    margin-top: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s;
}
.report-detail-image img:hover {
    transform: scale(1.03);
}

/* ==== Description ==== */
.report-detail-description {
    margin-top: 30px;
}
.description-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #fff;
}
.description-content p {
    background: rgba(255,255,255,0.1);
    padding: 15px;
    border-radius: 10px;
    line-height: 1.6;
}

/* ==== Comments ==== */
.report-comments {
    margin-top: 35px;
}
.comments-title {
    font-size: 1.2rem;
    margin-bottom: 15px;
}
.comment-item {
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    transition: transform 0.3s;
}
.comment-item:hover {
    transform: translateY(-3px);
}
.comment-header {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: #ffd6ff;
}
.comment-content p {
    margin: 0;
    color: #fff;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
