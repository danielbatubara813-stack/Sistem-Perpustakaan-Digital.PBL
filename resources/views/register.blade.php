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

        <div class="relative z-20 w-full h-full flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 hidden lg:flex flex-col justify-between p-8 lg:p-12">
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

            <div class="w-full lg:w-1/2 h-full flex items-center justify-center px-4 py-8 lg:px-12 relative shrink-0 z-20">
                <div class="w-full max-w-155 relative">
                    <div class="flex justify-start mb-6 lg:mb-0 lg:absolute lg:top-12 lg:-left-36 xl:-left-40 z-30">
                        <a href="{{ route('home-page') ?? '/' }}"
                            class="inline-flex items-center justify-center gap-2 bg-white text-black px-5 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-left">
                                <path d="m12 19-7-7 7-7" />
                                <path d="M19 12H5" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                    <div class="bg-white shadow-[0_35px_80px_-40px_rgba(15,23,42,0.25)] rounded-4x1 p-6 sm:p-8 lg:p-10 border border-slate-200">
                        <div class="w-full">
                            <h2 class="text-3xl font-extrabold text-black mb-1">Daftar Akun!</h2>
                            <p class="text-[13px] text-gray-500 mb-8 font-medium">Daftarkan akun anda ke perpustakaan digital</p>
                        </div>

                        <form method="POST" action="/register" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-mail">
                                    <path d="M4 4h16v16H4z" />
                                    <path d="M22 6 12 13 2 6" />
                                </svg>
                                Email
                            </label>
                            <input type="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                required>
                        </div>

                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-user">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                NIK / NIDN
                            </label>
                            <input type="text" name="nik"
                                class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                required>
                        </div>

                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-user">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Nama Pengguna
                            </label>
                            <input type="text" name="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                required>
                        </div>

                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-phone">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                No Handphone
                            </label>
                            <input type="text" name="no_handphone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                required>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-building">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <path d="M9 8h.01M15 8h.01M9 12h.01M15 12h.01M9 16h.01M15 16h.01" />
                                    </svg>
                                    Instansi
                                </label>
                                <input type="text" name="instansi"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-user">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Jenis Kelamin
                                </label>
                                <select name="gender" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <path d="M16 2v4M8 2v4M3 10h18" />
                                    </svg>
                                    Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-image">
                                        <path d="M21 15V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10" />
                                        <path d="M7 15l2-2 3 3 4-4 4 4" />
                                        <path d="M21 21H3" />
                                    </svg>
                                    Photo KTP
                                </label>
                                <input type="file" name="photo_ktp" accept="image/*"
                                    class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-900 hover:file:bg-slate-200"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-lock">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Kata Sandi
                                </label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 text-xs font-bold text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-lock">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Konfirmasi Kata Sandi
                                </label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                                    required>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="text-red-500 text-sm mt-2 font-bold text-center">
                                Terjadi kesalahan, cek kembali inputan Anda.
                            </div>
                        @endif

                        <button type="submit"
                            class="w-full bg-blue-800 text-white font-bold py-3 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                            DAFTAR
                        </button>

                        <div class="text-center mt-6 text-xs font-bold text-black">
                            Sudah punya akun? <a href="{{ route('login-page') ?? '/login' }}"
                                class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">Masuk</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>