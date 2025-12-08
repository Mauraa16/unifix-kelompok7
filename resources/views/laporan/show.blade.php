@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ route('laporan.index') }}" 
               class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Laporan Saya
            </a>
        </div>
        
        <!-- Kartu Detail Laporan -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            
            <!-- Banner Status Laporan -->
            <div class="px-6 py-4 {{ $laporan->status == 'Selesai' ? 'bg-green-50 border-b border-green-100' : ($laporan->status == 'Diproses' ? 'bg-blue-50 border-b border-blue-100' : 'bg-yellow-50 border-b border-yellow-100') }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full {{ $laporan->status == 'Selesai' ? 'bg-green-200 text-green-700' : ($laporan->status == 'Diproses' ? 'bg-blue-200 text-blue-700' : 'bg-yellow-200 text-yellow-700') }} mr-3">
                            <!-- Ikon berdasarkan status -->
                            @if($laporan->status == 'Selesai')
                                <i class="fas fa-check"></i>
                            @elseif($laporan->status == 'Diproses')
                                <i class="fas fa-tools"></i>
                            @else
                                <i class="fas fa-clock"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider {{ $laporan->status == 'Selesai' ? 'text-green-800' : ($laporan->status == 'Diproses' ? 'text-blue-800' : 'text-yellow-800') }}">
                                Status Laporan
                            </p>
                            <p class="text-lg font-bold {{ $laporan->status == 'Selesai' ? 'text-green-900' : ($laporan->status == 'Diproses' ? 'text-blue-900' : 'text-yellow-900') }}">
                                {{ $laporan->status }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Tanggal Lapor</p>
                        <p class="text-sm font-medium text-gray-700">{{ $laporan->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Isi Laporan -->
            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $laporan->judul }}</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                        <i class="fas fa-tag mr-2 text-gray-500"></i> {{ $laporan->kategori->nama_kategori }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kiri: Teks Detail -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Detail Masalah</h3>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            {{ $laporan->deskripsi }}
                        </p>

                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Lokasi</h3>
                        <div class="flex items-center text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                            {{ $laporan->lokasi }}
                        </div>
                    </div>

                    <!-- Kanan: Foto -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Bukti Foto</h3>
                        @if ($laporan->foto)
                            <!-- Tautan untuk memperbesar gambar di tab baru -->
                            <a href="{{ Storage::url($laporan->foto) }}" target="_blank" title="Klik untuk memperbesar">
                                <img src="{{ Storage::url($laporan->foto) }}" alt="Bukti Laporan" class="w-full h-64 object-cover rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:opacity-90 transition">
                            </a>
                        @else
                            <div class="w-full h-64 bg-gray-100 rounded-xl border border-gray-200 border-dashed flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-image-slash text-4xl mb-2"></i>
                                <span>Tidak ada foto terlampir</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section Timeline / Komentar -->
            <div class="bg-gray-50 p-8 border-t border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Riwayat & Tanggapan</h3>

                <div class="space-y-6">
                    <!-- Item 1: Laporan Dibuat (Selalu ada) -->
                    <div class="flex gap-4">
                        <!-- Ikon & Garis Waktu -->
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white z-10 shadow-md">
                                <i class="fas fa-file-alt text-xs"></i>
                            </div>
                            <!-- Garis vertikal -->
                            @if($laporan->komentar->count() > 0 || $laporan->status != 'Selesai')
                            <div class="h-full w-0.5 bg-gray-200 my-1"></div>
                            @endif
                        </div>
                        <!-- Konten -->
                        <div class="pb-6">
                            <p class="text-sm font-bold text-gray-900">Laporan Terkirim</p>
                            <p class="text-xs text-gray-500">{{ $laporan->created_at->format('d F Y, H:i') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Anda mengirim laporan ini.</p>
                        </div>
                    </div>

                    <!-- Loop Komentar Petugas/Admin -->
                    @foreach ($laporan->komentar as $komentar)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white z-10 shadow-md">
                                <i class="fas fa-comment-dots text-xs"></i>
                            </div>
                            <!-- Garis penghubung (kecuali item terakhir) -->
                            @if(!$loop->last || $laporan->status == 'Selesai')
                            <div class="h-full w-0.5 bg-gray-200 my-1"></div>
                            @endif
                        </div>
                        <div class="pb-6 w-full">
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-blue-700 text-sm">{{ $komentar->user->name }} <span class="text-xs font-normal text-gray-500">({{ ucfirst($komentar->user->role) }})</span></span>
                                    <span class="text-xs text-gray-400">{{ $komentar->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700">{{ $komentar->isi_komentar }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Status Selesai (Jika ada) -->
                    @if($laporan->status == 'Selesai')
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white z-10 shadow-md">
                                <i class="fas fa-check-circle text-xs"></i>
                            </div>
                        </div>
                        <div class="pt-1.5">
                            <p class="text-sm font-bold text-green-700">Laporan Selesai</g_p>
                            <p class="text-sm text-gray-600 mt-1">Laporan ini telah ditandai sebagai "Selesai".</p>
                        </div>
                    </div>
                    @endif

                    <!-- Jika belum ada komentar dan belum selesai -->
                    @if($laporan->komentar->isEmpty() && $laporan->status != 'Selesai')
                    <div class="flex gap-4 opacity-50">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-white z-10">
                                <i class="fas fa-ellipsis-h text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mt-1.5">Menunggu tanggapan petugas...</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 
==========================================================
PERBAIKAN: Seluruh <style>...</style> dihapus dari sini
==========================================================
--}}

@endsection