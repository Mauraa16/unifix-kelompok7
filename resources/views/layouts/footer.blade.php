<footer class="bg-gradient-to-b from-gray-900 to-purple-900 text-white">
    <div class="container mx-auto px-4 py-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-6">
            
            <div class="lg:col-span-1">
                <div class="flex items-center mb-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 decoration-none group">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="UNIFIX Logo" 
                             class="h-10 w-auto object-contain">
                    </a>
                </div>
                <p class="text-purple-200 text-sm leading-relaxed">
                    Sistem Pelaporan dan Perbaikan Fasilitas Universitas Terintegrasi. 
                    Memberikan solusi cepat dan efisien untuk maintenance kampus.
                </p>
            </div>
            
            <div class="lg:col-span-1">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-concierge-bell mr-2 text-purple-300"></i>
                    Layanan
                </h4>
                <ul class="space-y-2">
                    
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Dashboard Admin
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.laporan.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Pantau Laporan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mahasiswa.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Kelola Mahasiswa
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('petugas.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Kelola Petugas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.profil.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Kelola Profil
                                </a>
                            </li>

                        @elseif (Auth::user()->role === 'petugas')
                            <li>
                                <a href="{{ route('petugas.dashboard.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Dashboard Petugas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('petugas.laporan.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Kelola Laporan Masuk
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('petugas.riwayat') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Riwayat Tugas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('petugas.profil') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Kelola Profil
                                </a>
                            </li>

                        @else
                            <li>
                                <a href="{{ route('mahasiswa.beranda') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Beranda
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.create') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Buat Laporan Baru
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.index') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Status & Riwayat Laporan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mahasiswa.profil') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                    Kelola Profil
                                </a>
                            </li>
                        @endif

                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-purple-200 hover:text-white transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Daftar
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>

            <div class="lg:col-span-1">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-purple-300"></i>
                    Informasi & Kontak
                </h4>
                <div class="space-y-3">
                    
                    <div class="flex items-center text-purple-200 text-sm">
                        <i class="fas fa-clock mr-3 text-purple-300"></i>
                        <span>Senin - Jumat: 08:00 - 16:00</span>
                    </div>

                    <div class="flex items-center text-purple-200 text-sm">
                        <i class="fas fa-map-marker-alt mr-3 text-purple-300"></i>
                        <span>Gedung Rektorat Lt. 2</span>
                    </div>
                    
                    <div class="flex items-center text-purple-200 text-sm">
                        <i class="fas fa-envelope mr-3 text-purple-300"></i>
                        <a href="mailto:support@unifix.ac.id" class="hover:text-white transition-colors duration-200">support@unifix.ac.id</a>
                    </div>
                    
                    <div class="flex items-center text-purple-200 text-sm">
                        <i class="fab fa-instagram mr-3 text-purple-300"></i>
                        <a href="https://instagram.com/UNIFIX_Kampus" target="_blank" class="hover:text-white transition-colors duration-200">@UNIFIX_Kampus</a>
                    </div>
                    
                </div>
            </div>
            
        </div> 
        
        <div class="border-t border-purple-700 pt-6"> 
            <div class="flex flex-col items-center">
                <div class="text-center">
                    <p class="text-purple-300 text-sm">
                        &copy; 2025 <span class="font-semibold text-white">UNIFIX</span>. All rights reserved.
                    </p>
                    <p class="text-purple-400 text-xs mt-1">
                        Sistem Pelaporan Fasilitas Universitas
                    </p>
                </div>
            </div>
        </div>
        
    </div>
</footer>

<div class="fixed bottom-6 right-6 z-50">
    <button class="w-14 h-14 bg-purple-600 hover:bg-purple-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 group"
            onclick="openSupportModal()">
        <i class="fas fa-headset text-xl"></i>
        <span class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center animate-pulse">
            <i class="fas fa-bolt"></i>
        </span>
    </button>
</div>

<div id="supportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 rounded-t-xl">
            <div class="flex justify-between items-center">
                <h3 class="text-white font-bold text-lg flex items-center">
                    <i class="fas fa-headset mr-2"></i>
                    Butuh Bantuan?
                </h3>
                <button onclick="closeSupportModal()" class="text-white hover:text-purple-200 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <p class="text-gray-600 mb-4">
                Tim support kami siap membantu Anda 24/7. Pilih metode kontak yang prefered:
            </p>
            
            <div class="space-y-3">
                <a href="tel:+622112345678" 
                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 transition-colors group">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-phone text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Telepon</p>
                        <p class="text-sm text-gray-600">+62 (021) 1234-5678</p>
                    </div>
                </a>
                
                <a href="mailto:support@unifix.ac.id" 
                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 transition-colors group">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-envelope text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Email</p>
                        <p class="text-sm text-gray-600">unifixa00@gmail.com</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openSupportModal() {
    document.getElementById('supportModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeSupportModal() {
    document.getElementById('supportModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

document.getElementById('supportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSupportModal();
    }
});
</script>