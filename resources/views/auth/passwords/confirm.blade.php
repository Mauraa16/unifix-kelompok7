@extends('layouts.auth')

@section('title', 'Konfirmasi Password - UNIFIX')

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
                         class="w-16 h-12 mx-auto drop-shadow-lg">

                    <h1 class="text-white text-3xl font-bold mt-3">
                        Konfirmasi Password
                    </h1>

                    <p class="text-gray-300 mt-2 text-sm">
                        Silakan masukkan password Anda untuk melanjutkan
                    </p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <!-- Input Password -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Password</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined
                                         absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                lock
                            </span>

                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   class="input-unifix pr-12 @error('password') border-red-400 @enderror"
                                   placeholder="Masukkan password">

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

                    <!-- Button -->
                    <button type="submit" class="btn-unifix">
                        Konfirmasi
                    </button>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <p class="text-center mt-2">
                            <a href="{{ route('password.request') }}"
                               class="text-gray-300 hover:text-white text-sm hover:underline">
                                Lupa password?
                            </a>
                        </p>
                    @endif
                </form>

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