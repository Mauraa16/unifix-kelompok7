@extends('layouts.app')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="header-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h1 class="page-title">Kelola Laporan</h1>
            <p class="page-subtitle">Pantau dan kelola semua laporan kerusakan fasilitas universitas dengan mudah dan efisien</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Laporan</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Dashboard Stats -->
<section class="dashboard-stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $laporan->count() }}</h3>
                    <p>Total Laporan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $laporan->where('status', 'Belum Diproses')->count() }}</h3>
                    <p>Belum Diproses</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $laporan->where('status', 'Diproses')->count() }}</h3>
                    <p>Sedang Diproses</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $laporan->where('status', 'Selesai')->count() }}</h3>
                    <p>Sudah Selesai</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="reports-section">
    <div class="container">
        <div class="reports-header">
            <div class="reports-title">
                <h2>Daftar Laporan</h2>
                <p>Kelola semua laporan kerusakan yang telah Anda buat</p>
            </div>
            <div class="reports-actions">
                <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Buat Laporan Baru</span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="message-close" onclick="this.parentElement.style.display='none'" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if($laporan->count() > 0)
            <!-- Filters and Search -->
            <div class="reports-filters">
                <div class="filter-group">
                    <label for="status-filter" class="filter-label">
                        <i class="fas fa-filter"></i> Filter Status:
                    </label>
                    <select id="status-filter" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="Belum Diproses">Belum Diproses</option>
                        <option value="Diproses">Sedang Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="search-group">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="search-input" class="search-input" placeholder="Cari laporan...">
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="reports-grid" id="reports-container">
                @foreach($laporan as $item)
                    <div class="report-card" data-status="{{ $item->status }}" data-judul="{{ strtolower($item->judul) }}" data-lokasi="{{ strtolower($item->lokasi) }}">
                        <div class="report-header">
                            <div class="report-status">
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
                            </div>
                            <div class="report-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $item->created_at->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="report-content">
                            <h3 class="report-title">{{ $item->judul }}</h3>
                            <div class="report-meta">
                                <div class="meta-item">
                                    <i class="fas fa-tags"></i>
                                    <span>{{ $item->kategori->nama_kategori }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $item->lokasi }}</span>
                                </div>
                            </div>
                            <div class="report-description">
                                {{ Str::limit($item->deskripsi, 150) }}
                            </div>
                        </div>

                        @if($item->foto)
                            <div class="report-image">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan" loading="lazy">
                            </div>
                        @endif

                        <div class="report-actions">
                            <a href="{{ route('laporan.show', $item) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i>
                                <span>Lihat Detail</span>
                            </a>
                            @if($item->status == 'Belum Diproses')
                                <a href="{{ route('laporan.edit', $item) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $item->id }}, '{{ $item->judul }}')">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($laporan->hasPages())
                <div class="pagination-wrapper">
                    {{ $laporan->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="empty-state-content">
                    <h3>Belum Ada Laporan</h3>
                    <p>Anda belum membuat laporan kerusakan apapun. Mulai laporkan kerusakan fasilitas universitas untuk membantu perbaikan.</p>
                    <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Buat Laporan Pertama</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="custom-modal-overlay" id="deleteModal" style="display: none;">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">
                <i class="fas fa-exclamation-triangle"></i>
                Konfirmasi Hapus
            </h3>
            <button type="button" class="custom-modal-close" onclick="closeDeleteModal()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body">
            <div class="delete-confirmation">
                <div class="delete-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <div class="delete-message">
                    <p>Apakah Anda yakin ingin menghapus laporan "<strong id="delete-title"></strong>"?</p>
                    <p class="delete-warning">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
            <form id="delete-form" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    <span>Hapus Laporan</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/laporan.js') }}"></script>
@endsection
