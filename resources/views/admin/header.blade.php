{{-- 
    Ini adalah header KHUSUS ADMIN.
    Lokasi: resources/views/admin/header.blade.php
--}}
<nav class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white shadow-md fixed w-full z-10" style="height: 70px;">
    <div class="container mx-auto px-4 h-full">
        <div class="flex justify-between items-center h-full">
            
            <div class="flex items-center space-x-6">
                <a href="{{ url('/home') }}" class="text-2xl font-bold text-white hover:text-gray-200">UNIFIX</a>
                
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('home') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('home') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    
                    {{-- Link Kelola Mahasiswa --}}
                    <a href="{{ route('mahasiswa.index') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('admin/mahasiswa*') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-user-graduate mr-1"></i> Kelola Mahasiswa
                    </a>

                    {{-- Link Kelola Petugas --}}
                    <a href="{{ route('petugas.index') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('admin/petugas*') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-user-shield mr-1"></i> Kelola Petugas
                    </a>

                    {{-- Link Kelola Laporan (SUDAH DIPERBAIKI) --}}
                    <a href="{{ route('admin.laporan.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('admin/laporan*') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-clipboard-list mr-1"></i> Kelola Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                
                @auth
                <div class="hidden md:flex items-center gap-4">
                    <div class="flex items-center gap-3 bg-white/10 px-3 py-1.5 rounded-full border border-white/20">
                        <div class="w-7 h-7 rounded-full bg-white text-purple-700 flex items-center justify-center text-xs font-bold">
                             <i class="fas fa-user"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-purple-200 leading-none mt-0.5">Administrator</span>
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();"
                       class="bg-red-500/20 hover:bg-red-500 text-white p-2 rounded-full transition duration-200 border border-red-400/30"
                       title="Keluar">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </a>
                    <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
                @endauth
                
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="mobile-menu-toggle p-2 rounded-md hover:bg-purple-500 hover:bg-opacity-30 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="hidden md:hidden absolute top-[70px] left-0 w-full bg-purple-700 shadow-lg z-0">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 {{ request()->is('home') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="{{ route('mahasiswa.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 {{ request()->is('admin/mahasiswa*') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-user-graduate mr-2"></i> Kelola Mahasiswa
            </a>
            <a href="{{ route('petugas.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 {{ request()->is('admin/petugas*') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-user-shield mr-2"></i> Kelola Petugas
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 {{ request()->is('admin/laporan*') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-clipboard-list mr-2"></i> Kelola Laporan
            </a>
            
            @auth
            <div class="border-t border-purple-500 pt-4 pb-2">
                <div class="flex items-center px-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-purple-800 flex items-center justify-center border-2 border-purple-400">
                         <i class="fas fa-user"></i>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-purple-300">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('logout') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-purple-200 hover:bg-red-500"
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>