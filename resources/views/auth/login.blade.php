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
            <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masuk ke akun <span class="font-semibold text-purple-600">UNIFIX</span> Anda
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                               autofocus
                               class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('email') border-red-500 @enderror"
                               placeholder="email@example.com">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
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
                               autocomplete="current-password"
                               class="w-full px-4 py-3 pl-11 pr-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('password') border-red-500 @enderror"
                               placeholder="Masukkan kata sandi">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword()">
                            <i class="fas fa-eye text-gray-400 hover:text-purple-500 transition-colors" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" 
                               name="remember" 
                               type="checkbox" 
                               {{ old('remember') ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-purple-600 hover:text-purple-500 transition-colors">
                            Lupa kata sandi?
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Informasi Akun</span>
                    </div>
                </div>
            </div>

            <!-- Demo Accounts Info -->
            <div class="mt-6 bg-purple-50 rounded-lg p-4 border border-purple-200">
                <h4 class="text-sm font-semibold text-purple-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Akses Demo:
                </h4>
                <div class="space-y-1 text-xs text-purple-700">
                    <div class="flex justify-between">
                        <span>Admin:</span>
                        <code class="bg-purple-100 px-2 py-1 rounded">admin@unifix.ac.id</code>
                    </div>
                    <div class="flex justify-between">
                        <span>Petugas:</span>
                        <code class="bg-purple-100 px-2 py-1 rounded">petugas@unifix.ac.id</code>
                    </div>
                    <div class="flex justify-between">
                        <span>Mahasiswa:</span>
                        <code class="bg-purple-100 px-2 py-1 rounded">mahasiswa@unifix.ac.id</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-purple-600 hover:text-purple-500 transition-colors">
                    Daftar di sini
                </a>
            </p>
            <p class="mt-2 text-xs text-gray-500">
                &copy; {{ date('Y') }} UNIFIX. Sistem Pelaporan Fasilitas Universitas
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
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

// Add input focus effects
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-purple-200');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-purple-200');
        });
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

/* Smooth transitions for all interactive elements */
button, input, a {
    transition: all 0.2s ease-in-out;
}

/* Focus states for accessibility */
input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
}
</style>
@endsection