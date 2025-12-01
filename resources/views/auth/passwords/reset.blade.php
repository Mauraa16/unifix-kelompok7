@extends('layouts.auth')

@section('title', 'Reset Password - UNIFIX')

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
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Logo UNIFIX" 
                         class="w-15 h-10 object-contain drop-shadow-lg mx-auto">

                    <h1 class="text-white text-3xl font-bold mt-3">
                        Reset Password
                    </h1>

                    <p class="text-gray-300 mt-2">
                        Masukkan password baru kamu.
                    </p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Alamat Email</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                mail
                            </span>

                            <input type="email" id="email" name="email" required autofocus
                                   value="{{ $email ?? old('email') }}"
                                   class="input-unifix"
                                   placeholder="contoh@gmail.com">
                        </div>

                        @error('email')
                        <p class="mt-1 text-red-300 text-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Password Baru</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                lock
                            </span>

                            <input type="password" id="password" name="password" required
                                   class="input-unifix pr-10"
                                   placeholder="Password baru">

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

                    <!-- Konfirmasi -->
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
                    <button type="submit" class="btn-unifix">
                        Reset Password
                    </button>
                </form>

                <!-- Back to Login -->
                <p class="text-center text-gray-300 text-sm mt-4">
                    Kembali ke  
                    <a href="{{ route('login') }}" class="text-white font-medium hover:underline">
                        Halaman Login
                    </a>
                </p>

            </div>
        </div>
    </main>
</div>

<script>
function togglePassword(id, iconId) {
    const input = document.getElementById(id);
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