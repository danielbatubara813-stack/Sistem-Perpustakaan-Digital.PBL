@extends('layout.profile-anggota-app')
@section('title', 'Peminjaman Terkini')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        @foreach ($reservasi as $item)
            <a href="{{ route('detail-buku-page', $item['id']) }}">
                <div
                    class="border border-gray-300 p-4 rounded-xl transition-all duration-300 ease-in-out hover:shadow-md bg-white">

                    {{-- MOBILE --}}
                    <div class="flex flex-col gap-4 lg:hidden">

                        <div class="flex gap-4">
                            {{-- Cover --}}
                            <img src="{{ $item['cover'] }}"
                                class="w-28 aspect-1/1.5 rounded-lg object-cover border shadow-sm border-gray-300 shrink-0"
                                alt="">

                            {{-- Content --}}
                            <div class="flex-1 min-w-0 space-y-3">

                                {{-- Judul --}}
                                <h4 class="font-bold text-base line-clamp-2">
                                    {{ $item['judul'] }}
                                </h4>

                                {{-- Penulis --}}
                                <div class="border border-gray-300 rounded-full px-4 py-1 w-max text-xs">
                                    <p class="line-clamp-1">{{ $item['penulis'] }}</p>
                                </div>

                                {{-- Share --}}
                                <button class="text-sm flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                        <path d="m21.854 2.147-10.94 10.939" />
                                    </svg>
                                    Bagikan
                                </button>
                            </div>
                        </div>

                        {{-- Detail --}}
                        <div class="space-y-3 text-sm border-t border-gray-200 pt-3">

                            <div class="flex justify-between gap-3">
                                <h4 class="font-semibold text-black">Edisi</h4>
                                <p class="text-end">{{ $item['edisi'] }}</p>
                            </div>

                            <div class="flex justify-between gap-3">
                                <h4 class="font-semibold text-black">ISBN/ISSN</h4>
                                <p class="text-end line-clamp-1">{{ $item['isbn'] }}</p>
                            </div>

                            <div class="flex justify-between gap-3">
                                <h4 class="font-semibold text-black">No Panggil</h4>
                                <p class="text-end">{{ $item['no_panggil'] }}</p>
                            </div>

                        </div>
                    </div>

                    {{-- DESKTOP --}}
                    <div class="hidden lg:grid w-full grid-cols-6 gap-4 items-start">

                        {{-- Cover --}}
                        <img src="{{ $item['cover'] }}"
                            class="aspect-[1/1.6] w-36 rounded-md object-cover border shadow-md border-gray-300"
                            alt="">

                        {{-- Content --}}
                        <div class="col-span-3 space-y-4">

                            <h4 class="font-bold text-xl line-clamp-2">
                                {{ $item['judul'] }}
                            </h4>

                            <button class="text-sm flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
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
                                    <h4 class="font-bold text-black">No Panggil</h4>
                                    <p class="col-span-3">{{ $item['no_panggil'] }}</p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </a>
        @endforeach
        <div class="flex gap-2 justify-between lg:justify-end items-center">
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
