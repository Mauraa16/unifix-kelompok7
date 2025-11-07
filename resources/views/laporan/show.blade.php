@extends('layouts.app')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1 class="page-title">Detail Laporan</h1>
            <p class="page-subtitle">Informasi lengkap tentang laporan kerusakan fasilitas</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Kelola Laporan</a></li>
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
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Daftar Laporan</span>
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
                        <i class="fas fa-align-left"></i>
                        Deskripsi Lengkap
                    </h3>
                    <div class="description-content">
                        <p>{{ $laporan->deskripsi }}</p>
                    </div>
                </div>

                @if($laporan->komentar->count() > 0)
                    <div class="report-comments">
                        <h3 class="comments-title">
                            <i class="fas fa-comments"></i>
                            Komentar ({{ $laporan->komentar->count() }})
                        </h3>
                        <div class="comments-list">
                            @foreach($laporan->komentar as $komentar)
                                <div class="comment-item">
                                    <div class="comment-header">
                                        <div class="comment-author">
                                            <i class="fas fa-user"></i>
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
@endsection
