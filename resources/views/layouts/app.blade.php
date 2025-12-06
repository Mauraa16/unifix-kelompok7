<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Judul Dinamis (Default: UNIFIX) --}}
    <title>@yield('title', config('app.name', 'UNIFIX'))</title>

    {{-- Favicon (Logo di Tab Browser) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#7e22ce' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    {{-- HEADER --}}
    <header class="z-50">
        @auth
            @if(Auth::user()->role == 'admin')
                @include('admin.header')
            @elseif(Auth::user()->role == 'petugas')
                @include('petugas.header')
            @else
                @include('layouts.header')
            @endif
        @else
            @include('layouts.header')
        @endauth
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow pt-[70px] pb-10">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('layouts.footer')

</body>
</html>