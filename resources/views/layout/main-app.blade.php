{{-- Layout atau template halaman utama --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Perpustakaan Politeknik Negeri Batam</title>

    @vite('resources/css/app.css')

    <style>
        .slider-thumb {
            pointer-events: none;
        }

        .slider-thumb::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            border: 2px solid #3b82f6;
            cursor: pointer;
            pointer-events: all;
        }

        .slider-thumb::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            border: 2px solid #3b82f6;
            cursor: pointer;
            pointer-events: all;
        }
    </style>
</head>

<body class="bg-gray-200 max-w-480 mx-auto overflow-x-hidden poppins antialiased">
    @include('components.navbar')
    @if (Route::is('home-page', 'cari-buku-page'))
        @include('components.hero')
    @endif
    @yield('content')
    @include('components.footer')
    @include('components.alert')
</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

</html>
