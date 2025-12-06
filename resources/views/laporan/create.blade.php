@extends('layouts.app')

@section('content')
<style>
/* ==== GAYA KHUSUS HALAMAN INI ==== */
.create-page-wrapper {
    background: #f8fafc;
    min-height: 100vh;
    padding-bottom: 60px;
}

/* ==== HEADER HALAMAN (Gradasi Ungu) ==== */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 50px 0 80px; /* Padding bawah besar agar menumpuk dengan form */
    text-align: center;
    position: relative;
    border-radius: 0 0 30px 30px; /* Lengkungan di bawah */
    margin-bottom: -50px; /* Efek overlap */
    z-index: 1;
    /* HAPUS SEMUA EFEK BACKGROUND GAMBAR/HITAM DI SINI */
}

.page-header h1 {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.page-header p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 20px;
}

/* ==== KARTU FORMULIR ==== */
.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    max-width: 850px;
    margin: 0 auto;
    position: relative;
    z-index: 2; /* Agar tampil di atas header */
    overflow: hidden;
}

/* ==== PROGRESS BAR (Langkah 1-2-3) ==== */
.form-progress {
    display: flex;
    justify-content: space-between;
    padding: 30px 50px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    flex: 1;
}

.progress-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 15px;
    left: 50%;
    width: 100%;
    height: 2px;
    background: #e5e7eb;
    z-index: -1;
}

.progress-step.active:not(:last-child)::after {
    background: #667eea;
}

.step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 8px;
    transition: all 0.3s;
}

.progress-step.active .step-circle {
    background: #667eea;
    color: white;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
}

.step-label {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
}

.progress-step.active .step-label {
    color: #4b5563;
    font-weight: 600;
}

/* ==== ISI FORMULIR ==== */
.form-content {
    padding: 40px 50px;
}

.form-step {
    display: none;
    animation: fadeIn 0.4s ease;
}

.form-step.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
}

.form-label i {
    color: #667eea;
    margin-right: 6px;
    width: 16px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* ==== AREA UPLOAD FOTO ==== */
.upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    background: #f9fafb;
}

.upload-area:hover, .upload-area.dragover {
    border-color: #667eea;
    background: #eff6ff;
}

.upload-icon {
    font-size: 48px;
    color: #9ca3af;
    margin-bottom: 16px;
}

.upload-text h4 {
    margin: 0 0 4px;
    color: #374151;
}

.upload-text p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.preview-container {
    margin-top: 20px;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    display: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.preview-image {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
    display: block;
}

.remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}

.remove-btn:hover {
    transform: scale(1.1);
}

/* ==== BAGIAN KAMERA ==== */
.camera-options {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
}

.option-btn {
    flex: 1;
    padding: 15px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: 0.2s;
    font-weight: 500;
    color: #4b5563;
}

.option-btn:hover, .option-btn.active {
    border-color: #667eea;
    background: #eff6ff;
    color: #667eea;
}

.camera-stream-container {
    display: none;
    margin-top: 20px;
    text-align: center;
    background: black;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}

#video {
    width: 100%;
    max-height: 400px;
}

.camera-controls {
    padding: 15px;
    background: rgba(0,0,0,0.8);
    display: flex;
    justify-content: center;
    gap: 15px;
}

/* ==== TOMBOL AKSI (Navigasi Form) ==== */
.form-actions {
    display: flex;
    justify-content: space-between;
    padding: 20px 50px 40px;
    border-top: 1px solid #f3f4f6;
    background: #fff;
}

.btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
    font-size: 0.95rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    transform: translateY(-2px);
}

.btn-secondary {
    background: #e5e7eb;
    color: #374151;
}

.btn-secondary:hover {
    background: #d1d5db;
}

/* Responsive (Tampilan HP) */
@media (max-width: 768px) {
    .form-card { border-radius: 0; box-shadow: none; }
    .page-header { border-radius: 0; margin-bottom: 0; padding-bottom: 40px; }
    .form-progress { padding: 20px; }
    .form-content { padding: 30px 20px; }
    .form-actions { padding: 20px; }
    .step-label { display: none; } /* Sembunyikan label di HP */
}
</style>

<div class="create-page-wrapper">
    <div class="page-header">
        <div class="container mx-auto px-4">
            <h1>Buat Laporan Baru</h1>
            <p>Laporkan kerusakan fasilitas dengan mudah. Isi formulir di bawah ini dengan detail yang lengkap agar dapat segera ditangani.</p>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="form-card">
            
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                @csrf

                <div class="form-progress">
                    <div class="progress-step active" data-step="1">
                        <div class="step-circle">1</div>
                        <span class="step-label">Informasi Utama</span>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="step-circle">2</div>
                        <span class="step-label">Detail Lokasi</span>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="step-circle">3</div>
                        <span class="step-label">Foto Bukti</span>
                    </div>
                </div>

                <div class="form-content">
                    
                    <div class="form-step active" id="step-1">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-heading"></i> Judul Laporan</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: AC Bocor di Ruang 303" value="{{ old('judul') }}" required>
                            @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-tag"></i> Kategori Kerusakan</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                {{-- Gunakan data kategori dari controller jika ada, atau hardcode untuk contoh --}}
                                @if(isset($kategori))
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                @else
                                    <option value="1">Kelistrikan</option>
                                    <option value="2">Pipa & Air</option>
                                    <option value="3">Gedung & Bangunan</option>
                                    <option value="4">Peralatan Kelas</option>
                                    <option value="5">Kebersihan</option>
                                @endif
                            </select>
                            @error('kategori_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-step" id="step-2">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Lokasi Spesifik</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Gedung, Lantai, Nomor Ruangan" value="{{ old('lokasi') }}" required>
                            @error('lokasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-align-left"></i> Deskripsi Masalah</label>
                            <textarea name="deskripsi" class="form-control" placeholder="Jelaskan kerusakan secara detail..." required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-step" id="step-3">
                        <label class="form-label"><i class="fas fa-camera"></i> Bukti Foto</label>
                        
                        <div class="camera-options">
                            <div class="option-btn active" onclick="switchUploadMode('file')">
                                <i class="fas fa-upload"></i> Upload File
                            </div>
                            <div class="option-btn" onclick="switchUploadMode('camera')">
                                <i class="fas fa-camera"></i> Ambil Foto
                            </div>
                        </div>

                        <div id="file-upload-section">
                            <div class="upload-area" onclick="document.getElementById('fotoInput').click()" id="dropZone">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div class="upload-text">
                                    <h4>Klik untuk Upload Foto</h4>
                                    <p>atau tarik file ke sini (Max 2MB)</p>
                                </div>
                                <input type="file" name="foto" id="fotoInput" hidden accept="image/*" onchange="previewImage(this)">
                            </div>
                        </div>

                        <div id="camera-section" style="display: none;">
                            <div class="camera-stream-container" id="cameraStream">
                                <video id="video" autoplay playsinline></video>
                                <canvas id="canvas" style="display:none;"></canvas>
                                <div class="camera-controls">
                                    <button type="button" class="btn btn-primary" onclick="capturePhoto()">
                                        <i class="fas fa-circle"></i> Ambil Gambar
                                    </button>
                                </div>
                            </div>
                            <div class="text-center mt-3" id="cameraStartBtn">
                                <button type="button" class="btn btn-secondary" onclick="startCamera()">
                                    <i class="fas fa-video"></i> Aktifkan Kamera
                                </button>
                            </div>
                        </div>

                        <div class="preview-container" id="previewContainer">
                            <img src="" id="imagePreview" class="preview-image">
                            <button type="button" class="remove-btn" onclick="removeImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                        <i class="fas fa-arrow-left"></i> Sebelumnya
                    </button>
                    <div style="flex: 1;"></div>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                        Selanjutnya <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                        Kirim Laporan <i class="fas fa-paper-plane"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-step');
    
    function showStep(n) {
        // Reset steps
        steps.forEach(step => step.classList.remove('active'));
        steps[n].classList.add('active');

        // Update Buttons
        document.getElementById('prevBtn').style.display = n === 0 ? 'none' : 'inline-flex';
        
        if (n === steps.length - 1) {
            document.getElementById('nextBtn').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'inline-flex';
        } else {
            document.getElementById('nextBtn').style.display = 'inline-flex';
            document.getElementById('submitBtn').style.display = 'none';
        }

        // Update Progress Bar
        progressSteps.forEach((step, index) => {
            if (index <= n) step.classList.add('active');
            else step.classList.remove('active');
        });
    }

    function changeStep(n) {
        // Validasi sederhana sebelum lanjut
        if (n === 1 && !validateCurrentStep()) return;
        
        currentStep += n;
        showStep(currentStep);
    }

    function validateCurrentStep() {
        const currentInputs = steps[currentStep].querySelectorAll('input[required], select[required], textarea[required]');
        let valid = true;
        currentInputs.forEach(input => {
            if (!input.value) {
                input.style.borderColor = '#ef4444'; // Merah jika kosong
                valid = false;
            } else {
                input.style.borderColor = '#e5e7eb'; // Normal jika terisi
            }
        });
        return valid;
    }

    // --- FITUR FOTO ---
    function switchUploadMode(mode) {
        document.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('active'));
        
        if (mode === 'file') {
            document.querySelector('.option-btn:nth-child(1)').classList.add('active');
            document.getElementById('file-upload-section').style.display = 'block';
            document.getElementById('camera-section').style.display = 'none';
            stopCamera();
        } else {
            document.querySelector('.option-btn:nth-child(2)').classList.add('active');
            document.getElementById('file-upload-section').style.display = 'none';
            document.getElementById('camera-section').style.display = 'block';
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('previewContainer').style.display = 'block';
                document.getElementById('dropZone').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        document.getElementById('fotoInput').value = '';
        document.getElementById('previewContainer').style.display = 'none';
        document.getElementById('dropZone').style.display = 'block';
        document.getElementById('imagePreview').src = '';
    }

    // --- FITUR KAMERA (Optional) ---
    let stream;
    
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById('video');
            video.srcObject = stream;
            document.getElementById('cameraStream').style.display = 'block';
            document.getElementById('cameraStartBtn').style.display = 'none';
        } catch (err) {
            alert("Gagal mengakses kamera: " + err);
        }
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            document.getElementById('cameraStream').style.display = 'none';
            document.getElementById('cameraStartBtn').style.display = 'block';
        }
    }

    function capturePhoto() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Convert to file
        canvas.toBlob(blob => {
            const file = new File([blob], "camera_capture.jpg", { type: "image/jpeg" });
            const container = new DataTransfer();
            container.items.add(file);
            document.getElementById('fotoInput').files = container.files;
            
            // Show Preview
            previewImage(document.getElementById('fotoInput'));
            stopCamera();
            switchUploadMode('file'); // Kembali ke tampilan file agar preview terlihat rapi
        }, 'image/jpeg');
    }

    // Initialize first step
    showStep(0);
</script>
@endsection