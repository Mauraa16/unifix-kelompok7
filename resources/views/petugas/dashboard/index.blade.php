@extends('layouts.app')
@section('title', 'Dashboard Petugas - UNIFIX')
@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Petugas</h1>
                <p class="text-gray-600 mt-1">Selamat datang kembali, {{ Auth::user()->name }}. Berikut ringkasan aktivitas hari ini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Petugas Aktif
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- STATISTIC CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Laporan -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Laporan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalLaporan }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-database text-purple-500 mr-1"></i> Semua laporan sistem
                </div>
            </div>

            <!-- Laporan Belum Diproses -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Belum Diproses</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporanBelumDiproses }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <span class="text-yellow-600 font-semibold">Perhatian!</span> Butuh tindakan
                </div>
            </div>

            <!-- Laporan Diproses -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Sedang Diproses</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporanDiproses }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-spinner text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-tasks text-blue-500 mr-1"></i> Dalam penanganan
                </div>
            </div>

            <!-- Laporan Selesai -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition duration-200">
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
                    <i class="fas fa-check text-green-500 mr-1"></i> Telah diselesaikan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Laporan Terbaru -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-800">Laporan Masuk Terbaru</h2>
                    <a href="{{ route('petugas.laporan.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center">
                        Lihat Semua
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($recentLaporan as $laporan)
                    <div class="p-4 hover:bg-gray-50 transition duration-150">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="mt-1 p-2 rounded-lg 
                                    {{ $laporan->status == 'Selesai' ? 'bg-green-100 text-green-600' : 
                                       ($laporan->status == 'Diproses' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600') }}">
                                    <i class="fas {{ $laporan->status == 'Selesai' ? 'fa-check' : 
                                                   ($laporan->status == 'Diproses' ? 'fa-spinner' : 'fa-exclamation-triangle') }} text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">{{ $laporan->judul }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="far fa-user mr-1"></i> {{ $laporan->user->name }} • 
                                        <i class="far fa-calendar-alt ml-2 mr-1"></i> {{ $laporan->created_at->format('d M Y, H:i') }}
                                    </p>
                                    @if($laporan->kategori)
                                    <span class="inline-block mt-2 px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                        {{ $laporan->kategori->nama ?? 'Umum' }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    {{ $laporan->status == 'Selesai' ? 'bg-green-100 text-green-700' : 
                                       ($laporan->status == 'Diproses' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $laporan->status }}
                                </span>
                                <a href="{{ route('petugas.laporan.show', $laporan->id) }}" 
                                   class="text-gray-400 hover:text-purple-600 transition transform hover:scale-110"
                                   title="Lihat Detail">
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

            <!-- Aktivitas Cepat & Statistik -->
            <div class="space-y-6">
                <!-- Aktivitas Cepat -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-800">Aktivitas Cepat</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <a href="{{ route('petugas.laporan.index') }}" 
                           class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition duration-200 group">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3 group-hover:bg-purple-200 transition">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-purple-700 text-sm">Semua Laporan</h3>
                                <p class="text-xs text-gray-500">Kelola semua laporan</p>
                            </div>
                        </a>

                        <a href="{{ route('petugas.laporan.belum') }}" 
                           class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition duration-200 group">
                            <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-yellow-700 text-sm">Belum Diproses</h3>
                                <p class="text-xs text-gray-500">Tangani laporan baru</p>
                            </div>
                        </a>

                        <a href="{{ route('petugas.riwayat') }}" 
                           class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition duration-200 group">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3 group-hover:bg-green-200 transition">
                                <i class="fas fa-history"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-green-700 text-sm">Riwayat Saya</h3>
                                <p class="text-xs text-gray-500">Laporan yang saya tangani</p>
                            </div>
                        </a>

                        <a href="{{ route('petugas.profil') }}" 
                           class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition duration-200 group">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-blue-700 text-sm">Profil Saya</h3>
                                <p class="text-xs text-gray-500">Kelola akun petugas</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Statistik Singkat -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-800">Statistik Hari Ini</h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Laporan Baru</span>
                                <span class="font-semibold text-purple-600">{{ $todayLaporan }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Ditangani Hari Ini</span>
                                <span class="font-semibold text-blue-600">{{ $ditanganiHariIni }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Selesai Hari Ini</span>
                                <span class="font-semibold text-green-600">{{ $selesaiHariIni }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar Overall -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Progress Penanganan Laporan</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Rate Penyelesaian</span>
                        <span>{{ $progressPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $totalLaporan }}</div>
                        <div class="text-xs text-gray-500">Total</div>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $laporanDiproses }}</div>
                        <div class="text-xs text-gray-500">Diproses</div>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $laporanSelesai }}</div>
                        <div class="text-xs text-gray-500">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection