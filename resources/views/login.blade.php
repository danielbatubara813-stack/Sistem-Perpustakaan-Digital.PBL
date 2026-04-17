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
        <div class="relative z-20 w-full h-full flex">

            <!-- Left Side (Text content only) -->
            <div class="flex-1 hidden lg:flex flex-col justify-between p-8 lg:p-12">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img class="w-16 h-16 rounded-md p-1 object-contain"
                        src="https://upload.wikimedia.org/wikipedia/id/thumb/2/2c/Politeknik_Negeri_Batam.png/1280px-Politeknik_Negeri_Batam.png"
                        alt="Logo Polibatam" />
                    <div class="leading-none text-white flex flex-col justify-center">
                        <h1 class="poppins font-extrabold text-lg lg:text-xl tracking-wide m-0">Library</h1>
                        <h1 class="poppins font-extrabold text-lg lg:text-xl tracking-wide m-0">Polibatam</h1>
                    </div>
                </div>

                <!-- Text Bottom -->
                <div>
                    <h1 class="text-white text-5xl lg:text-6xl font-extrabold mb-3 tracking-wide">Hey! Hallo!</h1>
                    <p class="text-white text-base lg:text-lg max-w-sm font-semibold leading-snug">
                        Selamat datang di website Perpustakaan Politeknik negeri Batam
                    </p>
                </div>
            </div>

            <!-- Right Side (Full height Login Card) -->
            <div class="w-full lg:w-6/12 xl:w-5/12 h-screen flex items-center justify-center px-4 lg:px-12">

                <div class="relative w-full max-w-md">

                    <!-- Back Button (floating to the left of the card) -->
                    <a href="{{ route('home-page') ?? '/' }}"
                        class="absolute top-0 -left-36 inline-flex items-center justify-center gap-2 bg-white text-black px-5 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-gray-100 transition-colors whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-left">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                        Kembali
                    </a>

                    <!-- Login Card -->
                    <div class="w-full bg-white rounded-3xl shadow-2xl px-10 py-12">

                        <h2 class="text-3xl font-extrabold text-black text-center mb-2">Selamat Datang!</h2>
                        <p class="text-sm text-gray-500 text-center mb-8 font-medium">
                            Masuk untuk dapat melakukan peminjaman buku
                        </p>

                        <form method="POST" action="/login" class="space-y-6">
                            @csrf

                            <!-- Email / Member ID -->
                            <div class="space-y-2 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Email / Member ID
                                </label>
                                <input type="text" name="login_id"
                                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            <!-- Kata Sandi -->
                            <div class="space-y-2 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Kata Sandi
                                </label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>

                                @if(!Route::is("admin.login-page"))
                                <div class="text-right mt-2">
                                    <a href="#"
                                        class="text-[11px] font-bold text-gray-800 hover:text-blue-800 transition-colors">Lupa
                                        kata sandi?</a>
                                </div>
                                @endif
                            </div>

                            @if (session('error'))
                                <div class="text-red-500 text-sm mt-2 font-bold text-center">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full bg-blue-800 text-white font-bold py-3.5 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                                    Masuk
                                </button>
                            </div>

                            @if(!Route::is("admin.login-page"))
                            <div class="text-center mt-6 text-xs font-bold text-black">
                                Belum punya akun?
                                <a href="{{ route('register-page') }}"
                                    class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">Daftar</a>
                            </div>
                            @endif

                        </form>
                    </div>
                    <!-- End Login Card -->

                </div>
            </div>
            <!-- End Right Side -->

        </div>
    </div>
</body>

</html>