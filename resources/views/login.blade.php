@extends('layout.auth-layout')
@section('content')
    <div class="flex items-center justify-center flex-col w-full h-full">
        <h2 class="text-3xl font-extrabold text-black text-center mb-2">Selamat Datang!</h2>
        <p class="text-sm text-gray-500 text-center mb-8 font-medium">
            Masuk untuk dapat melakukan peminjaman buku
        </p>

        <form method="POST" action="/login" class="space-y-6 w-3/4">
            @csrf

            <!-- Email / Member ID -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Email / Member ID
                </label>
                <input type="text" name="login_id"
                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                    required>
            </div>
            <!-- End Email -->

            <!-- Kata Sandi -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Kata Sandi
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                    required>

                @if (!Route::is('admin.login-page'))
                    <div class="text-right mt-2">
                        <a href="{{ route('lupa-password.tampil') }}"
                            class="text-[11px] font-bold text-gray-800 hover:text-blue-800 transition-colors">
                            Lupa kata sandi?
                        </a>
                    </div>
                @endif
            </div>
            <!-- End Kata Sandi -->

            @if (session('error'))
                <div class="text-red-500 text-sm mt-2 font-bold text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tombol Masuk -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-blue-800 text-white font-bold py-3.5 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                    Masuk
                </button>
            </div>

            @if (!Route::is('admin.login-page'))
                <div class="text-center mt-6 text-xs font-bold text-black">
                    Belum punya akun?
                    <a href="{{ route('register-page') }}"
                        class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">Daftar</a>
                </div>
            @endif

        </form>
        <!-- End Form -->
    </div>
@endsection
