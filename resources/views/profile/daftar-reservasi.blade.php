@extends('layout.profile-anggota-app')
@section('title', 'reservasi Terkini')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-2">
            <p>Saat ini 2 terdapat reservasi...</p>
            <form action="" class="flex items-center gap-2">
                <input id="search" type="text" placeholder="Cari buku yang direservasi..."
                    class="flex-1 min-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                <button class="w-10 h-10 aspect-square rounded-md bg-blue-800 text-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </button>
            </form>
        </div>
        @foreach ($reservasi as $item)
            <a href="{{ route('detail-buku-page', $item['id']) }}">
                <div class="border border-gray-300 p-4 rounded-xl bg-white transition-all duration-300 hover:shadow-md">

                    {{-- MOBILE --}}
                    <div class="flex flex-col gap-4 lg:hidden">

                        {{-- TOP --}}
                        <div class="flex gap-4 items-start">

                            {{-- COVER --}}
                            <img src="{{ $item['cover'] }}"
                                class="w-28 aspect-1/1.5 rounded-lg object-cover border border-gray-300 shadow-sm shrink-0"
                                alt="">

                            {{-- CONTENT --}}
                            <div class="flex-1 min-w-0 flex flex-col gap-3">


                                {{-- JUDUL --}}
                                <h4 class="font-bold text-base leading-tight line-clamp-2">
                                    {{ $item['judul'] }}
                                </h4>

                                {{-- PENULIS --}}
                                <div class="border border-gray-300 rounded-full px-3 py-1 w-max max-w-full text-xs">
                                    <p class="truncate">
                                        {{ $item['penulis'] }}
                                    </p>
                                </div>
                                <button class="text-sm flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                        <path d="m21.854 2.147-10.94 10.939" />
                                    </svg>

                                    Bagikan
                                </button>
                            </div>
                        </div>

                        {{-- DETAIL --}}
                        <div class="space-y-3 text-sm">

                            <div class="flex justify-between gap-4">
                                <span class="font-semibold text-black shrink-0">
                                    Edisi
                                </span>

                                <span class="text-end text-gray-600">
                                    {{ $item['edisi'] }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="font-semibold text-black shrink-0">
                                    ISBN/ISSN
                                </span>

                                <span class="text-end text-gray-600 break-all">
                                    {{ $item['isbn'] }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="font-semibold text-black shrink-0">
                                    No Panggil
                                </span>

                                <span class="text-end text-gray-600">
                                    {{ $item['no_panggil'] }}
                                </span>
                            </div>

                            {{-- DATE --}}
                            <div class="pt-3 border-t border-gray-200">
                                @if ($item['status_reservasi'] === 'Sudah Konfirmasi')
                                    <div
                                        class="w-max flex items-center justify-center gap-2 border border-red-600 bg-red-600/15 px-4 py-2 text-xs font-medium text-red-600 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" x2="12" y1="8" y2="12" />
                                            <line x1="12" x2="12.01" y1="16" y2="16" />
                                        </svg>
                                        <span>{{ $item['status_reservasi'] }}</span>
                                    </div>
                                @else
                                    <div
                                        class="w-max flex items-center justify-center gap-2 border border-blue-600 bg-blue-600/15 px-4 py-2 text-xs font-medium text-blue-600 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" x2="12" y1="8" y2="12" />
                                            <line x1="12" x2="12.01" y1="16" y2="16" />
                                        </svg>
                                        <span>{{ $item['status_reservasi'] }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs text-gray-500">
                                        Tanggal Pengajuan
                                    </p>

                                    <h6 class="font-bold text-sm">
                                        {{ date('l, d M Y', strtotime($item['tanggal_pengajuan'])) }}
                                    </h6>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- DESKTOP --}}
                    <div class="hidden lg:grid grid-cols-6 gap-4">

                        {{-- COVER --}}
                        <img src="{{ $item['cover'] }}"
                            class="aspect-[1/1.6] w-36 rounded-lg object-cover border border-gray-300 shadow-sm"
                            alt="">

                        {{-- CONTENT --}}
                        <div class="col-span-3 space-y-4">

                            <h4 class="font-bold text-xl line-clamp-2">
                                {{ $item['judul'] }}
                            </h4>

                            <button class="text-sm flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

                        {{-- SIDE --}}
                        <div class="col-span-2 flex flex-col items-end gap-4">

                            @if ($item['status_reservasi'] === 'Sudah Konfirmasi')
                                <div
                                    class="flex items-center gap-3 border border-green-600 bg-green-600/10 px-5 py-2 rounded-full text-sm font-medium text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>

                                    <span>{{ $item['status_reservasi'] }}</span>
                                </div>
                            @else
                                <div
                                    class="flex items-center gap-3 border border-blue-600 bg-blue-600/10 px-5 py-2 rounded-full text-sm font-medium text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>

                                    <span>{{ $item['status_reservasi'] }}</span>
                                </div>
                            @endif

                            <div class="text-end">
                                <h4 class="text-sm text-gray-500">
                                    Tanggal Pengajuan
                                </h4>

                                <h6 class="font-bold">
                                    {{ date('l, d M Y', strtotime($item['tanggal_pengajuan'])) }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        <div class="flex items-center justify-center gap-2">
            <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-left-icon lucide-chevron-left">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </button>
            <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">1</button>
            <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">2</button>
            <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">3</button>
            <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>
        </div>
    </div>
@endsection
