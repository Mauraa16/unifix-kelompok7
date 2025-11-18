@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Detail Laporan (Admin)</h1>
        <p class="text-sm text-gray-600 -mt-4 mb-6 bg-yellow-50 p-3 rounded-lg border border-yellow-100 text-yellow-800">
            <i class="fas fa-info-circle mr-1"></i> 
            Admin hanya dapat mengubah konten laporan (Judul, Deskripsi, dll). Untuk mengubah status, gunakan halaman "Lihat Laporan".
        </p>
        
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

        <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Laporan</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $laporan->judul) }}" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori Kerusakan</label>
                <select name="kategori_id" id="kategori_id" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ old('kategori_id', $laporan->kategori_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Spesifik</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $laporan->lokasi) }}" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kerusakan</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700">Upload Foto Baru (Opsional)</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah foto.</p>
                @if ($laporan->foto)
                <div class="mt-3">
                    <span class="text-sm font-medium block mb-2">Foto Saat Ini:</span>
                    <a href="{{ Storage::url($laporan->foto) }}" target="_blank" class="inline-block">
                        <img src="{{ Storage::url($laporan->foto) }}" alt="Foto Laporan" class="w-48 h-auto rounded-lg object-cover border border-gray-200 shadow-sm hover:opacity-90 transition">
                    </a>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-end pt-6 space-x-4 border-t border-gray-100 mt-6">
                <a href="{{ route('admin.laporan.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Batal
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection