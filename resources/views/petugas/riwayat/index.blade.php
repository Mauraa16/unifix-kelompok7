@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Riwayat Tindakan</h1>
                    <p class="text-gray-600 mt-2">Laporan yang telah Anda tangani dan berikan komentar</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-history mr-2"></i>
                        Total: {{ $laporan->total() }} Laporan
                    </span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-red-500 mr-2"></i>
                    <span class="text-red-700 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Ditangani</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $laporan->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-spinner text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Masih Diproses</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $laporan->where('status', 'Diproses')->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Berhasil Diselesaikan</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $laporan->where('status', 'Selesai')->count() }}
                        </p>
                    </div>
                </div>
            </div>
             
             <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hidden xl:block">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-hand-pointer text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Terakhir Ditangani</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $laporan->first() ? $laporan->first()->updated_at->diffForHumans() : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800">Daftar Laporan yang Ditangani</h2>
                <p class="text-sm text-gray-600 mt-1">Laporan dimana Anda telah memberikan komentar atau tindakan</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Laporan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pengguna
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Tindakan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($laporan as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-alt text-purple-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->judul }}</div>
                                        <div class="text-sm text-gray-500 line-clamp-1">
                                            {{ Str::limit($item->isi_laporan ?? $item->deskripsi, 50) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $item->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'Belum Diproses' => 'bg-yellow-100 text-yellow-800',
                                        'Diproses' => 'bg-blue-100 text-blue-800',
                                        'Selesai' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas {{ 
                                        $item->status == 'Selesai' ? 'fa-check-circle' : 
                                        ($item->status == 'Diproses' ? 'fa-spinner' : 'fa-clock') 
                                    }} mr-1"></i>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-2 text-gray-400"></i>
                                    {{ $item->updated_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $item->updated_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('petugas.laporan.show', $item->id) }}" 
                                       class="text-purple-600 hover:text-purple-900 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center">
                                        <i class="fas fa-eye mr-1.5 text-xs"></i>
                                        Detail
                                    </a>
                                    
                                    <div class="relative group">
                                        <button class="text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center"
                                                title="Perbarui Status">
                                            <i class="fas fa-edit mr-1.5 text-xs"></i>
                                            Status
                                        </button>
                                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                            
                                            <form action="{{ route('petugas.laporan.updateStatus', $item->id) }}" method="POST" class="px-2">
                                                @csrf
                                                @method('PUT') 

                                                @if($item->status == 'Belum Diproses')
                                                    <button type="button" disabled
                                                            class="w-full text-left px-3 py-2 text-sm text-yellow-700 bg-yellow-50 font-semibold rounded flex items-center cursor-default opacity-75 mb-1">
                                                        <i class="fas fa-clock mr-2 text-yellow-600"></i>
                                                        Belum Diproses
                                                    </button>
                                                @endif

                                                @if($item->status == 'Belum Diproses' || $item->status == 'Diproses')
                                                    @if($item->status == 'Diproses')
                                                        <button type="button" disabled
                                                                class="w-full text-left px-3 py-2 text-sm text-blue-700 bg-blue-50 font-semibold rounded flex items-center cursor-default opacity-75 mb-1">
                                                            <i class="fas fa-spinner mr-2 text-blue-600"></i>
                                                            Diproses
                                                        </button>
                                                    @else
                                                        <button type="submit" name="status" value="Diproses" 
                                                                class="w-full text-left px-3 py-2 text-sm text-blue-700 hover:bg-blue-50 rounded flex items-center mb-1">
                                                            <i class="fas fa-spinner mr-2 text-blue-600"></i>
                                                            Ubah ke Diproses
                                                        </button>
                                                    @endif
                                                @endif

                                                @if($item->status != 'Selesai')
                                                    <button type="submit" name="status" value="Selesai" 
                                                            class="w-full text-left px-3 py-2 text-sm text-green-700 hover:bg-green-50 rounded flex items-center">
                                                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                                        Selesai
                                                    </button>
                                                @else
                                                    <button type="button" disabled
                                                            class="w-full text-left px-3 py-2 text-sm text-green-700 bg-green-50 font-semibold rounded flex items-center cursor-default opacity-75">
                                                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                                        Sudah Selesai
                                                    </button>
                                                @endif

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-history text-4xl mb-3"></i>
                                    <p class="text-lg font-medium text-gray-500">Belum ada riwayat tindakan</p>
                                    <p class="text-sm mt-1">Riwayat akan muncul setelah Anda menangani laporan</p>
                                    <a href="{{ route('petugas.laporan.index') }}" 
                                       class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-clipboard-list mr-2"></i>
                                        Lihat Semua Laporan
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($laporan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $laporan->firstItem() }} - {{ $laporan->lastItem() }} dari {{ $laporan->total() }} laporan
                    </div>
                    <div class="flex space-x-2">
                        {{ $laporan->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Aktivitas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">Distribusi Status</h3>
                    <div class="space-y-3">
                        @php
                            $statusCounts = [
                                'Belum Diproses' => $laporan->where('status', 'Belum Diproses')->count(),
                                'Diproses' => $laporan->where('status', 'Diproses')->count(),
                                'Selesai' => $laporan->where('status', 'Selesai')->count(),
                            ];
                            $total = $laporan->count() ?: 1;
                        @endphp
                        
                        @foreach($statusCounts as $status => $count)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $status }}</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-semibold text-gray-700">{{ $count }}</span>
                                <span class="text-xs text-gray-500">({{ round(($count / $total) * 100, 1) }}%)</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">Aktivitas Terbaru</h3>
                    <div class="space-y-2">
                        @foreach($laporan->take(3) as $recent)
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-file-alt mr-2 text-purple-500"></i>
                            <span class="truncate">{{ $recent->judul }}</span>
                            <span class="ml-auto text-xs text-gray-400">{{ $recent->updated_at->diffForHumans() }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.group:hover .group-hover\:visible {
    visibility: visible;
}

.group:hover .group-hover\:opacity-100 {
    opacity: 1;
}
</style>
@endsection