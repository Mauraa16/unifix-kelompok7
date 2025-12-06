@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-600 mt-2">Kelola data diri dan pantau aktivitas laporan Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 mb-3">
                            <span class="text-3xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <h2 class="font-bold text-lg">{{ $user->name }}</h2>
                        <p class="text-blue-100 text-sm">{{ $user->email }}</p>
                        <span class="inline-block mt-3 px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">Mahasiswa</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Aktivitas Saya</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                            <span class="text-gray-600 text-sm">Laporan Diajukan</span>
                            <span class="font-bold text-blue-600">{{ $laporanSaya }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                            <span class="text-gray-600 text-sm">Sedang Diproses</span>
                            <span class="font-bold text-yellow-600">{{ $laporanProses }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Selesai</span>
                            <span class="font-bold text-green-600">{{ $laporanSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Edit Profil</h2>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection