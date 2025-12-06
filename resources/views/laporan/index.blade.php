@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Laporan Saya</h1>
                <p class="text-gray-600 mt-1">Kelola dan pantau status laporan kerusakan yang Anda ajukan.</p>
            </div>
            <a href="{{ route('laporan.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                <i class="fas fa-plus-circle mr-2"></i> Buat Laporan Baru
            </a>
        </div>

        {{-- STATISTIK RINGKAS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Laporan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporan->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Sedang Diproses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $laporan->where('status', 'Diproses')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Selesai</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $laporan->where('status', 'Selesai')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        {{-- DAFTAR LAPORAN (GRID CARD) --}}
        @if($laporan->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($laporan as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                    
                    {{-- FOTO LAPORAN --}}
                    <div class="relative h-48 bg-gray-100">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                <i class="fas fa-image text-4xl mb-2"></i>
                                <span class="text-sm">Tidak ada foto</span>
                            </div>
                        @endif
                        
                        {{-- Badge Status di Atas Foto --}}
                        <div class="absolute top-4 right-4">
                            @php
                                $statusClass = match($item->status) {
                                    'Selesai' => 'bg-green-500 text-white',
                                    'Diproses' => 'bg-blue-500 text-white',
                                    default => 'bg-yellow-400 text-yellow-900',
                                };
                                $statusIcon = match($item->status) {
                                    'Selesai' => 'fa-check',
                                    'Diproses' => 'fa-cogs',
                                    default => 'fa-clock',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm uppercase tracking-wide flex items-center gap-1 {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i> {{ $item->status }}
                            </span>
                        </div>
                    </div>

                    {{-- KONTEN CARD --}}
                    <div class="p-5 flex-grow flex flex-col">
                        <div class="flex items-center text-xs text-gray-500 mb-2 space-x-3">
                            <span class="flex items-center">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $item->created_at->format('d M Y') }}
                            </span>
                            <span class="flex items-center text-purple-600 font-medium">
                                <i class="fas fa-tag mr-1"></i> {{ $item->kategori->nama_kategori }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 hover:text-purple-600 transition-colors">
                            <a href="{{ route('laporan.show', $item) }}">{{ $item->judul }}</a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4 flex-grow">
                            {{ $item->deskripsi }}
                        </p>

                        <div class="flex items-center text-xs text-gray-500 bg-gray-50 p-2 rounded mb-4">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                            <span class="line-clamp-1">{{ $item->lokasi }}</span>
                        </div>

                        {{-- AKSI BUTTONS --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                            <a href="{{ route('laporan.show', $item) }}" class="text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors">
                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>

                            {{-- Edit & Hapus (Hanya jika belum diproses) --}}
                            @if($item->status == 'Belum Diproses')
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('laporan.edit', $item) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-full transition" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('laporan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-full transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- TAMPILAN JIKA KOSONG --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-purple-50 text-purple-200 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Laporan</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Anda belum mengajukan laporan kerusakan apapun. Jika Anda menemukan fasilitas yang rusak, segera laporkan agar dapat diperbaiki.
                </p>
                <a href="{{ route('laporan.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-lg shadow-purple-200 transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i> Buat Laporan Pertama
                </a>
            </div>
        @endif
        
    </div>
</div>
@endsection