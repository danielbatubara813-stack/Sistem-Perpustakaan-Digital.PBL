<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar | Perpustakaan Politeknik Negeri Batam</title>

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

            <!-- Right Side Wrapper (to contain floating button without clipping) -->
            <div class="w-full lg:w-[450px] xl:w-[500px] h-screen relative shrink-0 z-20">
                
                <!-- Back Button (Floating on desktop) -->
                <div class="hidden lg:block absolute top-12 -left-36 xl:-left-40 z-30">
                    <a href="{{ route('home-page') ?? '/' }}"
                        class="inline-flex items-center justify-center gap-2 bg-white text-black px-5 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-gray-100 transition-colors border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-left">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Scrolling Form Card -->
                <div class="w-full h-full bg-white flex flex-col pt-6 pb-6 px-8 lg:px-10 shadow-2xl rounded-l-lg overflow-y-auto">
                    
                    <!-- Mobile Back Button -->
                    <div class="flex justify-start mb-2 lg:hidden">
                        <a href="{{ route('home-page') ?? '/' }}"
                            class="inline-flex items-center justify-center gap-2 bg-white text-black px-4 py-2 rounded-lg text-sm font-bold shadow border border-gray-200 hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-left">
                                <path d="m12 19-7-7 7-7" />
                                <path d="M19 12H5" />
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <!-- Form Container -->
                    <div class="flex-1 flex flex-col justify-center w-full max-w-sm mx-auto mt-2 lg:mt-0">
                        <h2 class="text-3xl font-extrabold text-black mb-1">Daftar Akun!</h2>
                        <p class="text-[13px] text-gray-500 mb-6 font-medium">Daftarkan akun anda ke perpustakaan digital
                        </p>

                        <form method="POST" action="/register" class="space-y-4">
                            @csrf

                            <!-- NIK/NIBN -->
                            <div class="space-y-1.5 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-user">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    NIK / NIBN
                                </label>
                                <input type="text" name="nik"
                                    class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            <!-- Email -->
                            <div class="space-y-1.5 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-user">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Email
                                </label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="space-y-1.5 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-user-check">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <polyline points="16 11 18 13 22 9" />
                                    </svg>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name"
                                    class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            <!-- No Handphone -->
                            <div class="space-y-1.5 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-phone">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                    No Handphone
                                </label>
                                <input type="text" name="no_handphone"
                                    class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            <!-- Kata Sandi -->
                            <div class="space-y-1.5 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-lock">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Kata Sandi
                                </label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            <!-- Konfirmasi Kata Sandi -->
                            <div class="space-y-1.5 text-start">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-lock">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Konfirmasi Kata Sandi
                                </label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>

                            @if ($errors->any())
                                <div class="text-red-500 text-sm mt-2 font-bold text-center">
                                    Terjadi kesalahan, cek kembali inputan Anda.
                                </div>
                            @endif

                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full bg-[#2a2c85] text-white font-bold py-3 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                                    DAFTAR
                                </button>
                            </div>

                            <div class="text-center mt-3 text-xs font-bold text-black pb-2">
                                Sudah punya akun? <a href="{{ route('login-page') ?? '/login' }}"
                                    class="text-blue-600 hover:text-blue-800 hover:underline transition-colors w-full">Masuk</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>