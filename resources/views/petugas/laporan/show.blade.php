@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ route('petugas.laporan.index') }}" 
               class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Laporan
            </a>
        </div>
        
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-red-700 font-medium">Terdapat kesalahan dalam pengisian form.</span>
                </div>
            </div>
        @endif

        <!-- Kartu Detail Laporan -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            
            <!-- Header Laporan -->
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $laporan->judul }}</h1>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-tag mr-2"></i> {{ $laporan->kategori->nama ?? 'Umum' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-user mr-2"></i> {{ $laporan->user->name }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ 
                                $laporan->status == 'Selesai' ? 'bg-green-100 text-green-800' : 
                                ($laporan->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') 
                            }}">
                                <i class="fas {{ 
                                    $laporan->status == 'Selesai' ? 'fa-check-circle' : 
                                    ($laporan->status == 'Diproses' ? 'fa-spinner' : 'fa-clock') 
                                }} mr-2"></i>
                                {{ $laporan->status }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Quick Status Update -->
                    <div class="mt-4 md:mt-0">
                        <form action="{{ route('petugas.laporan.updateStatus', $laporan->id) }}" method="POST">
                            @csrf
                            @method('PUT')   <!-- INI YANG WAJIB ADA -->

                            <select name="status" class="border rounded px-2">
                                <option value="Belum Diproses" {{ $laporan->status == 'Belum Diproses' ? 'selected' : '' }}>Belum Diproses</option>
                                <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>

                            <button type="submit" class="bg-purple-600 text-white px-3 py-1 rounded">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Isi Laporan -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Detail Laporan -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Detail Laporan</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $laporan->isi_laporan ?? $laporan->deskripsi }}
                            </p>
                        </div>

                        @if($laporan->lokasi)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Lokasi Kejadian</h4>
                            <div class="flex items-center text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                                {{ $laporan->lokasi }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Foto Bukti -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Bukti Foto</h3>
                        @if ($laporan->foto)
                            <a href="{{ Storage::url($laporan->foto) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($laporan->foto) }}" alt="Bukti Laporan" 
                                     class="w-full h-64 object-cover rounded-lg border border-gray-200 shadow-sm hover:opacity-90 transition cursor-pointer">
                            </a>
                            <p class="text-xs text-gray-500 mt-2 text-center">Klik gambar untuk melihat ukuran penuh</p>
                        @else
                            <div class="w-full h-64 bg-gray-100 rounded-lg border border-gray-200 border-dashed flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-camera text-3xl mb-2"></i>
                                <span class="text-sm">Tidak ada foto terlampir</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section Komentar & Tanggapan -->
            <div class="border-t border-gray-200">
                <!-- Form Tambah Komentar -->
                <div class="p-6 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-comment-medical mr-2 text-purple-600"></i>
                        Beri Tanggapan
                    </h3>
                    
                    <form action="{{ route('petugas.laporan.storeKomentar', $laporan->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="isi_komentar" class="block text-sm font-medium text-gray-700 mb-2">
                                Isi Tanggapan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="isi_komentar" id="isi_komentar" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition resize-none"
                                      placeholder="Tulis tanggapan, update progress, atau solusi untuk laporan ini..."
                                      required>{{ old('isi_komentar') }}</textarea>
                            @error('isi_komentar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xs text-gray-500">
                                    Minimal 3 karakter. Komentar akan terlihat oleh pelapor.
                                </span>
                                <span id="charCount" class="text-xs text-gray-500">0 karakter</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Anda menanggapi sebagai: <strong class="ml-1">{{ Auth::user()->name }}</strong>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="clearForm()" 
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                                    <i class="fas fa-eraser mr-2"></i>Bersihkan
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center shadow-sm">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Kirim Tanggapan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Daftar Komentar -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-comments mr-2 text-purple-600"></i>
                            Riwayat Diskusi
                        </h3>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ $laporan->komentar->count() }} tanggapan
                        </span>
                    </div>

                    <div class="space-y-4">
                        <!-- Komentar dari Pelapor (Laporan Awal) -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white shadow-md">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1 bg-purple-50 rounded-lg p-4 border border-purple-100">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <span class="font-semibold text-purple-700">{{ $laporan->user->name }}</span>
                                        <span class="ml-2 px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">Pelapor</span>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $laporan->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-gray-700 text-sm">Mengirim laporan: "{{ $laporan->judul }}"</p>
                            </div>
                        </div>

                        <!-- Komentar dari Petugas/Admin -->
                        @forelse($laporan->komentar as $komentar)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full {{ $komentar->user->role == 'petugas' ? 'bg-blue-600' : 'bg-green-600' }} flex items-center justify-center text-white shadow-md">
                                    <i class="fas fa-user-shield text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1 bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <span class="font-semibold {{ $komentar->user->role == 'petugas' ? 'text-blue-700' : 'text-green-700' }}">
                                            {{ $komentar->user->name }}
                                        </span>
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $komentar->user->role == 'petugas' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                            {{ ucfirst($komentar->user->role) }}
                                        </span>
                                        @if($komentar->user_id == Auth::id())
                                        <span class="ml-2 px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">Anda</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $komentar->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-gray-700 whitespace-pre-line">{{ $komentar->isi_komentar }}</p>
                            </div>
                        </div>
                        @empty
                        <!-- Empty State -->
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fas fa-comment-slash text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada tanggapan</p>
                            <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama memberikan tanggapan</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('isi_komentar');
    const charCount = document.getElementById('charCount');
    
    // Character counter
    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length + ' karakter';
        
        if (length < 3) {
            charCount.classList.add('text-red-500');
            charCount.classList.remove('text-green-500');
        } else {
            charCount.classList.remove('text-red-500');
            charCount.classList.add('text-green-500');
        }
    });
    
    // Auto-focus textarea
    textarea.focus();
    
    // Scroll to form if there are errors
    @if($errors->has('isi_komentar'))
        textarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    @endif
});

function clearForm() {
    document.getElementById('isi_komentar').value = '';
    document.getElementById('charCount').textContent = '0 karakter';
    document.getElementById('charCount').classList.remove('text-green-500');
    document.getElementById('charCount').classList.add('text-red-500');
}

// Auto-scroll to top for success messages
@if(session('success'))
window.scrollTo({ top: 0, behavior: 'smooth' });
@endif
</script>

<style>
/* Smooth transitions */
textarea {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar for textarea */
textarea::-webkit-scrollbar {
    width: 6px;
}

textarea::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb {
    background: #c4b5fd;
    border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb:hover {
    background: #a78bfa;
}
</style>
@endsection