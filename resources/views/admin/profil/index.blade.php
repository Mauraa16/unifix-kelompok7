@extends('layouts.app')

@section('content')
@php 
    // Siapkan Cache Buster
    $cacheBuster = \Carbon\Carbon::parse($user->updated_at)->timestamp;

    // URL foto profil dari database
    $fotoProfilUrl = $user->foto_profil 
        ? asset('storage/' . $user->foto_profil) . '?v=' . $cacheBuster 
        : '';
    
    // Tentukan apakah user memiliki foto profil
    $hasPhoto = !empty($user->foto_profil);
@endphp

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Profil Administrator</h1>
                <p class="text-gray-600 mt-1">Kelola informasi akun dan data pribadi Anda.</p>
            </div>
            <div class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-bold flex items-center shadow-sm">
                <i class="fas fa-shield-alt mr-2"></i> Role: Administrator
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                
                {{-- CARD PROFIL KIRI --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group">
                    <div class="h-28 bg-gradient-to-r from-purple-600 to-indigo-700"></div>
                    
                    <div class="text-center -mt-14 pb-6">
                        {{-- AREA FOTO PROFIL DENGAN ICON AKSI --}}
                        <div class="w-28 h-28 mx-auto relative cursor-pointer group/photo" onclick="openPhotoActionModal(event)">
                            <div class="w-full h-full mx-auto bg-white rounded-full p-1.5 shadow-lg">
                                
                                {{-- TAMPILAN FOTO UTAMA --}}
                                @if ($hasPhoto)
                                    <img src="{{ $fotoProfilUrl }}" 
                                        alt="Foto Profil" 
                                        class="w-full h-full object-cover rounded-full border border-purple-100 transition duration-300"
                                        id="current-card-photo" >
                                @else
                                    <div class="w-full h-full rounded-full bg-purple-50 flex items-center justify-center text-purple-600 text-4xl font-bold border border-purple-100" id="current-card-photo-default">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- IKON KAMERA KECIL DI POJOK BAWAH (Pemicu Modal Aksi) --}}
                                <div id="camera-icon-badge" 
                                    class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-white text-gray-700 flex items-center justify-center border-2 border-purple-500 
                                    shadow-lg transition-all duration-200 
                                    group-hover/photo:bg-purple-500 group-hover/photo:text-white group-hover/photo:scale-105">
                                    <i class="fas fa-camera text-xs"></i>
                                </div>
                            </div>
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-800 mt-4">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm font-medium">{{ $user->email }}</p>
                    </div>
                </div>

                {{-- Ringkasan Sistem --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Ringkasan Sistem</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-users text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Total User</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ $totalUsers }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Laporan</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ $totalLaporan }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Selesai</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ $totalLaporanSelesai }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Edit Informasi Akun</h2>
                            <p class="text-sm text-gray-500 mt-1">Perbarui detail profil Anda di sini.</p>
                        </div>
                    </div>

                    {{-- Notifikasi Sukses --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-md flex items-center shadow-sm">
                            <i class="fas fa-check-circle mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    {{-- Notifikasi Error --}}
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-md flex items-center shadow-sm">
                            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="name" id="name" 
                                            value="{{ old('name', $user->name) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition outline-none"
                                            placeholder="Nama lengkap Anda"
                                            required>
                                </div>
                                @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email" id="email" 
                                            value="{{ old('email', $user->email) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition outline-none"
                                            placeholder="email@contoh.com"
                                            required>
                                </div>
                                @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Role Akun</label>
                                <div class="w-full pl-4 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-500 flex items-center cursor-not-allowed select-none">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                                    <span>Administrator</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i> Role akun tidak dapat diubah secara mandiri.
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL-MODAL DITAMBAHKAN DI SINI (COPY DARI PROFIL MAHASISWA) --}}

{{-- MODAL AKSI FOTO --}}
<div id="photo-action-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[80] hidden" onclick="closePhotoActionModal()">
    <div class="relative bg-white rounded-xl shadow-2xl max-w-xs w-full m-4 p-4" onclick="event.stopPropagation()">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Opsi Foto Profil</h3>
        
        <ul class="space-y-2">
            {{-- GANTI/PILIH FOTO --}}
            <li>
                <button type="button" onclick="triggerFileInput()" id="change-select-photo-button"
                        class="w-full flex items-center px-3 py-2 text-purple-600 font-medium rounded-lg hover:bg-purple-50 transition text-sm">
                    <i class="fas fa-upload w-5 mr-3"></i> 
                    {{ $hasPhoto ? 'Ganti Foto' : 'Pilih Foto Profil' }}
                </button>
            </li>
            
            {{-- HAPUS FOTO --}}
            <li>
                <button type="button" id="delete-photo-button" 
                        onclick="openDeleteConfirmModal(); closePhotoActionModal();"
                        class="w-full flex items-center px-3 py-2 text-red-600 font-medium rounded-lg hover:bg-red-50 transition text-sm {{ $hasPhoto ? '' : 'hidden' }}">
                    <i class="fas fa-trash-alt w-5 mr-3"></i> 
                    Hapus Foto
                </button>
            </li>
            {{-- LIHAT FOTO --}}
            <li>
                <button type="button" id="view-photo-button"
                        onclick="openPopupModal(); closePhotoActionModal();"
                        class="w-full flex items-center px-3 py-2 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition text-sm {{ $hasPhoto ? '' : 'hidden' }}">
                    <i class="fas fa-eye w-5 mr-3"></i> 
                    Lihat Foto Saat Ini
                </button>
            </li>
        </ul>
        
        <button type="button" 
                onclick="closePhotoActionModal()" 
                class="w-full mt-4 px-4 py-2 text-gray-600 font-medium rounded-lg hover:bg-gray-100 transition text-sm">
            Batal
        </button>
    </div>
</div>

{{-- MODAL BARU: KONFIRMASI PREVIEW FOTO + FORM UPLOAD --}}
<div id="photo-preview-confirm-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[85] hidden" onclick="closePhotoPreviewConfirmModal()">
    <div class="relative bg-white rounded-xl shadow-2xl max-w-sm w-full m-4 p-6" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 text-center">
            Konfirmasi Foto Profil Baru
        </h3>
        
        <div class="flex justify-center mb-4">
            {{-- PRATINJAU DENGAN BENTUK PERSEGI PANJANG --}}
            <img id="preview-image-source" src="" class="max-w-full max-h-[200px] object-contain rounded-lg border-2 border-purple-200 shadow-md" alt="Preview Foto Baru">
        </div>

        <p class="text-gray-600 mb-6 text-center text-sm">
            Anda yakin ingin menggunakan gambar ini sebagai foto profil?
        </p>

        {{-- FORM UNTUK MENGUPLOAD FOTO --}}
        <form id="photo-upload-form" action="{{ route('admin.profil.upload_photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Input ini akan diisi oleh JavaScript dari file sementara --}}
            <input type="file" id="modal_photo_input" accept="image/*" name="foto_profil" class="hidden"> 
            
            <button type="submit" 
                    id="confirm-upload-button"
                    class="w-full px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition shadow-md text-sm mb-2">
                Simpan Foto Profil Baru
            </button>
        </form>
        
        <button type="button" 
                onclick="closePhotoPreviewConfirmModal()" 
                class="w-full px-4 py-2 text-gray-600 font-medium rounded-lg border border-gray-300 hover:bg-gray-100 transition text-sm">
            Batal
        </button>
    </div>
</div>


{{-- MODAL POP-UP DETAIL FOTO --}}
<div id="popup-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[70] hidden" onclick="closePopupModal(event)">
    <div class="relative bg-white rounded-lg shadow-xl overflow-hidden max-w-lg w-full m-4 transform transition-all duration-300 ease-out" onclick="event.stopPropagation()">
        <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 transition text-2xl p-1 z-10" onclick="closePopupModal(event)">
            &times;
        </button>
        <div class="p-6">
            <h3 class="text-lg font-bold mb-4 border-b pb-2">Tampilan Penuh</h3>
            <div class="flex justify-center items-center">
                <img id="modal-image-source" 
                    src="{{ $hasPhoto ? $fotoProfilUrl : '' }}" 
                    class="max-w-full max-h-[80vh] object-contain rounded-lg" 
                    alt="Foto Profil Detail">
            </div>
        </div>
    </div>
</div>


{{-- MODAL KONFIRMASI HAPUS FOTO --}}
<div id="delete-confirm-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[90] hidden" onclick="closeDeleteConfirmModal()">
    <div class="relative bg-white rounded-xl shadow-2xl max-w-sm w-full m-4 p-6 text-center" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Konfirmasi Hapus
        </h3>
        <p class="text-gray-600 mb-6">Anda yakin ingin menghapus foto profil saat ini? Foto akan digantikan oleh inisial nama Anda.</p>
        
        <form id="delete-photo-form" action="{{ route('admin.profil.delete_photo') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="w-full px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition shadow-md">
                Ya, Hapus Foto Saya
            </button>
        </form>
        
        <button type="button" 
                onclick="closeDeleteConfirmModal()" 
                class="w-full mt-2 px-4 py-2 text-gray-600 font-medium rounded-lg hover:bg-gray-100 transition text-sm">
            Batal
        </button>
    </div>
</div>


