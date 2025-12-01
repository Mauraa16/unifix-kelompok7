@extends('layouts.auth')

@section('title', 'Verifikasi Email - UNIFIX')

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

                    <h1 class="text-white text-3xl font-bold leading-tight mt-2">
                        Verifikasi Email Anda
                    </h1>

                    <p class="text-gray-300 mt-2 text-sm">
                        Sebelum melanjutkan, silakan cek email Anda untuk tautan verifikasi.
                    </p>
                </div>

                <!-- Success Message -->
                @if (session('resent'))
                    <div class="bg-green-500/20 text-green-200 text-sm px-4 py-3 rounded-lg flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        Tautan verifikasi baru telah dikirim ke email Anda
                    </div>
                @endif

                <!-- Instruction -->
                <p class="text-gray-300 text-sm leading-relaxed">
                    Jika Anda belum menerima email verifikasi,
                    Anda dapat meminta untuk mengirim ulang tautan.
                </p>

                <!-- Resend Button -->
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-white/20 hover:bg-white/30 text-white font-medium py-3 rounded-xl transition">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <!-- Back to login -->
                <p class="text-center text-gray-300 text-sm mt-4">
                    Kembali ke halaman
                    <a href="{{ route('login') }}" class="text-white font-medium hover:underline">
                        Login
                    </a>
                </p>

            </div>

        </div>

    </main>
</div>

@endsection