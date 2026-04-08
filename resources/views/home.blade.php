{{-- Isi content halaman beranda --}}
@extends('layout.main-app')

@section('content')
    {{-- section hero --}}
    <section id="hero">
        <div class="w-full h-screen max-h-270 relative">
            <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-20">
            </div>
            <img class="absolute top-0 left-0 w-full h-full object-cover z-10" src="{{ asset('static/backgroundHero.jpg') }}"
                alt="">
            <div
                class="absolute top-1/2 left-1/2 transform -translate-1/2 z-20 flex flex-col items-center justify-center gap-16">
                <h1 class="text-white poppins text-4xl uppercase font-bold">Selamat Datang</h1>
                <form action="" method="POST" class="flex items-center gap-2">
                    <input type="text" class="bg-white p-2 md:p-4 rounded-md w-sm md:w-md lg:w-lg focus:outline-0"
                        placeholder="Cari Judul Buku...">
                    <button class="bg-blue-800 text-white p-2 md:p-4 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>
    {{-- section koleksi baru --}}
    <section id="koleksi_baru">
        <div class="py-12 px-2 sm:px-6 md:px-12 lg:px-24">
            <div class="flex flex-col justify-center items-center text-center space-y-4">
                <h2 class="font-bold uppercase text-3xl">Koleksi Baru</h2>
                <p class="w-full lg:w-1/2 text-sm lg:text-base">Koleksi-koleksi kami yang baru hadir di perpustakaan
                    Polibatam. Cari. Pinjam dan nikmati
                    koleksi
                    terbarunya
                </p>
            </div>
            <div class="space-y-4 mt-4">
                <div class="flex justify-end items-center">
                    <button class="text-white bg-blue-800 px-6 py-2 rounded-md">
                        Lihat Semua
                    </button>
                </div>
                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-4">
                    @foreach ($koleksi_baru as $buku)
                        <div
                            class="p-2 rounded-md border border-gray-300 space-y-4 bg-white shadow-md hover:scale-105 transition-all duration-300 ease-in-out">
                            <img src="{{ $buku['cover'] }}" class="aspect-[1/1.6] w-full rounded-md object-fit"
                                alt="">
                            <div class="w-full h-max text-start flex flex-col justify-center items-start space-y-2">
                                <h6 class="text-gray-500 text-xs line-clamp-1">{{ $buku['penulis'] }}</h6>
                                <h4 class="font-bold text-xs line-clamp-2">{{ $buku['judul'] }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- seciton kata kata terkenal --}}
    <section>
        <div class="relative w-full h-80 shadow-md">
            <div class="w-full h-full text-center flex justify-center items-center flex-col gap-4 relative z-10 text-white">
                <p class="w-full md:w-3/4 font-bold italic text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl">"The
                    more that you read, the more things you will know.
                    The more that you learn, the more places you'll go"</p>
                <p class="text-sm md:text-base lg:text-lg italic">- Dr Seuss -</p>
            </div>
            <img class="absolute top-0 left-0 w-full h-full object-cover z-0"
                src="https://i.pinimg.com/736x/eb/11/54/eb1154fcb64e6575eed6f8728cacd173.jpg" alt="">
            <div class="absolute top-0 left-0 w-full h-full bg-linear-to-r from-black/75 via-black/50 to-black/75 z-0">
            </div>
        </div>
    </section>
    {{-- section koleksi popular --}}
    <section id="koleksi_popular">
        <div class="py-12 px-2 sm:px-6 md:px-12 lg:px-24">
            <div class="flex flex-col justify-center items-center text-center space-y-4">
                <h2 class="font-bold uppercase text-3xl">Koleksi Popular</h2>
                <p class="w-full lg:w-1/2 text-sm lg:text-base">Koleksi-koleksi kami yang dibaca oleh banyak pengunjung
                    perpustakaan. Cari. Pinjam. Kami
                    harap Anda menyukainya
                </p>
            </div>
            <div class="space-y-4 mt-4">
                <div class="flex justify-end items-center">
                    <button class="text-white bg-blue-800 px-6 py-2 rounded-md">
                        Lihat Semua
                    </button>
                </div>
                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-4">
                    @foreach ($koleksi_baru as $buku)
                        <div
                            class="p-2 rounded-md border border-gray-300 space-y-4 bg-white shadow-md hover:scale-105 transition-all duration-300 ease-in-out">
                            <img src="{{ $buku['cover'] }}" class="aspect-[1/1.6] w-full rounded-md object-fit"
                                alt="">
                            <div class="w-full h-max text-start flex flex-col justify-center items-start space-y-2">
                                <h6 class="text-gray-500 text-xs line-clamp-1">{{ $buku['penulis'] }}</h6>
                                <h4 class="font-bold text-xs line-clamp-2">{{ $buku['judul'] }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="penikmat_koleksi">
        <div class="py-12 px-2 sm:px-6 md:px-12 lg:px-24 bg-white shadow-md space-y-4">
            <div class="flex flex-col justify-center items-start space-y-4">
                <h2 class="font-bold uppercase text-3xl">PENIKMAT KOLEKSI</h2>
                <p class="w-full lg:w-1/2 text-sm lg:text-base">Pengunjung terbaik kami, ada di sini. Nama dan foto Anda
                    juga
                    bisa muncul di sini. Rajin-rajinlah berkunjung dan membaca
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach ($penikmat_koleksi as $akun)
                    <div
                        class="bg-white rounded-md p-4 border border-gray-300 grid grid-cols-3 gap-4 hover:scale-105 hover:shadow-md transition-all duration-300">
                        <img class="aspect-square object-cover object-top rounded-full" src="{{ $akun['profile'] }}"
                            alt="">
                        <div class="col-span-2 flex justify-between flex-col">
                            <h4 class="text-2xl font-bold uppercase mb-0">{{ $akun['nama'] }}</h4>
                            <h4 class="text-sm">{{ $akun['jenis_keanggotaan'] }}</h4>
                            <div class="flex justify-evenly items-center border border-black rounded-md">
                                <p class="p-2 text-nowrap">{{ $akun['total_peminjaman'] }} Pinjam</p>
                                <div class="h-full w-px bg-black"></div>
                                <p class="p-2">{{ $akun['total_buku'] }} Judul</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
