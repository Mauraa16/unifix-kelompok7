@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tinjau Laporan</h1>
            <p class="text-gray-600 mt-1">Tinjau dan pantau semua laporan yang masuk.</p>
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">

            <div class="w-full md:w-3/5 lg:max-w-md">
                <form action="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.index' : 'petugas.laporan.index') }}" method="GET" class="relative">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari Pelapor, Judul, atau Lokasi..." 
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-12 py-2 border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 transition duration-150"
                        aria-label="Cari Laporan"
                    >
                    
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>

                    @if(request('search'))
                        <a href="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.index' : 'petugas.laporan.index', ['status' => request('status')]) }}" 
                           class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-red-500 transition"
                           title="Hapus Filter Pencarian">
                            <i class="fas fa-times"></i>
                        </a>
                    @else
                        <button type="submit" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-purple-600 hover:text-purple-800 transition"
                                title="Mulai Pencarian">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    @endif
                </form>
            </div>

            <div class="w-full md:w-auto flex-shrink-0">
                <form method="GET" action="{{ route(Auth::user()->role == 'admin' ? 'admin.laporan.index' : 'petugas.laporan.index') }}" class="relative inline-block w-full md:w-56">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fas fa-filter"></i> 
                    </div>
                    
                    <select name="status" onchange="this.form.submit()" 
                            class="block w-full pl-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150">
                        <option value="">Semua Status</option>
                        <option value="Belum Diproses" {{ request('status') == 'Belum Diproses' ? 'selected' : '' }}>Belum Diproses</option>
                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>
            </div>
        </div>

        @if(request('search'))
            <p class="mt-2 mb-6 text-sm text-gray-500">
                Hasil pencarian untuk: <span class="font-semibold text-gray-800">"{{ request('search') }}"</span>
            </p>
        @endif
        
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
                                
                                {{-- Kolom Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">

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

            @if ($laporan->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $laporan->appends(['status' => request('status'), 'search' => request('search')])->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection