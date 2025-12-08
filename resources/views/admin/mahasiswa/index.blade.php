@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Mahasiswa</h1>
            <p class="text-gray-600 mt-1">Pantau, tambah, edit, atau hapus akun mahasiswa.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">

            <div class="w-full md:w-3/5 lg:max-w-lg">
                <form action="{{ route('mahasiswa.index') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari berdasarkan nama atau email mahasiswa..." 
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-12 py-2 border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 transition duration-150"
                        aria-label="Cari Mahasiswa"
                    >

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>

                    @if(request('search'))
                        <a href="{{ route('mahasiswa.index') }}" 
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

            <div class="w-full md:w-auto">
                <a href="{{ route('mahasiswa.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 flex items-center justify-center w-full md:w-auto">
                    <i class="fas fa-plus mr-2"></i> Tambah Mahasiswa
                </a>
            </div>
        </div>
        
        @if(request('search'))
            {{-- Indikator Filter berada di bawah search bar --}}
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Dibuat</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($mahasiswa as $index => $m)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mahasiswa->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        
                                        @if (isset($m->foto_profil) && $m->foto_profil)
                                            <img src="{{ asset('storage/' . $m->foto_profil) }}" 
                                                 alt="{{ $m->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover shadow-sm">
                                        @else
                                            {{-- Tampilkan inisial jika tidak ada foto profil --}}
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-sm">
                                                {{ strtoupper(substr($m->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $m->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $m->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('mahasiswa.edit', $m->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-user-graduate text-gray-400 text-3xl mb-3"></i>
                                    <p>Belum ada data mahasiswa.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($mahasiswa->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $mahasiswa->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection