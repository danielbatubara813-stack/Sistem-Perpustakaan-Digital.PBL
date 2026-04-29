@extends('layout.profile-anggota-app')
@section('title', 'Peminjaman Terkini')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        @foreach ($reservasi as $item)
            <a href="{{ route('detail-buku-page', $item['id']) }}">
                <div class="border border-gray-300 p-4 rounded-md transition-all duration-300 ease-in-out hover:shadow-md">
                    <div class="w-full grid grid-cols-1 lg:grid-cols-6 space-y-4 lg:space-y-0 gap-0 lg:gap-2">
                        <img src="{{ $item['cover'] }}"
                            class="aspect-[1/1.6] w-64 lg:w-36 rounded-md object-fit border shadow-md border-gray-300"
                            alt="">
                        <div class="col-span-3 space-y-4">
                            <h4 class="font-bold text-xl">{{ $item['judul'] }}</h4>
                            <button class="text-sm flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-send-icon lucide-send">
                                    <path
                                        d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                    <path d="m21.854 2.147-10.94 10.939" />
                                </svg>
                                Bagikan
                            </button>
                            <div class="border border-gray-300 rounded-full px-6 py-1 w-max text-sm">
                                <p>{{ $item['penulis'] }}</p>
                            </div>
                            <div class="space-y-4">
                                <div class="grid grid-cols-4 gap-2">
                                    <h4 class="font-bold text-black">Edisi</h4>
                                    <p class="col-span-3">{{ $item['edisi'] }}</p>
                                </div>
                                <div class="grid grid-cols-4 gap-2">
                                    <h4 class="font-bold text-black">ISBN/ISSN</h4>
                                    <p class="col-span-3">{{ $item['isbn'] }}</p>
                                </div>
                                <div class="grid grid-cols-4 gap-2">
                                    <h4 class="font-bold text-black">No
                                        Panggil</h4>
                                    <p class="col-span-3">{{ $item['no_panggil'] }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </a>
        @endforeach
        <div class="flex gap-2 justify-end items-center">
            <button class="rounded-md bg-blue-800 text-white flex items-center justify-center px-6 py-2 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-upload-icon lucide-upload">
                    <path d="M12 3v12" />
                    <path d="m17 8-5-5-5 5" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                </svg>
                Kirim Reservasi</button>
            <button class="rounded-md bg-red-600 text-white flex items-center justify-center px-6 py-2 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-trash2-icon lucide-trash-2">
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>
                Batal Reservasi</button>
        </div>
    </div>
@endsection
