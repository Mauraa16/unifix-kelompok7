<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UNIFIX') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7e22ce', // Warna ungu contoh
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-inter"> 
<div id="app" class="min-h-screen flex flex-col">
    
    {{-- ========================================================== --}}
    {{-- PENYESUAIAN HEADER BERDASARKAN ROLE --}}
    {{-- ========================================================== --}}
    <header>
        @auth
            {{-- User sudah login, cek rolenya --}}
            @if(Auth::user()->role == 'admin')
                {{-- Jika user adalah admin, panggil header admin --}}
                @include('admin.header')

            @elseif(Auth::user()->role === 'petugas')
                @include('petugas.header')
            @else
                {{-- Jika user adalah 'mahasiswa' atau 'petugas', panggil header standar --}}
                @include('layouts.header')
            @endif
        @else
            {{-- User adalah tamu (belum login), panggil header standar --}}
            @include('layouts.header')
        @endauth
    </header>
    {{-- ========================================================== --}}



    <main class="flex-grow pt-20 pb-10"> 
        @yield('content')
    </main>

    @include('layouts.footer')
</div>

<script>
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) dropdown.classList.toggle('hidden'); // Gunakan class hidden Tailwind
    }

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) mobileMenu.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const userDropdown = document.getElementById('userDropdown');
        const userBtn = document.querySelector('.user-btn'); // Pastikan button user punya class ini
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileToggle = document.querySelector('.mobile-menu-toggle'); // Pastikan tombol hamburger punya class ini

        // Logic untuk menutup dropdown user
        if (userDropdown && userBtn && !userBtn.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }

        // Logic untuk menutup menu mobile
        if (mobileMenu && mobileToggle && !mobileToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
</script>
</body>
</html>