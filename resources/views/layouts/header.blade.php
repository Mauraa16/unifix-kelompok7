<nav x-data="{ open: false }" class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white shadow-md fixed w-full z-50" style="height: 70px;">
    <div class="container mx-auto px-4 h-full">
        <div class="flex justify-between items-center h-full">
            
            {{-- BAGIAN KIRI: Logo & Menu --}}
            <div class="flex items-center space-x-6">
                {{-- Logo Gambar & Teks --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 decoration-none group">
                    {{-- Pastikan file logo.png ada di public/images/ --}}
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Logo UNIFIX" 
                         class="h-12 w-auto object-contain">
                </a>
                
                {{-- Menu Desktop --}}
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('mahasiswa.beranda') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition decoration-none flex items-center
                              {{ request()->routeIs('mahasiswa.beranda') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-home mr-2"></i> Beranda
                    </a>
                    
                    <a href="{{ route('laporan.index') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition decoration-none flex items-center
                              {{ request()->routeIs('laporan.index') || request()->routeIs('laporan.show') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-clipboard-list mr-2"></i> Laporan Saya
                    </a>

                    <a href="{{ route('laporan.create') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition decoration-none flex items-center
                              {{ request()->routeIs('laporan.create') ? 'bg-purple-900 bg-opacity-50' : 'hover:bg-purple-500 hover:bg-opacity-30' }}">
                       <i class="fas fa-plus-circle mr-2"></i> Buat Laporan
                    </a>
                </div>
            </div>

            {{-- BAGIAN KANAN: Profil User --}}
            <div class="flex items-center gap-4">
                @auth
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('mahasiswa.profil') }}" 
                       class="flex items-center gap-3 bg-white/10 px-3 py-1.5 rounded-full border border-white/20 hover:bg-white/20 transition decoration-none group"
                       title="Lihat Profil">
                        <div class="w-7 h-7 rounded-full bg-white text-purple-700 flex items-center justify-center text-xs font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold leading-none text-white group-hover:text-gray-100">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="text-[10px] text-purple-200 leading-none mt-0.5">Mahasiswa</span>
                        </div>
                    </a>

                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form-mhs').submit();"
                       class="bg-red-500/20 hover:bg-red-500 text-white p-2 rounded-full transition duration-200 border border-red-400/30 flex items-center justify-center decoration-none"
                       title="Keluar">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </a>
                    <form id="logout-form-mhs" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
                @else
                 <a href="{{ route('login') }}" class="text-sm font-medium hover:text-gray-200 decoration-none">Login</a>
                @endauth
                
                {{-- Tombol Hamburger --}}
                <div class="md:hidden">
                    <button @click="open = ! open" class="mobile-menu-toggle p-2 rounded-md hover:bg-purple-500 hover:bg-opacity-30 transition focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="open" 
         @click.away="open = false"
         class="md:hidden absolute top-[70px] left-0 w-full bg-purple-700 shadow-lg z-0 border-t border-purple-500"
         style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('mahasiswa.beranda') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-600 decoration-none text-white flex items-center {{ request()->routeIs('mahasiswa.beranda') ? 'bg-purple-800' : '' }}">
                <i class="fas fa-home mr-3 w-5 text-center"></i> Beranda
            </a>
            <a href="{{ route('laporan.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-600 decoration-none text-white flex items-center {{ request()->routeIs('laporan.*') ? 'bg-purple-800' : '' }}">
                <i class="fas fa-clipboard-list mr-3 w-5 text-center"></i> Laporan Saya
            </a>
            <a href="{{ route('laporan.create') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-purple-600 decoration-none text-white flex items-center {{ request()->routeIs('laporan.create') ? 'bg-purple-800' : '' }}">
                <i class="fas fa-plus-circle mr-3 w-5 text-center"></i> Buat Laporan
            </a>
            @auth
            <div class="border-t border-purple-500 pt-4 mt-2 pb-2">
                <div class="flex items-center px-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-purple-800 flex items-center justify-center border-2 border-purple-400 text-white font-bold">
                         {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-purple-300">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('mahasiswa.profil') }}" class="block px-3 py-2 rounded-md text-base font-medium text-purple-100 hover:bg-purple-600 hover:text-white decoration-none flex items-center {{ request()->routeIs('mahasiswa.profil') ? 'bg-purple-800 text-white' : '' }}">
                    <i class="fas fa-user-circle mr-3 w-5 text-center"></i> Profil Saya
                </a>
                <a href="{{ route('logout') }}" class="block px-3 py-2 rounded-md text-base font-medium text-purple-100 hover:bg-red-500 hover:text-white decoration-none flex items-center mt-1"
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile-mhs').submit();">
                   <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Keluar
                </a>
                <form id="logout-form-mobile-mhs" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
            @endauth
        </div>
    </div>
</nav>