@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        <a href="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.index' : 'petugas.laporan.index') }}" 
           class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Laporan
        </a>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex justify-between items-start">
                            <div>
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

                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Masalah</h3>
                            <p class="text-gray-800 leading-relaxed text-lg">{{ $laporan->deskripsi }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Lokasi Kejadian</h3>
                            <div class="flex items-start text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-3"></i>
                                <span>{{ $laporan->lokasi }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Dilaporkan Oleh</h3>
                        @if ($laporan->user)
                            <div class="flex items-center space-x-3">
                                
                                @if (isset($laporan->user->foto_profil) && $laporan->user->foto_profil)
                                    <img src="{{ asset('storage/' . $laporan->user->foto_profil) }}" 
                                         alt="{{ $laporan->user->name }}" 
                                         class="w-10 h-10 rounded-full object-cover shadow-sm">
                                @else
                                    {{-- Tampilkan inisial jika tidak ada foto profil --}}
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ strtoupper(substr($laporan->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">{{ $laporan->user->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $laporan->user->email }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col h-[500px]">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-comments text-blue-600 mr-2"></i> Tanggapan
                    </h3>
                    
                    <div class="flex-1 overflow-y-auto space-y-4 mb-4 pr-2 custom-scrollbar">
                        @forelse ($laporan->komentar as $komentar)
                        <div class="flex space-x-3">
                            <div class="flex-shrink-0">

                                @if (isset($komentar->user->foto_profil) && $komentar->user->foto_profil)
                                    <img src="{{ asset('storage/' . $komentar->user->foto_profil) }}" 
                                         alt="{{ $komentar->user->name }}" 
                                         class="w-8 h-8 rounded-full object-cover shadow-sm">
                                @else
                                    <div class="w-8 h-8 rounded-full {{ $komentar->user->role == 'mahasiswa' ? 'bg-gray-400' : 'bg-purple-600' }} flex items-center justify-center text-white font-bold text-xs">
                                        {{ strtoupper(substr($komentar->user->name, 0, 1)) }}
                                    </div>
                                @endif

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