{{-- SCRIPT INTERAKSI --}}
<script>
    const userName = "{{ $user->name }}";
    // Input file yang ada di dalam modal konfirmasi (form upload)
    const modalFileInput = document.getElementById('modal_photo_input'); 
    const modalImage = document.getElementById('modal-image-source');
    
    // Elemen tampilan utama
    const cardPhoto = document.getElementById('current-card-photo');
    const cardPhotoDefault = document.getElementById('current-card-photo-default');
    const deleteBtnModal = document.getElementById('delete-photo-button');
    const viewBtnModal = document.getElementById('view-photo-button');
    const changeSelectBtnText = document.getElementById('change-select-photo-button');
    
    // Elemen modal preview baru
    const previewConfirmModal = document.getElementById('photo-preview-confirm-modal');
    const previewImage = document.getElementById('preview-image-source');
    const uploadForm = document.getElementById('photo-upload-form');
    
    let hasCurrentPhoto = {{ $hasPhoto ? 'true' : 'false' }};
    
    // --- UTILITY FUNGSI PREVIEW/UPDATE TAMPILAN ---
    
    function updateCardDisplay(src = null, isNewPhoto = false) {
        if (src && isNewPhoto) {
            hasCurrentPhoto = true;
            
            let imgElement = document.getElementById('current-card-photo');
            if (!imgElement) {
                imgElement = document.createElement('img');
                imgElement.id = 'current-card-photo';
                imgElement.alt = 'Foto Profil';
                imgElement.classList.add('w-full', 'h-full', 'object-cover', 'rounded-full', 'border', 'border-purple-100', 'transition', 'duration-300'); // Class disesuaikan dengan admin
                cardPhotoDefault.parentNode.insertBefore(imgElement, cardPhotoDefault);
            }
            imgElement.src = src; 
            imgElement.classList.remove('hidden');
            if (cardPhotoDefault) cardPhotoDefault.classList.add('hidden'); 
 
            changeSelectBtnText.innerHTML = '<i class="fas fa-upload w-5 mr-3"></i> Ganti Foto';
            deleteBtnModal.classList.remove('hidden');
            viewBtnModal.classList.remove('hidden');

            modalImage.src = src;

        } else if (!src) {
            hasCurrentPhoto = false;

            let imgElement = document.getElementById('current-card-photo');
            if (imgElement) imgElement.classList.add('hidden'); 
            if (cardPhotoDefault) cardPhotoDefault.classList.remove('hidden'); 

            changeSelectBtnText.innerHTML = '<i class="fas fa-upload w-5 mr-3"></i> Pilih Foto Profil';
            deleteBtnModal.classList.add('hidden');
            viewBtnModal.classList.add('hidden');

            modalImage.src = '';
        }
    }

    const handleFileInputChange = (file) => {
        if (file) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            modalFileInput.files = dataTransfer.files; 
            
            // Logika Preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const src = e.target.result;
                previewImage.src = src;
                openPhotoPreviewConfirmModal();
            };
            reader.readAsDataURL(file);
        } else {
            modalFileInput.value = '';
        }
    };

    // Membuat input file sementara yang tersembunyi
    function triggerFileInput() {
        closePhotoActionModal(); 
        
        const tempFileInput = document.createElement('input');
        tempFileInput.type = 'file';
        tempFileInput.accept = 'image/*';
        tempFileInput.style.display = 'none';

        tempFileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                handleFileInputChange(file);
            }
            tempFileInput.remove();
        });
        
        document.body.appendChild(tempFileInput);
        tempFileInput.click();
    }

    // --- FUNGSI MODAL ---
    function openPhotoPreviewConfirmModal() {
        previewConfirmModal.classList.remove('hidden');
    }

    function closePhotoPreviewConfirmModal() {
        modalFileInput.value = ''; 
        previewConfirmModal.classList.add('hidden');
    }
    
    function openPhotoActionModal(event) {
        document.getElementById('photo-action-modal').classList.remove('hidden');
    }

    function closePhotoActionModal() {
        document.getElementById('photo-action-modal').classList.add('hidden');
    }
    
    function openPopupModal() {
        if (hasCurrentPhoto && modalImage.src && modalImage.src.length > 0) {
            document.getElementById('popup-modal').classList.remove('hidden');
        } else {
            alert('Anda belum memiliki foto profil untuk dilihat.');
        }
    }

    function closePopupModal(event) {
        const modal = document.getElementById('popup-modal');
        if (event && (event.target === modal || event.target.closest('button'))) {
              modal.classList.add('hidden');
        }
    }

    function openDeleteConfirmModal() {
        document.getElementById('delete-confirm-modal').classList.remove('hidden');
    }

    function closeDeleteConfirmModal() {
        document.getElementById('delete-confirm-modal').classList.add('hidden');
    }

    // --- LOGIKA SETELAH PERUBAHAN (DARI PHP SESSION) ---
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada notifikasi untuk update tampilan setelah berhasil upload/delete
            const successMessage = '{{ session('success') }}';
            
            if (successMessage.includes('Foto profil berhasil diunggah')) {
            
            }
            
            if (successMessage.includes('Foto profil berhasil dihapus')) {
                updateCardDisplay(null, false);
            }
        });
    @endif
</script>

@endsection