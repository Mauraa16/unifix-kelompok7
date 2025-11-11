@extends('layouts.app')

@section('content')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.05"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.05"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.page-header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
    z-index: 2;
    position: relative;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.breadcrumb {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 8px;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: white;
}

.breadcrumb-item.active {
    color: white;
    font-weight: 500;
}

/* Create Form Section */
.create-form-section {
    padding: 60px 0;
    background: #f8fafc;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    margin: 0 auto 20px;
}

.form-title h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.form-title p {
    color: #6b7280;
    font-size: 1.125rem;
    line-height: 1.6;
}

/* Form Progress */
.form-progress {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 40px;
    position: relative;
}

.form-progress::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 50%;
    right: 50%;
    height: 2px;
    background: #e5e7eb;
    z-index: 1;
    transition: all 0.3s ease;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    position: relative;
    z-index: 2;
    opacity: 0.5;
    transition: opacity 0.3s ease;
}

.progress-step.active {
    opacity: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.progress-step.active .step-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.step-label {
    font-size: 12px;
    font-weight: 500;
    color: #6b7280;
    text-align: center;
    white-space: nowrap;
}

.progress-step.active .step-label {
    color: #1f2937;
}

/* Form Steps */
.form-step {
    display: none;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-step.active {
    display: block;
}

.step-header {
    padding: 30px 30px 20px 30px;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.step-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.step-header p {
    color: #6b7280;
    margin: 0;
    font-size: 14px;
}

/* Form Elements */
.form-row {
    padding: 20px 30px;
}

.form-group {
    margin-bottom: 20px;
}

/* <CHANGE> Removed duplicate display: flex property */
.form-label {
    display: flex;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
    align-items: center;
    gap: 6px;
}

.required {
    color: #ef4444;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.form-help {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
    display: block;
}

.form-error {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Photo Upload */
.photo-upload-section {
    margin-top: 12px;
}

.photo-upload-options {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: center;
}

.photo-option-btn {
    flex: 1;
    padding: 16px;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    background: white;
    color: #6b7280;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.photo-option-btn.active {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
    color: #667eea;
}

.photo-option-btn:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
    color: #667eea;
    transform: translateY(-2px);
}

.photo-option-divider {
    color: #6b7280;
    font-weight: 500;
}

.camera-preview {
    margin-top: 20px;
    text-align: center;
}

.camera-preview video {
    width: 100%;
    max-width: 400px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.camera-controls {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-top: 16px;
}

.btn-capture, .btn-cancel {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-capture {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-capture:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    background: #6b7280;
    color: white;
}

.btn-cancel:hover {
    background: #4b5563;
}

.photo-preview {
    margin-top: 20px;
    padding: 20px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: #f9fafb;
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.preview-header h4 {
    margin: 0;
    color: #1f2937;
    font-size: 16px;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 6px;
}

.btn-outline-danger {
    color: #ef4444;
    border: 1px solid #ef4444;
    background: transparent;
}

.btn-outline-danger:hover {
    background: #ef4444;
    color: white;
}

.photo-preview img {
    width: 100%;
    max-width: 300px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.photo-help {
    margin-top: 16px;
    padding: 12px;
    background: #fef3c7;
    border-radius: 8px;
    border-left: 4px solid #f59e0b;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.photo-help i {
    color: #f59e0b;
    font-size: 16px;
    margin-top: 2px;
}

.photo-help span {
    font-size: 13px;
    color: #92400e;
    line-height: 1.5;
}

/* Form Navigation */
.form-navigation {
    padding: 20px 30px 30px 30px;
    display: flex;
    justify-content: space-between;
    gap: 16px;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid transparent;
    cursor: pointer;
    font-size: 14px;
}

.btn-next, .btn-prev, .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.btn-next:hover, .btn-prev:hover, .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-prev {
    background: #6b7280;
}

.btn-prev:hover {
    background: #4b5563;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 40px 0;
    }

    .page-title {
        font-size: 2rem;
    }

    .page-subtitle {
        font-size: 1rem;
    }

    .breadcrumb {
        flex-wrap: wrap;
        justify-content: center;
    }

    .create-form-section {
        padding: 40px 0;
    }

    .form-container {
        padding: 0 16px;
    }

    .form-header {
        margin-bottom: 30px;
    }

    .form-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }

    .form-title h2 {
        font-size: 1.5rem;
    }

    .form-progress {
        gap: 12px;
        margin-bottom: 30px;
    }

    .step-number {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }

    .step-label {
        font-size: 11px;
    }

    .form-row {
        padding: 16px 20px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .photo-upload-options {
        flex-direction: column;
        gap: 12px;
    }

    .photo-option-btn {
        padding: 12px;
    }

    .camera-preview video {
        max-width: 100%;
    }

    .camera-controls {
        flex-direction: column;
        gap: 8px;
    }

    .form-navigation {
        padding: 16px 20px 20px 20px;
        flex-direction: column;
    }

    .btn {
        justify-content: center;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .page-header {
        padding: 30px 0;
    }

    .page-header-content {
        padding: 0 16px;
    }

    .page-title {
        font-size: 1.75rem;
    }

    .page-subtitle {
        font-size: 0.875rem;
    }

    .create-form-section {
        padding: 20px 0;
    }

    .form-container {
        padding: 0 12px;
    }

    .form-header {
        margin-bottom: 20px;
    }

    .form-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .form-title h2 {
        font-size: 1.25rem;
    }

    .form-title p {
        font-size: 0.875rem;
    }

    .form-progress {
        gap: 8px;
        margin-bottom: 20px;
    }

    .step-number {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }

    .step-label {
        font-size: 10px;
    }

    .form-row {
        padding: 12px 16px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-input, .form-select, .form-textarea {
        padding: 10px 12px;
        font-size: 13px;
    }

    .photo-upload-options {
        gap: 8px;
    }

    .photo-option-btn {
        padding: 10px;
        font-size: 13px;
    }

    .photo-preview {
        padding: 16px;
    }

    .photo-preview img {
        max-width: 250px;
    }

    .photo-help {
        padding: 10px;
        font-size: 12px;
    }

    .form-navigation {
        padding: 12px 16px 16px 16px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 13px;
    }
}
</style>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1 class="page-title">Buat Laporan Baru</h1>
            <p class="page-subtitle">Laporkan kerusakan fasilitas universitas dengan lengkap dan jelas</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Kelola Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Buat Laporan Baru</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Create Form Section -->
<section class="create-form-section">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="form-title">
                    <h2>Formulir Laporan Kerusakan</h2>
                    <p>Isi data laporan dengan lengkap untuk memudahkan penanganan</p>
                </div>
            </div>

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="modern-form">
                @csrf

                <!-- Progress Indicator -->
                <div class="form-progress">
                    <div class="progress-step active" data-step="1">
                        <span class="step-number">1</span>
                        <span class="step-label">Informasi Dasar</span>
                    </div>
                    <div class="progress-step" data-step="2">
                        <span class="step-number">2</span>
                        <span class="step-label">Detail Lokasi</span>
                    </div>
                    <div class="progress-step" data-step="3">
                        <span class="step-number">3</span>
                        <span class="step-label">Dokumentasi</span>
                    </div>
                </div>

                <!-- Step 1: Basic Information -->
                <div class="form-step active" id="step-1">
                    <div class="step-header">
                        <h3><i class="fas fa-info-circle"></i> Informasi Dasar</h3>
                        <p>Berikan informasi utama tentang laporan Anda</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading"></i> Judul Laporan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: AC di Ruang 101 Rusak" required>
                            <div class="form-help">Berikan judul yang jelas dan deskriptif</div>
                            @error('judul')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="kategori_id" class="form-label">
                                <i class="fas fa-tags"></i> Kategori Kerusakan <span class="required">*</span>
                            </label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori Kerusakan</option>
                                <optgroup label="Fasilitas Utama">
                                    <option value="1" {{ old('kategori_id') == '1' ? 'selected' : '' }}>Listrik & Elektronik</option>
                                    <option value="2" {{ old('kategori_id') == '2' ? 'selected' : '' }}>AC & Pendingin</option>
                                    <option value="3" {{ old('kategori_id') == '3' ? 'selected' : '' }}>Penerangan</option>
                                    <option value="4" {{ old('kategori_id') == '4' ? 'selected' : '' }}>Plumbing & Air</option>
                                    <option value="5" {{ old('kategori_id') == '5' ? 'selected' : '' }}>Toilet & Kamar Mandi</option>
                                </optgroup>
                                <optgroup label="Bangunan & Struktur">
                                    <option value="6" {{ old('kategori_id') == '6' ? 'selected' : '' }}>Dinding & Partisi</option>
                                    <option value="7" {{ old('kategori_id') == '7' ? 'selected' : '' }}>Lantai & Karpet</option>
                                    <option value="8" {{ old('kategori_id') == '8' ? 'selected' : '' }}>Atap & Ceiling</option>
                                    <option value="9" {{ old('kategori_id') == '9' ? 'selected' : '' }}>Pintu & Jendela</option>
                                    <option value="10" {{ old('kategori_id') == '10' ? 'selected' : '' }}>Lift & Elevator</option>
                                </optgroup>
                                <optgroup label="Perabotan & Equipment">
                                    <option value="11" {{ old('kategori_id') == '11' ? 'selected' : '' }}>Meja & Kursi</option>
                                    <option value="12" {{ old('kategori_id') == '12' ? 'selected' : '' }}>Lemari & Rak</option>
                                    <option value="13" {{ old('kategori_id') == '13' ? 'selected' : '' }}>Proyektor & AV</option>
                                    <option value="14" {{ old('kategori_id') == '14' ? 'selected' : '' }}>Komputer & IT</option>
                                    <option value="15" {{ old('kategori_id') == '15' ? 'selected' : '' }}>Laboratorium</option>
                                </optgroup>
                                <optgroup label="Kebersihan & Lingkungan">
                                    <option value="16" {{ old('kategori_id') == '16' ? 'selected' : '' }}>Kebersihan Ruangan</option>
                                    <option value="17" {{ old('kategori_id') == '17' ? 'selected' : '' }}>Sampah & Limbah</option>
                                    <option value="18" {{ old('kategori_id') == '18' ? 'selected' : '' }}>Taman & Lanskap</option>
                                    <option value="19" {{ old('kategori_id') == '19' ? 'selected' : '' }}>Parkir & Area Luar</option>
                                </optgroup>
                                <optgroup label="Keamanan & Safety">
                                    <option value="20" {{ old('kategori_id') == '20' ? 'selected' : '' }}>Sistem Keamanan</option>
                                    <option value="21" {{ old('kategori_id') == '21' ? 'selected' : '' }}>Penerangan Darurat</option>
                                    <option value="22" {{ old('kategori_id') == '22' ? 'selected' : '' }}>APAR & Fire Safety</option>
                                    <option value="23" {{ old('kategori_id') == '23' ? 'selected' : '' }}>Aksesibilitas</option>
                                    <option value="24" {{ old('kategori_id') == '24' ? 'selected' : '' }}>Kesehatan & Sanitasi</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="25" {{ old('kategori_id') == '25' ? 'selected' : '' }}>Gangguan Suara</option>
                                    <option value="26" {{ old('kategori_id') == '26' ? 'selected' : '' }}>Hama & Pest</option>
                                    <option value="27" {{ old('kategori_id') == '27' ? 'selected' : '' }}>Lainnya</option>
                                </optgroup>
                            </select>
                            <div class="form-help">Pilih kategori yang sesuai dengan jenis kerusakan</div>
                            @error('kategori_id')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-next" onclick="nextStep(1)">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                    </div>

                </div>

                <!-- Step 2: Detail Lokasi -->
                <div class="form-step" id="step-2">

                    <div class="step-header">
                        <h3><i class="fas fa-map-marker-alt"></i> Detail Lokasi</h3>
                        <p>Berikan lokasi dan deskripsi detail kerusakan</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="lokasi" class="form-label">
                                <i class="fas fa-map-pin"></i> Lokasi Kerusakan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung A, Lantai 1, Ruang 101" required>
                            <div class="form-help">Sebutkan gedung, lantai, dan ruangan secara spesifik</div>
                            @error('lokasi')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">
                                <i class="fas fa-align-left"></i> Deskripsi Kerusakan <span class="required">*</span>
                            </label>
                            <textarea class="form-textarea @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" placeholder="Jelaskan detail kerusakan yang terjadi..." required>{{ old('deskripsi') }}</textarea>
                            <div class="form-help">Berikan deskripsi yang jelas dan detail tentang kondisi kerusakan</div>
                            @error('deskripsi')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-prev" onclick="prevStep(2)"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                        <button type="button" class="btn btn-next" onclick="nextStep(2)">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                    </div>

                </div>

                <!-- Step 3: Dokumentasi -->
                <div class="form-step" id="step-3">

                    <div class="step-header">
                        <h3><i class="fas fa-camera"></i> Dokumentasi</h3>
                        <p>Upload foto kerusakan untuk dokumentasi</p>
                    </div>

                    <div class="form-row">
                        <div class="photo-upload-section">

                            <div class="photo-upload-options">
                                <div class="photo-option-btn" id="file-btn" onclick="document.getElementById('foto').click()">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload dari Galeri</span>
                                </div>

                                <span class="photo-option-divider">atau</span>

                                <div class="photo-option-btn active" id="camera-btn">
                                    <i class="fas fa-camera"></i>
                                    <span>Ambil Foto</span>
                                </div>
                            </div>

                            <!-- <CHANGE> Added proper event listener for file input -->
                            <input type="file" id="foto" name="foto" accept="image/*" style="display: none;">

                            <div class="camera-preview" id="camera-preview" style="display: none;">
                                <video id="video" autoplay></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                                <div class="camera-controls">
                                    <button type="button" class="btn-capture" id="capture-btn">Ambil Foto</button>
                                    <button type="button" class="btn-cancel" id="cancel-camera">Batal</button>
                                </div>
                            </div>

                            <div class="photo-preview" id="photo-preview" style="display: none;">
                                <div class="preview-header">
                                    <h4>Pratinjau Foto</h4>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="remove-photo">Hapus</button>
                                </div>
                                <img id="preview-image" src="/placeholder.svg" alt="Preview">
                                <div class="photo-help">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Pastikan foto menunjukkan kerusakan dengan jelas</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-prev" onclick="prevStep(3)"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                        <button type="submit" class="btn btn-submit">Kirim Laporan <i class="fas fa-paper-plane"></i></button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</section>

<!-- <CHANGE> Added proper closing </script> tag and improved event listeners -->
<script>
let currentStep = 1;
let stream = null;

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(stepEl => {
        stepEl.classList.remove('active');
    });

    // Show current step
    document.getElementById(`step-${step}`).classList.add('active');

    // Update progress indicators
    document.querySelectorAll('.progress-step').forEach((progressEl, index) => {
        if (index + 1 <= step) {
            progressEl.classList.add('active');
        } else {
            progressEl.classList.remove('active');
        }
    });

    currentStep = step;
}

function nextStep(current) {
    if (validateStep(current)) {
        showStep(current + 1);
    }
}

function prevStep(current) {
    showStep(current - 1);
}

function validateStep(step) {
    let isValid = true;

    if (step === 1) {
        const judul = document.getElementById('judul').value.trim();
        const kategori = document.getElementById('kategori_id').value;

        if (!judul) {
            showFieldError('judul', 'Judul laporan wajib diisi');
            isValid = false;
        } else {
            clearFieldError('judul');
        }

        if (!kategori) {
            showFieldError('kategori_id', 'Kategori wajib dipilih');
            isValid = false;
        } else {
            clearFieldError('kategori_id');
        }
    } else if (step === 2) {
        const lokasi = document.getElementById('lokasi').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();

        if (!lokasi) {
            showFieldError('lokasi', 'Lokasi wajib diisi');
            isValid = false;
        } else {
            clearFieldError('lokasi');
        }

        if (!deskripsi) {
            showFieldError('deskripsi', 'Deskripsi wajib diisi');
            isValid = false;
        } else {
            clearFieldError('deskripsi');
        }
    } else if (step === 3) {
        // <CHANGE> Added validation for photo in step 3
        const fotoInput = document.getElementById('foto');
        if (!fotoInput.files || fotoInput.files.length === 0) {
            showFieldError('foto', 'Foto wajib diupload');
            isValid = false;
        } else {
            clearFieldError('foto');
        }
    }

    return isValid;
}

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const errorDiv = field.parentElement.querySelector('.form-error') || document.createElement('div');

    errorDiv.className = 'form-error';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;

    if (!field.parentElement.querySelector('.form-error')) {
        field.parentElement.appendChild(errorDiv);
    }

    field.classList.add('is-invalid');
    field.focus();
}

// <CHANGE> Added function to clear field errors when user fixes input
function clearFieldError(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const errorDiv = field.parentElement.querySelector('.form-error');
    if (errorDiv) {
        errorDiv.remove();
    }

    field.classList.remove('is-invalid');
}

// Camera functionality
document.getElementById('camera-btn').addEventListener('click', function() {
    startCamera();
});

document.getElementById('cancel-camera').addEventListener('click', function() {
    stopCamera();
});

document.getElementById('capture-btn').addEventListener('click', function() {
    capturePhoto();
});

document.getElementById('remove-photo').addEventListener('click', function() {
    removePhoto();
});

// <CHANGE> Added event listener for file input
document.getElementById('foto').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            showPhotoPreview(event.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' }
        });

        const video = document.getElementById('video');
        video.srcObject = stream;
        document.getElementById('camera-preview').style.display = 'block';
        document.getElementById('camera-btn').classList.remove('active');

    } catch (error) {
        alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
        console.error('Camera error:', error);
    }
}

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    document.getElementById('camera-preview').style.display = 'none';
    document.getElementById('camera-btn').classList.add('active');
}

function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const fotoInput = document.getElementById('foto');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');

    // Flip horizontally to correct mirroring
    ctx.scale(-1, 1);
    ctx.drawImage(video, -canvas.width, 0);

    canvas.toBlob(function(blob) {
        const file = new File([blob], `laporan-${Date.now()}.jpg`, { type: 'image/jpeg' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fotoInput.files = dataTransfer.files;

        // Show preview
        showPhotoPreview(canvas.toDataURL('image/jpeg'));

        stopCamera();
    });
}

function showPhotoPreview(imageSrc) {
    document.getElementById('preview-image').src = imageSrc;
    document.getElementById('photo-preview').style.display = 'block';
}

function removePhoto() {
    document.getElementById('foto').value = '';
    document.getElementById('photo-preview').style.display = 'none';
    document.getElementById('camera-btn').classList.add('active');
}
</script>
@endsection