@extends('petugas.layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Laporan</h1>

    <!-- FILTER STATUS -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('petugas.laporan.index') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold 
                  {{ request()->routeIs('petugas.laporan.index') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Semua
        </a>

        <a href="{{ route('petugas.laporan.belum') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold 
                  {{ request()->routeIs('petugas.laporan.belum') ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
            Belum Diproses
        </a>

        <a href="{{ route('petugas.laporan.proses') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold 
                  {{ request()->routeIs('petugas.laporan.proses') ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}">
            Diproses
        </a>

        <a href="{{ route('petugas.laporan.selesai') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold 
                  {{ request()->routeIs('petugas.laporan.selesai') ? 'bg-green-500 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
            Selesai
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Judul</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Pelapor</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($laporan as $item)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->judul }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->user->name }}</td>

                    <td class="px-4 py-2 whitespace-nowrap">
                        @php
                            $warna = [
                                'Belum Diproses' => 'bg-yellow-100 text-yellow-800',
                                'Diproses'      => 'bg-blue-100 text-blue-800',
                                'Selesai'       => 'bg-green-100 text-green-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $warna[$item->status] ?? '' }}">
                            {{ $item->status }}
                        </span>
                    </td>

                    <td class="px-4 py-2 text-sm text-gray-500">
                        {{ $item->created_at->format('d/m/Y') }}
                    </td>

                    <td class="px-4 py-2">
                        <a href="{{ route('petugas.laporan.show', $item->id) }}"
                           class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">
                            Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                        Tidak ada laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $laporan->links() }}
    </div>

</div>
@endsection
