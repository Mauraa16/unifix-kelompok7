@extends('layouts.app')

@section('content')
{{-- 
    PERBAIKAN: 
    Menggunakan 'py-8' saja. 
    Jarak dari header sudah diurus otomatis oleh layout utama (app.blade.php) yang punya 'pt-20'.
    Jadi tidak perlu lagi menambahkan pt-28 di sini.
--}}
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Profil Administrator</h1>
                <p class="text-gray-600 mt-1">Kelola informasi akun dan data pribadi Anda.</p>
            </div>
            <div class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-bold flex items-center shadow-sm">
                <i class="fas fa-shield-alt mr-2"></i> Role: Administrator
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group">
                    <div class="h-28 bg-gradient-to-r from-purple-600 to-indigo-700"></div>
                    
                    <div class="text-center -mt-14 pb-6">
                        <div class="relative inline-block">
                            <div class="w-28 h-28 mx-auto bg-white rounded-full p-1.5 shadow-lg">
                                <div class="w-full h-full bg-purple-50 rounded-full flex items-center justify-center text-purple-600 text-4xl font-bold border border-purple-100">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-800 mt-4">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm font-medium">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Ringkasan Sistem</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-users text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Total User</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ $totalUsers }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Laporan</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ $totalLaporan }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Selesai</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ $totalLaporanSelesai }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Edit Informasi Akun</h2>
                            <p class="text-sm text-gray-500 mt-1">Perbarui detail profil Anda di sini.</p>
                        </div>
                    </div>

                    {{-- Notifikasi Sukses --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-md flex items-center shadow-sm">
                            <i class="fas fa-check-circle mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="name" id="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition outline-none"
                                           placeholder="Nama lengkap Anda"
                                           required>
                                </div>
                                @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition outline-none"
                                           placeholder="email@contoh.com"
                                           required>
                                </div>
                                @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Role Akun</label>
                                <div class="w-full pl-4 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-500 flex items-center cursor-not-allowed select-none">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                                    <span>Administrator</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i> Role akun tidak dapat diubah secara mandiri.
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection