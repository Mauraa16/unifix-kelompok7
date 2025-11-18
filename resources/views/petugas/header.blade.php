{{-- 
    HEADER KHUSUS PETUGAS
    Lokasi: resources/views/petugas/layout/header.blade.php
--}}

<nav class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white shadow-md fixed w-full z-10" style="height: 70px;">
    <div class="container mx-auto px-4 h-full">
        <div class="flex justify-between items-center h-full">

            {{-- LOGO --}}
            <div class="flex items-center space-x-6">
                <a href="{{ route('petugas.dashboard.index') }}" 
                   class="text-2xl font-bold text-white hover:text-gray-200">
                    UNIFIX
                </a>

                {{-- MENU DESKTOP --}}
                <div class="hidden md:flex items-center space-x-4">

                    {{-- Dashboard --}}
                    <a href="{{ route('petugas.dashboard.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('petugas.dashboard.index') 
                                    ? 'bg-purple-900 bg-opacity-50' 
                                    : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>

                    {{-- Semua Laporan --}}
                    <a href="{{ route('laporan.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('petugas/laporan/index') 
                                    ? 'bg-purple-900 bg-opacity-50' 
                                    : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                        <i class="fas fa-clipboard-list mr-1"></i> Laporan
                    </a>

                    {{-- Riwayat --}}
                    <a href="{{ route('petugas.riwayat') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('petugas/riwayat') 
                                    ? 'bg-purple-900 bg-opacity-50' 
                                    : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                        <i class="fas fa-history mr-1"></i> Riwayat
                    </a>

                    {{-- Profil --}}
                    <a href="{{ route('petugas.profil') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->is('petugas/profil') 
                                    ? 'bg-purple-900 bg-opacity-50' 
                                    : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                        <i class="fas fa-user mr-1"></i> Profil
                    </a>

                </div>
            </div>

            {{-- USER INFO & LOGOUT --}}
            <div class="flex items-center gap-4">

                @auth
                <div class="hidden md:flex items-center gap-4">
                    <div class="flex items-center gap-3 bg-white/10 px-3 py-1.5 rounded-full border border-white/20">
                        <div class="w-7 h-7 rounded-full bg-white text-purple-700 flex items-center justify-center text-xs font-bold">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-purple-200 leading-none mt-0.5">Petugas</span>
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form-petugas').submit();"
                       class="bg-red-500/20 hover:bg-red-500 text-white p-2 rounded-full transition duration-200 border border-red-400/30"
                       title="Keluar">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </a>

                    <form id="logout-form-petugas" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
                @endauth

                {{-- MOBILE MENU TOGGLE --}}
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" 
                            class="mobile-menu-toggle p-2 rounded-md hover:bg-purple-500 hover:bg-opacity-30 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div id="mobileMenu" 
         class="hidden md:hidden absolute top-[70px] left-0 w-full bg-purple-700 shadow-lg z-0">

        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">

            <a href="{{ route('petugas.dashboard.index') }}"
               class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 
                      {{ request()->routeIs('petugas.dashboard.index') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>

            <a href="{{ route('petugas.laporan.index') }}"
               class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 
                      {{ request()->is('petugas/laporan') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-clipboard-list mr-2"></i> Laporan
            </a>

            <a href="{{ route('petugas.riwayat') }}"
               class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 
                      {{ request()->is('petugas/riwayat') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-history mr-2"></i> Riwayat
            </a>

            <a href="{{ route('petugas.profil') }}"
               class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-500 
                      {{ request()->is('petugas/profil') ? 'bg-purple-900' : '' }}">
                <i class="fas fa-user mr-2"></i> Profil
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
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile-petugas').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>

                <form id="logout-form-mobile-petugas" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
            @endauth

        </div>
    </div>
</nav>
