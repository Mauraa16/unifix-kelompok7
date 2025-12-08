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
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-600 mt-2">Kelola data diri dan pantau aktivitas laporan Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                {{-- CARD PROFIL KIRI --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white text-center">
                        
                        {{-- AREA FOTO PROFIL DENGAN ICON AKSI --}}
                        <div class="w-24 h-24 mx-auto mb-3 relative cursor-pointer group" onclick="openPhotoActionModal(event)">
                            
                            {{-- TAMPILAN FOTO UTAMA --}}
                            @if ($hasPhoto)
                                <img src="{{ $fotoProfilUrl }}" 
                                    alt="Foto Profil" 
                                    class="w-full h-full object-cover rounded-full border-4 border-white/50 shadow-lg transition duration-300"
                                    id="current-card-photo" >
                            @else
                                <div class="w-full h-full rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30" id="current-card-photo-default">
                                    <span class="text-4xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif

                            {{-- IKON KAMERA KECIL DI POJOK BAWAH (Pemicu Modal Aksi) --}}
                            <div id="camera-icon-badge" 
                                class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-white text-gray-700 flex items-center justify-center border-2 border-white 
                                shadow-lg transition-all duration-200 
                                group-hover:bg-blue-500 group-hover:text-white group-hover:scale-105">
                                <i class="fas fa-camera text-xs"></i>
                            </div>
                        </div>
                        
                        <h2 class="font-bold text-lg">{{ $user->name }}</h2>
                        <p class="text-blue-100 text-sm">{{ $user->email }}</p>
                        <span class="inline-block mt-3 px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">Mahasiswa</span>
                    </div>
                </div>

                {{-- Aktivitas Saya --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Aktivitas Saya</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                            <span class="text-gray-600 text-sm">Laporan Diajukan</span>
                            <span class="font-bold text-blue-600">{{ $laporanSaya }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                            <span class="text-gray-600 text-sm">Sedang Diproses</span>
                            <span class="font-bold text-yellow-600">{{ $laporanProses }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Selesai</span>
                            <span class="font-bold text-green-600">{{ $laporanSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Edit Profil</h2>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    {{-- FORM UTAMA: Hanya untuk data non-foto --}}
                    <form action="{{ route('mahasiswa.profil.update') }}" method="POST" id="profile-update-form">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-6">
                            
                            {{-- Form: Nama --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Form: Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL AKSI FOTO --}}
<div id="photo-action-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[80] hidden" onclick="closePhotoActionModal()">
    <div class="relative bg-white rounded-xl shadow-2xl max-w-xs w-full m-4 p-4" onclick="event.stopPropagation()">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Opsi Foto Profil</h3>
        
        <ul class="space-y-2">
            {{-- GANTI/PILIH FOTO --}}
            <li>
                <button type="button" onclick="triggerFileInput()" id="change-select-photo-button"
                        class="w-full flex items-center px-3 py-2 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition text-sm">
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
            <img id="preview-image-source" src="" class="max-w-full max-h-[200px] object-contain rounded-lg border-2 border-blue-200 shadow-md" alt="Preview Foto Baru">
        </div>

        <p class="text-gray-600 mb-6 text-center text-sm">
            Anda akan mengganti foto profil dengan gambar ini.
        </p>

        {{-- FORM UNTUK MENGUPLOAD FOTO (AKSI SIMPAN PERUBAHAN DI SINI) --}}
        <form id="photo-upload-form" action="{{ route('mahasiswa.profil.upload_photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Input ini akan diisi oleh JavaScript dari file sementara --}}
            <input type="file" id="modal_photo_input" accept="image/*" name="foto_profil" class="hidden"> 
            
            <button type="submit" 
                    id="confirm-upload-button"
                    class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-md text-sm mb-2">
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
        
        <form id="delete-photo-form" action="{{ route('mahasiswa.profil.delete_photo') }}" method="POST">
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
                imgElement.classList.add('w-full', 'h-full', 'object-cover', 'rounded-full', 'border-4', 'border-white/50', 'shadow-lg', 'transition', 'duration-300');
                cardPhotoDefault.parentNode.insertBefore(imgElement, cardPhotoDefault);
            }
            imgElement.src = src; 
            imgElement.classList.remove('hidden');
            if (cardPhotoDefault) cardPhotoDefault.classList.add('hidden');
            
            changeSelectBtnText.innerHTML = '<i class="fas fa-upload w-5 mr-3"></i> Ganti Foto';
            deleteBtnModal.classList.remove('hidden');
            viewBtnModal.classList.remove('hidden');

        } else if (!src) {
            hasCurrentPhoto = false;

            let imgElement = document.getElementById('current-card-photo');
            if (imgElement) imgElement.classList.add('hidden');
            if (cardPhotoDefault) cardPhotoDefault.classList.remove('hidden');
            
            changeSelectBtnText.innerHTML = '<i class="fas fa-upload w-5 mr-3"></i> Pilih Foto Profil';
            deleteBtnModal.classList.add('hidden');
            viewBtnModal.classList.add('hidden');
        }
    }

    // Fungsi untuk memicu perubahan pada preview (dipanggil setelah file dipilih)
    const handleFileInputChange = (file) => {
        if (file) {
            
            // Pindahkan file ke input form upload di dalam modal
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

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            if ('{{ session('success') }}'.includes('Foto profil berhasil diunggah')) {

            }
           
            if ('{{ session('success') }}'.includes('Foto profil berhasil dihapus')) {
                updateCardDisplay(null, false);
            }
        });
    @endif
</script>

@endsection