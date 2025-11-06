@extends('layouts.app')

@section('content')
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
                                @foreach($kategori as $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
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

                    <div class="form-navigation">
                        <button type="button" class="btn btn-next" onclick="nextStep(1)">
                            <i class="fas fa-arrow-right"></i>
                            <span>Lanjut ke Langkah 2</span>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Location Details -->
                <div class="form-step" id="step-2">
                    <div class="step-header">
                        <h3><i class="fas fa-map-marker-alt"></i> Detail Lokasi</h3>
                        <p>Tentukan lokasi kerusakan dengan spesifik</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="lokasi" class="form-label">
                                <i class="fas fa-building"></i> Lokasi (Gedung/Fakultas) <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung A Fakultas Teknik Lantai 2" required>
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
                            <textarea class="form-textarea @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan secara detail kondisi kerusakan, kapan terlihat pertama kali, dan dampak yang ditimbulkan..." required>{{ old('deskripsi') }}</textarea>
                            <div class="form-help">Berikan deskripsi yang detail untuk memudahkan pemahaman teknisi</div>
                            @error('deskripsi')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-prev" onclick="prevStep(2)">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Langkah 1</span>
                        </button>
                        <button type="button" class="btn btn-next" onclick="nextStep(2)">
                            <span>Lanjut ke Langkah 3</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Documentation -->
                <div class="form-step" id="step-3">
                    <div class="step-header">
                        <h3><i class="fas fa-camera"></i> Dokumentasi</h3>
                        <p>Lampirkan foto untuk melengkapi laporan</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-image"></i> Foto Kerusakan
                            </label>
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
                                        <input type="file" id="foto" name="foto" accept="image/*" capture="environment" style="display: none;">
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
                                        <h4>Pratinjau Foto</h4>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="remove-photo">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                    <img id="preview-image" src="" alt="Preview">
                                </div>

                                <div class="photo-help">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>Tips: Ambil foto dari berbagai sudut untuk memberikan gambaran yang lebih lengkap</span>
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
                        <button type="button" class="btn btn-prev" onclick="prevStep(3)">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Langkah 2</span>
                        </button>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Laporan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

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
        }

        if (!kategori) {
            showFieldError('kategori_id', 'Kategori wajib dipilih');
            isValid = false;
        }
    } else if (step === 2) {
        const lokasi = document.getElementById('lokasi').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();

        if (!lokasi) {
            showFieldError('lokasi', 'Lokasi wajib diisi');
            isValid = false;
        }

        if (!deskripsi) {
            showFieldError('deskripsi', 'Deskripsi wajib diisi');
            isValid = false;
        }
    }

    return isValid;
}

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = field.parentElement.querySelector('.form-error') || document.createElement('div');

    errorDiv.className = 'form-error';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;

    if (!field.parentElement.querySelector('.form-error')) {
        field.parentElement.appendChild(errorDiv);
    }

    field.classList.add('is-invalid');
    field.focus();
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

// Initialize first step
document.addEventListener('DOMContentLoaded', function() {
    showStep(1);
});
</script>
@endsection
