@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Laporan</h1>
                <p class="text-gray-600 mt-1">Tinjau, proses, dan kelola semua laporan yang masuk.</p>
            </div>
            <!-- Filter Status -->
            <form method="GET" action="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.index' : 'petugas.laporan.index') }}">
                <select name="status" onchange="this.form.submit()" class="mt-4 md:mt-0 block w-full md:w-56 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Semua Status</option>
                    <option value="Belum Diproses" {{ request('status') == 'Belum Diproses' ? 'selected' : '' }}>Belum Diproses</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
        </div>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Tabel Daftar Laporan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Laporan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($laporan as $l)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($l->foto)
                                        <img src="{{ asset('storage/' . $l->foto) }}" alt="Foto Laporan" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $l->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $l->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $l->judul }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-1">{{ $l->lokasi }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $l->kategori->nama_kategori }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $warna = [
                                            'Belum Diproses' => 'bg-yellow-100 text-yellow-800',
                                            'Diproses'      => 'bg-blue-100 text-blue-800',
                                            'Selesai'       => 'bg-green-100 text-green-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $warna[$l->status] ?? '' }}">
                                        {{ $l->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $l->created_at->format('d M Y') }}</td>
                                
                                {{-- =============================================== --}}
                                {{-- == BAGIAN AKSI YANG DIPERBAIKI == --}}
                                {{-- =============================================== --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">

                                    <!-- Tombol Lihat (Semua Admin/Petugas) -->
                                    <a href="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.show' : 'petugas.laporan.show', $l->id) }}"
                                       class="text-blue-600 hover:text-blue-900"
                                       title="Lihat & Tanggapi">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                        <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                    </div>
                                    <p>Tidak ada laporan yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            @if ($laporan->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $laporan->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection