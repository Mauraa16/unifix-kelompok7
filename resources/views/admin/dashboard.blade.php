@extends('layouts.app')
@section('title', 'Dashboard Admin - UNIFIX')
@section('content')

{{-- Tambahkan custom style untuk animasi shape --}}
<style>
    @keyframes spin-fast {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes blink-fast {
        0%, 100% { opacity: 0; transform: scale(0.5); } 
        50% { opacity: 0.8; transform: scale(1.2); } 
    }

    .animate-spin-fast {
        animation: spin-fast 12s linear infinite; 
    }
    .animate-blink-fast {
        animation: blink-fast 5s ease-in-out infinite; 
    }
</style>

{{-- CONTAINER UTAMA DIBUAT RELATIVE --}}
<div class="relative min-h-screen">

    <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-r from-purple-600 to-indigo-600 overflow-hidden shadow-lg">
        
        {{-- SHAPE 1: Persegi (Kanan Atas) --}}
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white opacity-10 transform rotate-45 animate-spin-fast" style="animation-duration: 20s;"></div>
        
        {{-- SHAPE 2: Persegi (Kiri Bawah) --}}
        <div class="absolute bottom-[-30px] left-10 w-32 h-32 bg-indigo-400 opacity-20 transform skew-y-6 animate-spin-fast" style="animation-duration: 30s;"></div>

        {{-- SHAPE 3: Segitiga (Pusat Bawah) --}}
        <div class="absolute bottom-5 left-1/2 w-40 h-40 bg-purple-400 opacity-15 transform -rotate-12 animate-spin-fast translate-x-[-50%]" 
              style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%); animation-duration: 25s;"></div> 
        
        {{-- SHAPE 4: Oval Miring (Kiri Atas) --}}
        <div class="absolute top-[-50px] left-[-50px] w-64 h-64 bg-indigo-800 opacity-10 rounded-full transform rotate-[-30deg] animate-spin-fast" 
              style="animation-duration: 40s;"></div>

        <div class="absolute top-5 left-1/4 w-4 h-4 bg-indigo-300 rounded-full animate-blink-fast" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-1/4 right-20 w-6 h-6 bg-purple-400 rounded-full animate-blink-fast" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-10 right-5 w-5 h-5 bg-indigo-500 rounded-full animate-blink-fast" style="animation-delay: 2.2s;"></div>
        <div class="absolute bottom-5 left-5 w-4 h-4 bg-purple-300 rounded-full animate-blink-fast" style="animation-delay: 3s;"></div>
        <div class="absolute bottom-0 right-1/4 w-6 h-6 bg-indigo-400 rounded-full animate-blink-fast" style="animation-delay: 0s;"></div>
        <div class="absolute top-1/2 left-20 w-5 h-5 bg-purple-500 rounded-full animate-blink-fast" style="animation-delay: 4s;"></div>
        <div class="absolute top-1/3 right-1/3 w-4 h-4 bg-indigo-300 rounded-full animate-blink-fast" style="animation-delay: 1s;"></div>

    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 pt-4 pb-12 text-white">
                <h1 class="text-3xl font-bold">Dashboard Admin</h1>
                <p class="text-indigo-100 mt-1 text-lg">
                    Selamat datang kembali, <span class="font-bold">Admin1</span>. Berikut ringkasan aktivitas hari ini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-[-70px]">
                
                <div class="bg-white rounded-xl shadow-xl p-6 border-l-4 border-purple-500 hover:shadow-2xl transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <i class="fas fa-arrow-up text-green-500 mr-1"></i> Terdaftar di sistem
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-xl p-6 border-l-4 border-blue-500 hover:shadow-2xl transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Laporan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalLaporan }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-clipboard-list text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <i class="fas fa-database text-blue-500 mr-1"></i> Total semua laporan
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-xl p-6 border-l-4 border-yellow-500 hover:shadow-2xl transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Perlu Tindakan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporanPending }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i> Segera proses laporan ini
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-xl p-6 border-l-4 border-green-500 hover:shadow-2xl transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Selesai</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporanSelesai }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <i class="fas fa-check text-green-500 mr-1"></i> Masalah terselesaikan
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-4"> 
                
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-800">Laporan Masuk Terbaru</h2>
                        <a href="{{ route('admin.laporan.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Lihat Semua</a>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($recentLaporan as $laporan)
                        <div class="p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">

                                    @if ($laporan->user)
                                        @if (isset($laporan->user->foto_profil) && $laporan->user->foto_profil)
                                            <img src="{{ asset('storage/' . $laporan->user->foto_profil) }}" alt="{{ $laporan->user->name }}" class="w-8 h-8 rounded-full object-cover shadow-sm mt-1">
                                        @else
                                            {{-- Tampilkan inisial jika tidak ada foto profil --}}
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white text-xs font-bold shadow-sm mt-1">
                                                {{ strtoupper(substr($laporan->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    @endif

                                    <div class="mt-1 p-2 rounded-lg
                                        {{ $laporan->status == 'Selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        <i class="fas {{ $laporan->status == 'Selesai' ? 'fa-check' : 'fa-exclamation-triangle' }}"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900">{{ $laporan->judul ?? 'Judul Tidak Ada' }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="far fa-user mr-1"></i> {{ $laporan->user->name ?? 'User Dihapus' }} &bull; 
                                            <i class="far fa-calendar-alt ml-1 mr-1"></i> {{ $laporan->created_at->format('d M Y, H:i') }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-2 line-clamp-1">{{ Str::limit($laporan->isi_laporan ?? $laporan->deskripsi ?? 'Tidak ada deskripsi', 80) }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end space-y-2">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full
                                        {{ $laporan->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $laporan->status }}
                                    </span>
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="text-gray-400 hover:text-purple-600 transition">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500">Belum ada laporan yang masuk.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-800">User Baru</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentUsers as $user)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center space-x-3">

                                @if (isset($user->foto_profil) && $user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                @else
                                    {{-- Tampilkan inisial jika tidak ada foto profil --}}
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded border
                                {{ $user->role == 'admin' ? 'bg-red-50 text-red-600 border-red-200' : 
                                    ($user->role == 'petugas' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-purple-50 text-purple-600 border-purple-200') }}">
                                {{ $user->role }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-6 text-gray-500 text-sm">Belum ada user terdaftar</div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-gray-100 bg-gray-50 text-center">
                        <a href="{{ route('mahasiswa.index') }}" class="text-sm text-purple-600 font-semibold hover:underline">Kelola Semua User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection