@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Tombol Kembali (Dinamis untuk Admin/Petugas) -->
        <a href="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.index' : 'petugas.laporan.index') }}" 
           class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Laporan
        </a>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Detail Laporan -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex justify-between items-start">
                            <div>
                                <!-- Badge Status -->
                                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                    {{ $laporan->status == 'Selesai' ? 'bg-green-100 text-green-700 border border-green-200' : 
                                      ($laporan->status == 'Diproses' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200') }}">
                                    {{ $laporan->status }}
                                </span>
                                <h1 class="text-2xl font-bold text-gray-900 mt-3">{{ $laporan->judul }}</h1>
                                <div class="flex items-center text-sm text-gray-500 mt-2 space-x-4">
                                    <span class="flex items-center">
                                        <i class="far fa-calendar-alt mr-1.5"></i>
                                        {{ $laporan->created_at->format('d F Y, H:i') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-tag mr-1.5"></i>
                                        {{ $laporan->kategori->nama_kategori }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Bukti Foto -->
                        @if ($laporan->foto)
                            <div class="mb-6">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bukti Foto</h3>
                                <div class="rounded-lg overflow-hidden border border-gray-200 inline-block">
                                    <a href="{{ Storage::url($laporan->foto) }}" target="_blank">
                                        <img src="{{ Storage::url($laporan->foto) }}" alt="Foto Laporan" class="max-h-96 object-cover">
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Masalah</h3>
                            <p class="text-gray-800 leading-relaxed text-lg">{{ $laporan->deskripsi }}</p>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Lokasi Kejadian</h3>
                            <div class="flex items-start text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-3"></i>
                                <span>{{ $laporan->lokasi }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Pelapor -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Dilaporkan Oleh</h3>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center text-white font-bold shadow-sm">
                                {{ strtoupper(substr($laporan->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ $laporan->user->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $laporan->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Aksi & Komentar -->
            <div class="space-y-6">
                
                <!-- Form Update Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tasks text-purple-600 mr-2"></i> Tindakan
                    </h3>
                    <form action="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.updateStatus' : 'petugas.laporan.updateStatus', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="block text-sm font-medium text-gray-700 mb-2">Update Status Laporan</label>
                        <select name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition">
                            <option value="Belum Diproses" {{ $laporan->status == 'Belum Diproses' ? 'selected' : '' }}>⏳ Belum Diproses</option>
                            <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>🔧 Sedang Diproses</option>
                            <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                        </select>
                        <button type="submit" class="mt-4 w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                <!-- Komentar / Tanggapan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-[500px]">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-comments text-blue-600 mr-2"></i> Tanggapan
                    </h3>
                    
                    <!-- Daftar Komentar (Scrollable) -->
                    <div class="flex-1 overflow-y-auto space-y-4 mb-4 pr-2 custom-scrollbar">
                        @forelse ($laporan->komentar as $komentar)
                        <div class="flex space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full {{ $komentar->user->role == 'mahasiswa' ? 'bg-gray-400' : 'bg-purple-600' }} flex items-center justify-center text-white font-bold text-xs">
                                    {{ strtoupper(substr($komentar->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-100 rounded-2xl rounded-tl-none p-3">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-bold text-gray-900">{{ $komentar->user->name }}</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-200 text-gray-600">{{ ucfirst($komentar->user->role) }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $komentar->isi_komentar }}</p>
                                </div>
                                <div class="text-[10px] text-gray-400 mt-1 ml-1">
                                    {{ $komentar->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400 text-sm">Belum ada tanggapan.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Form Tambah Komentar -->
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <form action="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.storeKomentar' : 'petugas.laporan.storeKomentar', $laporan->id) }}" method="POST">
                            @csrf
                            <div class="relative">
                                <textarea name="isi_komentar" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm pr-10" placeholder="Tulis tanggapan..."></textarea>
                                <button type="submit" class="absolute bottom-2 right-2 text-purple-600 hover:text-purple-800 transition">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            @error('isi_komentar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Menambahkan CSS untuk custom scrollbar (opsional tapi bagus) -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c5c5c5;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection