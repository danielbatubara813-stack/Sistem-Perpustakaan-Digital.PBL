@extends('layout.auth-layout')
@section('content')
    <div class="flex items-center justify-center flex-col w-full h-full">
        <div class="text-start w-full lg:w-3/4">
            <h2 class="text-3xl font-extrabold text-black mb-2">Anda Lupa Password?</h2>
            <p class="text-sm text-gray-500 mb-8 font-medium">
                Silahkan isi untuk verifikasi email anda dan membuktikan bahwa itu email anda
            </p>
        </div>

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

            @if (session('error'))
                <div class="text-red-500 text-sm mt-2 font-bold text-center">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-2 gap-2 pt-2">
                <button type="submit"
                    class="w-full bg-blue-800 text-white font-bold py-3.5 rounded-md hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                    Kirim
                </button>
                <a href="{{ route('home-page') }}"
                    class="w-full bg-gray-300 text-black text-center font-bold py-3.5 rounded-md hover:bg-gray-400 transition-colors shadow-lg text-sm tracking-widest uppercase">
                    Batal
                </a>
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
