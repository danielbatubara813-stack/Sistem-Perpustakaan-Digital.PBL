<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Perpustakaan Politeknik Negeri Batam</title>

    @vite(['resources/css/app.css', 'resources/css/font.css'])
</head>

<body class="poppins antialiased overflow-hidden">
    <div class="relative w-full h-screen flex bg-black">
        <!-- Background Image (Full screen) -->
        <img class="absolute top-0 left-0 w-full h-full object-cover z-0" src="{{ asset('static/backgroundHero.jpg') }}"
            alt="Background">
        <!-- Overlay (Full screen) -->
        <div class="absolute top-0 left-0 w-full h-full bg-black/60 z-10"></div>

        <!-- Content split screen -->
        <div class="relative z-20 w-full h-full grid lg:grid-cols-2">

            <!-- Left Side -->
            <div class="hidden lg:grid grid-rows-2 h-full px-4 lg:px-12 py-8 lg:py-12">

                <!-- TOP -->
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <img class="w-16 h-16 rounded-md p-1 object-contain"
                            src="https://upload.wikimedia.org/wikipedia/id/thumb/2/2c/Politeknik_Negeri_Batam.png/1280px-Politeknik_Negeri_Batam.png"
                            alt="Logo Polibatam" />
                        <div class="leading-none text-white flex flex-col justify-center">
                            <h1 class="poppins font-extrabold text-lg lg:text-xl tracking-wide m-0">Library</h1>
                            <h1 class="poppins font-extrabold text-lg lg:text-xl tracking-wide m-0">Polibatam</h1>
                        </div>
                    </div>

                    <!-- tombol kanan atas -->
                    <a href="{{ route('home-page') ?? '/' }}"
                        class="ml-auto translate-x-6 lg:translate-x-12 inline-flex items-center gap-2 bg-white text-black px-5 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- BOTTOM -->
                <div class="flex items-end">
                    <div>
                        <h1 class="text-white text-5xl lg:text-6xl font-extrabold mb-3 tracking-wide">
                            Hey! Hallo!
                        </h1>
                        <p class="text-white text-base lg:text-lg max-w-sm font-semibold leading-snug">
                            Selamat datang di website Perpustakaan Politeknik negeri Batam
                        </p>
                    </div>
                </div>

            </div>
            <!-- End Left Side -->

            <!-- Right Side (Full height Login Card) -->
            <div class="w-full h-screen flex items-center px-4 lg:px-12">
                <div class="relative w-full">

                    <!-- Login Card -->
                    <div class="w-full h-[92vh] bg-white rounded-3xl shadow-2xl px-10 py-12 overflow-y-auto">

                        @yield('content')
                        
                    </div>
                    <!-- End Login Card -->

                </div>
            </div>
            <!-- End Right Side -->

        </div>
    </div>
</body>

</html>
