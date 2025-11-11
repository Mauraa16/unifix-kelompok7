@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Admin</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Laporan -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Laporan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Laporan::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Laporan Belum Diproses -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Belum Diproses</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Laporan::where('status', 'Belum Diproses')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Laporan Sudah Diproses -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Sudah Diproses</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Laporan::where('status', 'Sudah Diproses')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Daftar Laporan Terbaru -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Laporan Terbaru</h2>
                <div class="space-y-4">
                    @forelse(\App\Models\Laporan::latest()->take(5)->get() as $laporan)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $laporan->judul }}</h3>
                            <p class="text-sm text-gray-500">{{ $laporan->user->name }} • {{ $laporan->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $laporan->status == 'Sudah Diproses' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $laporan->status }}
                            </span>
                            <a href="{{ route('laporan.show', $laporan) }}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Belum ada laporan</p>
                    @endforelse
                </div>
            </div>

            <!-- Daftar Users -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Users Terbaru</h2>
                <div class="space-y-4">
                    @forelse(\App\Models\User::latest()->take(5)->get() as $user)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' :
                               ($user->role == 'petugas' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Belum ada users</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
