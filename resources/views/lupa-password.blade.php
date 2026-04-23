@extends('layout.auth-layout')
@section('content')
    <div class="flex items-center justify-center flex-col w-full h-full">
        <h2 class="text-3xl font-extrabold text-black text-center mb-2">Lupa Password?</h2>
        <p class="text-sm text-gray-500 text-center mb-8 font-medium">
            Silahkan isi dan ganti password anda sesuai dengan akun anda.
        </p>

        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div
                class="mb-6 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm text-center font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('lupa-password.proses') }}" class="space-y-6 w-full lg:w-3/4">
            @csrf

            <!-- Email -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email anda"
                    class="w-full px-4 py-3 border @error('email') border-red-400 @else 'border-gray-400' @enderror rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi Baru -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Kata Sandi Baru
                </label>
                <input type="password" name="kata_sandi_baru" placeholder="Masukkan kata sandi baru"
                    class="w-full px-4 py-3 border @error('kata_sandi_baru') border-red-500 @else 'border-gray-400' @enderror rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                @error('kata_sandi_baru')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Kata Sandi -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Konfirmasi Kata Sandi Baru
                </label>
                <input type="password" name="konfirmasi_kata_sandi" placeholder="Ulangi kata sandi baru"
                    class="w-full px-4 py-3 border @error('konfirmasi_kata_sandi') border-red-500 @else 'border-gray-400' @enderror rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                @error('konfirmasi_kata_sandi')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            @if (session('error'))
                <div class="text-red-500 text-sm mt-2 font-bold text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tombol Kirim -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-blue-800 text-white font-bold py-3.5 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                    Kirim
                </button>
            </div>

            <!-- Link kembali ke login -->
            <div class="text-center mt-6 text-xs font-bold text-black">
                Sudah ingat password?
                <a href="{{ route('login-page') }}"
                    class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                    Masuk
                </a>
            </div>

        </form>
    </div>
@endsection
