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
                         class="w-15 h-10 mx-auto drop-shadow-lg">

                    <h1 class="text-white text-3xl font-bold mt-3">Reset Password</h1>

                    <p class="text-gray-300 mt-2">
                        Masukkan email Anda untuk menerima tautan reset password
                    </p>
                </div>

                <!-- Status success -->
                @if (session('status'))
                    <div class="text-green-300 text-sm bg-green-900/30 border border-green-500/30 px-4 py-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="text-gray-200 text-sm font-medium">Alamat Email</label>

                        <div class="relative mt-2">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-300">
                                mail
                            </span>

                            <input id="email" type="email" name="email"
                                class="input-unifix"
                                placeholder="contoh@gmail.com"
                                value="{{ old('email') }}" required autofocus>
                        </div>

                        @error('email')
                        <p class="mt-1 text-red-300 text-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-unifix">
                        Kirim Link Reset Password
                    </button>

                </form>

                <!-- Back to login -->
                <p class="text-center text-gray-300 text-sm mt-4">
                    Kembali ke
                    <a href="{{ route('login') }}" class="text-white font-medium hover:underline">
                        halaman login
                    </a>
                </p>

            </div>
        </div>
    </main>
</div>

@endsection