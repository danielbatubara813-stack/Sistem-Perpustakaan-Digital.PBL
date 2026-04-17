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
        <img class="absolute top-0 left-0 w-full h-full object-cover z-0"
            src="{{ asset('static/backgroundHero.jpg') }}" alt="Background">
        <div class="absolute top-0 left-0 w-full h-full bg-black/60 z-10"></div>

        <div class="relative z-20 w-full h-full flex">

            <!-- Left Side -->
            <div class="flex-1 hidden lg:flex flex-col justify-between p-8 lg:p-12">
                <div class="flex items-center gap-3">
                    <img class="w-16 h-16 rounded-md p-1 object-contain"
                        src="https://upload.wikimedia.org/wikipedia/id/thumb/2/2c/Politeknik_Negeri_Batam.png/1280px-Politeknik_Negeri_Batam.png"
                        alt="Logo Polibatam" />
                    <div class="leading-none text-white flex flex-col justify-center">
                        <h1 class="poppins font-extrabold text-lg lg:text-xl tracking-wide m-0">Library</h1>
                        <h1 class="poppins font-extrabold text-lg lg:text-xl tracking-wide m-0">Polibatam</h1>
                    </div>
                </div>

                <div>
                    <h1 class="text-white text-5xl lg:text-6xl font-extrabold mb-3 tracking-wide">Hey! Hallo!</h1>
                    <p class="text-white text-base lg:text-lg max-w-sm font-semibold leading-snug">
                        Selamat datang di website Perpustakaan Politeknik negeri Batam
                    </p>
                </div>
            </div>

            <!-- Right Side -->
            <div class="w-full lg:w-6/12 xl:w-5/12 h-screen flex items-center justify-center px-4 lg:px-12">

                <div class="relative w-full max-w-md">

                    <!-- Back Button -->
                    <a href="{{ route('home-page') ?? '/' }}"
                        class="absolute top-0 -left-36 inline-flex items-center justify-center gap-2 bg-white text-black px-5 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-gray-100 transition-colors whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                        Kembali
                    </a>

                    <!-- Register Card -->
                    <div class="w-full bg-white rounded-3xl shadow-2xl px-10 py-8 max-h-[92vh] overflow-y-auto">

                        <h2 class="text-3xl font-extrabold text-black mb-1">Selamat Datang!</h2>
                        <p class="text-[13px] text-gray-500 mb-6 font-medium">
                            Daftarkan akun anda dan nikmati berbagai koleksi buku kami!
                        </p>

                        <form method="POST" action="/register" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <!-- Email -->
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                    Email
                                </label>
                                <input type="email" name="email" placeholder="Email"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                            </div>

                            <!-- NIK / NIDN -->
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="16" rx="2" />
                                        <path d="M7 8h6" /><path d="M7 12h4" /><path d="M7 16h2" />
                                    </svg>
                                    Nomor Identitas (NIK / NIDN)
                                </label>
                                <input type="text" name="nik" placeholder="NIK / NIDN"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" placeholder="Nama Lengkap"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                            </div>

                            <!-- Instansi & Jenis Kelamin -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="14" rx="2" />
                                            <path d="M8 9h8" /><path d="M8 13h6" />
                                        </svg>
                                        Instansi
                                    </label>
                                    <input type="text" name="instansi" placeholder="Instansi"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                </div>

                                <div class="space-y-1">
                                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                        Jenis Kelamin
                                    </label>
                                    <select name="gender"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- No Telepon & Tanggal Lahir -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127 1.04.306 2.07.54 3.07a2 2 0 0 1-.45 1.96L7.91 8.52a16 16 0 0 0 6.07 6.07l1.77-1.77a2 2 0 0 1 1.96-.45c1 .235 2.03.414 3.07.54A2 2 0 0 1 22 16.92z" />
                                        </svg>
                                        No Telepon
                                    </label>
                                    <input type="text" name="no_handphone" placeholder="No Telepon"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                </div>

                                <div class="space-y-1">
                                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <path d="M16 2v4" /><path d="M8 2v4" /><path d="M3 10h18" />
                                        </svg>
                                        Tanggal Lahir
                                    </label>
                                    <input type="date" name="tanggal_lahir"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                </div>
                            </div>

                            <!-- Photo KTP (full width) -->
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3z" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                    Photo KTP
                                </label>
                                <input type="file" name="photo_ktp" accept="image/*"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                            </div>

                            <!-- Kata Sandi & Konfirmasi -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                        </svg>
                                        Kata Sandi
                                    </label>
                                    <input type="password" name="password" placeholder="Kata Sandi"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                </div>

                                <div class="space-y-1">
                                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                        </svg>
                                        Konfirmasi Kata Sandi
                                    </label>
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                                    <p class="font-semibold">Terjadi kesalahan, silakan periksa kembali inputan Anda.</p>
                                    <ul class="mt-2 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full bg-blue-800 text-white font-bold py-3.5 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                                    Daftar Akun
                                </button>
                            </div>

                            <div class="text-center mt-4 text-xs font-bold text-black">
                                Sudah punya akun?
                                <a href="{{ route('login-page') ?? '/login' }}"
                                    class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">Masuk</a>
                            </div>

                        </form>
                    </div>
                    <!-- End Register Card -->

                </div>
            </div>
            <!-- End Right Side -->

        </div>
    </div>
</body>

</html>