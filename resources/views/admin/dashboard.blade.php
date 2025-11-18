@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                <p class="text-gray-600 mt-1">Selamat datang kembali, Admin. Berikut ringkasan aktivitas hari ini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 flex items-center">
                    <i class="fas fa-download mr-2"></i> Export Laporan
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- STATISTIC CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Users</p>
                        {{-- DIUBAH: Menggunakan variabel dari HomeController --}}
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

            <!-- Total Laporan -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Laporan</p>
                        {{-- DIUBAH: Menggunakan variabel dari HomeController --}}
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalLaporan }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-database text-blue-500 mr-1"></i> Total semua aduan
                </div>
            </div>

            <!-- Laporan Pending -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Perlu Tindakan</p>
                        {{-- DIUBAH: Menggunakan variabel dari HomeController --}}
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporanPending }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <span class="text-yellow-600 font-semibold">Segera proses</span> laporan ini
                </div>
            </div>

            <!-- Laporan Selesai -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Selesai</p>
                        {{-- DIUBAH: Menggunakan variabel dari HomeController --}}
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Laporan Terbaru -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-800">Laporan Masuk Terbaru</h2>
                    {{-- CATATAN: Link 'Lihat Semua' ini perlu Rute Laporan --}}
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Lihat Semua</a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    {{-- DIUBAH: Menggunakan variabel dari HomeController --}}
                    @forelse($recentLaporan as $laporan)
                    <div class="p-4 hover:bg-gray-50 transition duration-150">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="mt-1 p-2 rounded-lg 
                                    {{ $laporan->status == 'Sudah Diproses' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                    <i class="fas {{ $laporan->status == 'Sudah Diproses' ? 'fa-check' : 'fa-exclamation-triangle' }}"></i>
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
                                    {{ $laporan->status == 'Sudah Diproses' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $laporan->status }}
                                </span>
                                {{-- CATATAN: 'laporan.show' perlu Rute Laporan --}}
                                <a href="{{-- route('laporan.show', $laporan) --}}#" class="text-gray-400 hover:text-purple-600 transition">
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

            <!-- User Baru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-800">User Baru</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    {{-- DIUBAH: Menggunakan variabel dari HomeController --}}
                    @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded border
                            {{ $user->role == 'admin' ? 'bg-red-50 text-red-600 border-red-200' : 
                               ($user->role == 'petugas' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-gray-50 text-gray-600 border-gray-200') }}">
                            {{ $user->role }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-6 text-gray-500 text-sm">Belum ada user terdaftar</div>
                    @endforelse
                </div>
                <div class="p-4 border-t border-gray-100 bg-gray-50 text-center">
                    {{-- DIUBAH: Link ke Rute Kelola Mahasiswa/User --}}
                    <a href="{{ route('mahasiswa.index') }}" class="text-sm text-purple-600 font-semibold hover:underline">Kelola Semua User</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection