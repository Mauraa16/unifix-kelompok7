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

/* Edit Form Section */
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

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
    display: flex;
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

/* Current Photo Preview */
.current-photo-preview {
    margin-bottom: 20px;
    padding: 20px;
    background: #f9fafb;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
}

.current-photo-preview h4 {
    margin: 0 0 16px 0;
    color: #1f2937;
    font-size: 16px;
    font-weight: 600;
}

.current-photo {
    width: 100%;
    max-width: 300px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

.btn-prev, .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.btn-prev:hover, .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
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

    .form-row {
        padding: 16px 20px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .current-photo-preview {
        padding: 16px;
    }

    .current-photo {
        max-width: 250px;
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

    .form-row {
        padding: 12px 16px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-label {
        font-size: 13px;
    }

    .form-input, .form-select, .form-textarea {
        padding: 10px 12px;
        font-size: 13px;
    }

    .current-photo-preview {
        padding: 12px;
    }

    .current-photo {
        max-width: 200px;
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
            <h1 class="page-title">Edit Laporan</h1>
            <p class="page-subtitle">Perbarui informasi laporan kerusakan fasilitas</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Kelola Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Laporan</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Edit Form Section -->
<section class="create-form-section">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="form-title">
                    <h2>Formulir Edit Laporan</h2>
                    <p>Perbarui data laporan dengan lengkap untuk memudahkan penanganan</p>
                </div>
            </div>

            <form action="{{ route('laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data" class="modern-form">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="form-step active">
                    <div class="step-header">
                        <h3><i class="fas fa-info-circle"></i> Informasi Dasar</h3>
                        <p>Perbarui informasi utama tentang laporan Anda</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading"></i> Judul Laporan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $laporan->judul) }}" placeholder="Contoh: AC di Ruang 101 Rusak" required>
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
                                @foreach($kategori as $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_id', $laporan->kategori_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-help">Pilih kategori yang sesuai dengan jenis kerusakan</div>
                            @error('kategori_id')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="lokasi" class="form-label">
                                <i class="fas fa-building"></i> Lokasi (Gedung/Fakultas) <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $laporan->lokasi) }}" placeholder="Contoh: Gedung A Fakultas Teknik Lantai 2" required>
                            <div class="form-help">Sebutkan gedung, fakultas, lantai, dan ruangan jika memungkinkan</div>
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
                                <i class="fas fa-align-left"></i> Deskripsi Lengkap <span class="required">*</span>
                            </label>
                            <textarea class="form-textarea @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan secara detail kondisi kerusakan, kapan terlihat pertama kali, dan dampak yang ditimbulkan..." required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                            <div class="form-help">Berikan deskripsi yang detail untuk memudahkan pemahaman teknisi</div>
                            @error('deskripsi')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Photo Upload Section -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-image"></i> Foto Kerusakan
                            </label>
                            @if($laporan->foto)
                                <div class="current-photo-preview">
                                    <h4>Foto Saat Ini:</h4>
                                    <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan Saat Ini" class="current-photo">
                                </div>
                            @endif
                            <div class="photo-upload-section">
                                <div class="photo-upload-options">
                                    <button type="button" class="photo-option-btn active" id="camera-btn">
                                        <i class="fas fa-camera"></i>
                                        <span>Ambil dari Kamera</span>
                                    </button>
                                    <div class="photo-option-divider">atau</div>
                                    <label for="foto" class="photo-option-btn">
                                        <i class="fas fa-upload"></i>
                                        <span>Upload File</span>
                                        <input type="file" id="foto" name="foto" accept="image/*" style="display: none;">
                                    </label>
                                </div>

                                <div class="camera-preview" id="camera-preview" style="display: none;">
                                    <video id="video" autoplay playsinline></video>
                                    <div class="camera-controls">
                                        <button type="button" class="btn btn-capture" id="capture-btn">
                                            <i class="fas fa-camera"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-cancel" id="cancel-camera">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                    </div>
                                </div>

                                <canvas id="canvas" style="display: none;"></canvas>

                                <div class="photo-preview" id="photo-preview" style="display: none;">
                                    <div class="preview-header">
                                        <h4>Pratinjau Foto Baru</h4>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="remove-photo">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                    <img id="preview-image" src="" alt="Preview">
                                </div>

                                <div class="photo-help">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>Biarkan kosong jika tidak ingin mengubah foto. Ambil foto dari berbagai sudut untuk memberikan gambaran yang lebih lengkap</span>
                                </div>
                            </div>
                            @error('foto')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-navigation">
                        <a href="{{ route('laporan.index') }}" class="btn btn-prev">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Daftar Laporan</span>
                        </a>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save"></i>
                            <span>Update Laporan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
let stream = null;

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

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' } // Use back camera if available
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
    canvas.getContext('2d').drawImage(video, 0, 0);

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

// File upload preview
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            showPhotoPreview(e.target.result);
            document.getElementById('camera-btn').classList.remove('active');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
