@extends('layouts.auth')

@section('title', 'Register - UNIFIX')

@section('content')

<div class="relative flex min-h-screen items-center justify-center overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('{{ asset('images/background_login.jpg') }}');">
    </div>

    <!-- Overlay Ungu -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#667eea]/50 to-[#764ba2]/50"></div>

    <!-- Card -->
    <main class="relative z-10 w-full max-w-md px-4">
        <div class="bg-black/30 backdrop-blur-lg border border-white/20 rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,0.40)]">

            <div class="p-8 space-y-8">

                <!-- Header -->
                <div class="text-center">
                    <span class="flex items-center gap-5 justify-center mt-1">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="Logo UNIFIX" 
                             class="w-15 h-10 object-contain drop-shadow-lg">
                    </span>

                    <h1 class="text-white text-3xl font-bold leading-tight">
                        Buat Akun Baru
                    </h1>

                    <p class="text-gray-300 mt-2">
                        Daftar untuk mulai menggunakan UNIFIX
                    </p>
                </div>

                <!-- Tabs -->
                <div class="flex items-center justify-between bg-white/10 p-1 rounded-xl backdrop-blur-md">
                    <button onclick="window.location='{{ route('login') }}'"
                            class="flex-1 text-center py-2 rounded-lg text-gray-200 hover:text-white">
                        Login
                    </button>

                    <button onclick="window.location='{{ route('register') }}'"
                            class="flex-1 text-center py-2 rounded-lg text-white font-medium bg-white/20 shadow">
                        Registrasi
                    </button>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Nama Lengkap</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                account_circle
                            </span>

                            <input type="text" name="name" required autofocus 
                                   class="input-unifix"
                                   placeholder="Nama lengkap"
                                   value="{{ old('name') }}">
                        </div>

                        @error('name')
                        <p class="mt-1 text-red-300 text-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Alamat Email</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                mail
                            </span>

                            <input type="email" name="email" required 
                                   class="input-unifix"
                                   placeholder="contoh@gmail.com"
                                   value="{{ old('email') }}">
                        </div>

                        @error('email')
                        <p class="mt-1 text-red-300 text-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Password</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                lock
                            </span>

                            <input type="password" id="password" name="password" required
                                   class="input-unifix pr-10"
                                   placeholder="Buat password">

                            <button type="button" 
                                    class="absolute right-0 inset-y-0 px-4 text-gray-300 flex items-center"
                                    onclick="togglePassword('password', 'icon-password')">
                                <span class="material-symbols-outlined" id="icon-password">
                                    visibility_off
                                </span>
                            </button>
                        </div>

                        @error('password')
                        <p class="mt-1 text-red-300 text-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Konfirmasi Password</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                lock_reset
                            </span>

                            <input type="password" id="password-confirm" name="password_confirmation" required
                                   class="input-unifix pr-10"
                                   placeholder="Ulangi password">

                            <button type="button"
                                    class="absolute right-0 inset-y-0 px-4 text-gray-300 flex items-center"
                                    onclick="togglePassword('password-confirm', 'icon-confirm')">
                                <span class="material-symbols-outlined" id="icon-confirm">
                                    visibility_off
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Button -->
                    <button type="submit" class="btn-unifix">Daftar</button>
                </form>

                <!-- Divider -->
                <div class="flex items-center">
                    <div class="flex-1 h-px bg-white/20"></div>
                    <span class="px-3 text-gray-300 text-sm">Atau</span>
                    <div class="flex-1 h-px bg-white/20"></div>
                </div>

                <!-- Login Link -->
                <p class="text-center text-gray-300 text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-white font-medium hover:underline">Masuk di sini</a>
                </p>

            </div>
        </div>
    </main>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.textContent = "visibility";
    } else {
        input.type = "password";
        icon.textContent = "visibility_off";
    }
}
</script>

@endsection