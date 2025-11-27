@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profil Petugas</h1>
            <p class="text-gray-600 mt-2">Kelola informasi akun Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar Menu -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- User Info Card -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                <span class="text-xl font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h2 class="font-bold text-lg">{{ Auth::user()->name }}</h2>
                                <p class="text-purple-100 text-sm">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-1 bg-white/20 rounded-full text-xs">
                                    <i class="fas fa-shield-alt mr-1"></i>Petugas
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="p-4">
                        <nav class="space-y-1">
                            <a href="#informasi-akun" 
                               class="flex items-center px-3 py-2 text-sm font-medium text-purple-600 bg-purple-50 rounded-lg border border-purple-100">
                                <i class="fas fa-user-circle mr-3 text-purple-500"></i>
                                Informasi Akun
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Statistik Petugas -->
                <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Aktivitas Petugas</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Laporan Ditangani</span>
                            <span class="font-semibold text-purple-600">{{ $totalLaporanDitangani ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Komentar Diberikan</span>
                            <span class="font-semibold text-blue-600">{{ $totalKomentar ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Bergabung Sejak</span>
                            <span class="text-sm text-gray-500">{{ Auth::user()->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Informasi Akun Section -->
                <div id="informasi-akun" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Informasi Akun</h2>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Aktif
                            </span>
                            <button type="button" id="editBtn" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-edit mr-2"></i>Edit Profil
                            </button>
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

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                <span class="text-red-700 font-medium">Terdapat kesalahan dalam pengisian form.</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('petugas.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', Auth::user()->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role (Readonly) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Role
                                </label>
                                <div class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                                    <i class="fas fa-shield-alt mr-2 text-purple-500"></i>Petugas
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Role tidak dapat diubah</p>
                            </div>
                        </div>

                        <!-- Action Buttons (hidden by default) -->
                        <div id="actionButtons" class="hidden flex items-center space-x-3 mt-6 pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-save mr-2"></i>Simpan
                            </button>
                            <button type="button" id="cancelBtn" class="px-6 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                                <i class="fas fa-times mr-2"></i>Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk smooth scroll, active menu, dan edit profil -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll untuk menu
    const menuLinks = document.querySelectorAll('a[href^="#"]');

    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Update active menu
                menuLinks.forEach(link => {
                    link.classList.remove('text-purple-600', 'bg-purple-50', 'border-purple-100');
                    link.classList.add('text-gray-600', 'hover:text-purple-600', 'hover:bg-purple-50');
                });

                this.classList.remove('text-gray-600', 'hover:text-purple-600', 'hover:bg-purple-50');
                this.classList.add('text-purple-600', 'bg-purple-50', 'border-purple-100');
            }
        });
    });

    // Set active menu berdasarkan hash URL
    const currentHash = window.location.hash;
    if (currentHash) {
        const activeLink = document.querySelector(`a[href="${currentHash}"]`);
        if (activeLink) {
            menuLinks.forEach(link => {
                link.classList.remove('text-purple-600', 'bg-purple-50', 'border-purple-100');
                link.classList.add('text-gray-600', 'hover:text-purple-600', 'hover:bg-purple-50');
            });
            activeLink.classList.remove('text-gray-600', 'hover:text-purple-600', 'hover:bg-purple-50');
            activeLink.classList.add('text-purple-600', 'bg-purple-50', 'border-purple-100');
        }
    }

    // Edit Profil Functionality
    const editBtn = document.getElementById('editBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const actionButtons = document.getElementById('actionButtons');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');

    let originalName = nameInput.value;
    let originalEmail = emailInput.value;

    // Enable edit mode
    editBtn.addEventListener('click', function() {
        nameInput.disabled = false;
        emailInput.disabled = false;
        actionButtons.classList.remove('hidden');
        editBtn.style.display = 'none';
    });

    // Cancel edit
    cancelBtn.addEventListener('click', function() {
        nameInput.value = originalName;
        emailInput.value = originalEmail;
        nameInput.disabled = true;
        emailInput.disabled = true;
        actionButtons.classList.add('hidden');
        editBtn.style.display = 'inline-block';
    });
});
</script>
@endsection