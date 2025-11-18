@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <i class="fas fa-tools text-3xl text-purple-600"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
            <p class="mt-2 text-sm text-gray-600">
                Daftar untuk mengakses <span class="font-semibold text-purple-600">UNIFIX</span>
            </p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autocomplete="name" 
                               autofocus
                               class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-purple-500"></i>
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email"
                               class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('email') border-red-500 @enderror"
                               placeholder="email@example.com">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 pl-11 pr-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('password') border-red-500 @enderror"
                               placeholder="Buat kata sandi yang kuat">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password')">
                            <i class="fas fa-eye text-gray-400 hover:text-purple-500 transition-colors" id="eye-icon-password"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="mt-2">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimal 8 karakter dengan kombinasi huruf dan angka
                        </div>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password-confirm" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 pl-11 pr-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                               placeholder="Ulangi kata sandi">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password-confirm')">
                            <i class="fas fa-eye text-gray-400 hover:text-purple-500 transition-colors" id="eye-icon-confirm"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms Agreement -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               required
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            Saya menyetujui 
                            <a href="#" class="font-medium text-purple-600 hover:text-purple-500 transition-colors">
                                Syarat & Ketentuan
                            </a> 
                            dan 
                            <a href="#" class="font-medium text-purple-600 hover:text-purple-500 transition-colors">
                                Kebijakan Privasi
                            </a>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Sudah punya akun?</span>
                    </div>
                </div>
            </div>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-500 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk ke akun yang sudah ada
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center">
            <div class="bg-white rounded-lg p-4 border border-purple-200">
                <h4 class="text-sm font-semibold text-purple-800 mb-2 flex items-center justify-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Keamanan Terjamin
                </h4>
                <div class="grid grid-cols-3 gap-2 text-xs text-purple-700">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-lock mb-1"></i>
                        <span>Data Aman</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="fas fa-user-shield mb-1"></i>
                        <span>Privasi</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="fas fa-check-circle mb-1"></i>
                        <span>Terverifikasi</span>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500">
                &copy; {{ date('Y') }} UNIFIX. Sistem Pelaporan Fasilitas Universitas
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById('eye-icon-' + (fieldId === 'password' ? 'password' : 'confirm'));
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// Password strength indicator (optional enhancement)
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password-confirm');
    
    // Add input focus effects
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-purple-200');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-purple-200');
        });
    });
    
    // Real-time password confirmation check
    confirmInput.addEventListener('input', function() {
        if (passwordInput.value !== this.value && this.value.length > 0) {
            this.classList.add('border-red-300');
            this.classList.remove('border-green-300');
        } else if (passwordInput.value === this.value && this.value.length > 0) {
            this.classList.remove('border-red-300');
            this.classList.add('border-green-300');
        } else {
            this.classList.remove('border-red-300', 'border-green-300');
        }
    });
});
</script>

<style>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #c4b5fd;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a78bfa;
}

/* Smooth transitions */
button, input, a {
    transition: all 0.2s ease-in-out;
}

/* Focus states */
input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
}

/* Password strength animation */
@keyframes pulse-green {
    0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
    100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

.border-green-300 {
    animation: pulse-green 2s infinite;
}
</style>
@endsection