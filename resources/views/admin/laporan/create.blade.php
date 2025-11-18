@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Laporan Kerusakan Baru</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laporan.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            
            <!-- Judul -->
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Laporan</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                       placeholder="Contoh: AC di Ruang 301 Mati">
            </div>
            
            <!-- Kategori -->
            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori Kerusakan</label>
                <select name="kategori_id" id="kategori_id" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="" disabled selected>Pilih kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Spesifik</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                       placeholder="Contoh: Gedung A, Lantai 3, Ruang 301, Samping Pintu Masuk">
            </div>
            
            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kerusakan</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                          placeholder="Jelaskan detail kerusakan sedetail mungkin...">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700">Upload Foto (Opsional)</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-end pt-4 space-x-4">
                <a href="{{ route('laporan.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                    Batal
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-200">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection