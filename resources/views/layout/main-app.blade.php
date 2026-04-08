{{-- Layout atau template halaman utama --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library | Perpustakaan Politeknik Negeri Batam</title>

    @vite(['resources/css/app.css', 'resources/css/font.css'])
</head>

<body class="bg-gray-200 max-w-480 mx-auto overflow-x-hidden poppins">
    @include('components.navbar')
    @yield('content')
    @include('components.footer')
</body>

</html>
