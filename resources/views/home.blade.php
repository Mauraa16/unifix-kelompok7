@extends('layouts.app')

@section('content')

<style>
    /* Animasi halus untuk hero image */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .hero-animate {
        animation: float 4s ease-in-out infinite;
    }
</style>

<div class="bg-gray-50 min-h-screen pb-12">
    
    {{-- HERO SECTION --}}
    <div class="relative bg-gradient-to-r from-purple-700 to-indigo-800 text-white overflow-hidden rounded-b-[40px] shadow-lg mb-10">
        {{-- Pattern Overlay (Hiasan) --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
            </svg>
        </div>

        <div class="container mx-auto px-6 pt-12 pb-20 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                {{-- Text Content --}}
                <div class="md:w-1/2 text-center md:text-left">
                    <span class="inline-block py-1 px-3 rounded-full bg-purple-600 bg-opacity-50 border border-purple-400 text-xs font-semibold mb-4 tracking-wide">
                        SISTEM PENGADUAN FASILITAS
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                        Ada Fasilitas Rusak?<br>
                        <span class="text-yellow-300">Lapor Sekarang!</span>
                    </h1>
                    <p class="text-lg text-purple-100 mb-8 max-w-lg mx-auto md:mx-0">
                        Bantu kami menjaga kenyamanan kampus. Laporkan kerusakan fasilitas dengan mudah, cepat, dan transparan melalui UNIFIX.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('laporan.create') }}" 
                           class="px-8 py-3 bg-white text-purple-700 font-bold rounded-full shadow-lg hover:bg-gray-100 hover:shadow-xl transition transform hover:-translate-y-1">
                            <i class="fas fa-plus-circle mr-2"></i> Buat Laporan
                        </a>
                        <a href="{{ route('laporan.index') }}" 
                           class="px-8 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-purple-700 transition">
                            <i class="fas fa-list mr-2"></i> Laporan Saya
                        </a>
                    </div>
                </div>

                {{-- Illustration / Icon --}}
                <div class="md:w-1/2 flex justify-center hero-animate">
                    <div class="relative">
                        <div class="absolute inset-0 bg-purple-500 blur-3xl opacity-30 rounded-full"></div>
                        <img src="https://img.freepik.com/free-vector/maintenance-concept-illustration_114360-391.jpg?w=740&t=st=1685000000~exp=1685000600~hmac=xyz" 
                             alt="Maintenance Illustration" 
                             class="relative z-10 w-full max-w-sm drop-shadow-2xl rounded-2xl mix-blend-multiply">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-16 relative z-20">
        
        {{-- STATISTIK CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-purple-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Total Laporan</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalLaporan }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-yellow-400 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Belum Diproses</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $laporanPending }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Sedang Diproses</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $laporanProses }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fas fa-cogs"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-green-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Selesai</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $laporanSelesai }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRID CONTENT: ALUR & RIWAYAT TERBARU --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: ALUR PELAPORAN --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-purple-600 mr-3"></i> Alur Pelaporan
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                                1
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Ambil Foto</h3>
                            <p class="text-gray-500 text-sm">Foto bagian fasilitas yang rusak sebagai bukti laporan.</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                                2
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Isi Formulir</h3>
                            <p class="text-gray-500 text-sm">Lengkapi data lokasi dan deskripsi kerusakan dengan jelas.</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                                3
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Pantau Status</h3>
                            <p class="text-gray-500 text-sm">Cek status laporan Anda secara berkala di dashboard.</p>
                        </div>
                    </div>

                    <div class="mt-8 text-center bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-600 text-sm">
                            <i class="fas fa-lightbulb text-yellow-500 mr-1"></i> 
                            <strong>Tips:</strong> Berikan deskripsi sedetail mungkin agar petugas mudah menemukan lokasi kerusakan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: AKTIVITAS TERBARU --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-800">Riwayat Terbaru</h2>
                        <a href="{{ route('laporan.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Lihat Semua</a>
                    </div>

                    @forelse($riwayatTerbaru as $item)
                        <div class="flex items-start space-x-4 mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                            {{-- Icon Status --}}
                            <div class="flex-shrink-0 mt-1">
                                @if($item->status == 'Selesai')
                                    <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs"><i class="fas fa-check"></i></div>
                                @elseif($item->status == 'Diproses')
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs"><i class="fas fa-cog"></i></div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-xs"><i class="fas fa-clock"></i></div>
                                @endif
                            </div>
                            
                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->judul }}</p>
                                <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                                    {{ $item->status == 'Selesai' ? 'bg-green-50 text-green-700' : 
                                      ($item->status == 'Diproses' ? 'bg-blue-50 text-blue-700' : 'bg-yellow-50 text-yellow-700') }}">
                                    {{ $item->status }}
                                </span>
                            </div>
                            
                            {{-- Arrow --}}
                            <a href="{{ route('laporan.show', $item->id) }}" class="text-gray-300 hover:text-purple-600 transition">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                <i class="fas fa-folder-open text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada riwayat laporan.</p>
                            <a href="{{ route('laporan.create') }}" class="text-purple-600 text-sm font-medium hover:underline mt-2 inline-block">Buat sekarang</a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection