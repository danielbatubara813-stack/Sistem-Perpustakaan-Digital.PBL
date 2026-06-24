@extends('layout.profile-anggota-app')
@section('title', 'Daftar Reservasi')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-2">
            <p>Saat ini {{ count($reservasi) }} terdapat reservasi...</p>
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
        @if (count($reservasi) > 0)
            @foreach ($reservasi as $item)
                <a href="{{ route('detail-buku-page', $item->buku->id_buku) }}">
                    <div
                        class="border border-gray-300 p-4 rounded-xl transition-all duration-300 ease-in-out hover:shadow-md bg-white">

                        {{-- MOBILE CARD --}}
                        <div class="flex flex-col gap-4 lg:hidden">

                            {{-- Top --}}
                            <div class="flex gap-4">
                                <img src="{{ !empty($item->buku->cover) ? $item->buku->cover : asset('images/default-book-cover.jpg') }}"
                                    class="aspect-1/1.5 w-28 rounded-lg object-cover border border-gray-300 shadow-sm"
                                    alt="{{ $item->buku->judul_buku }}">

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-lg line-clamp-2">
                                        {{ $item->buku->judul_buku }}
                                    </h4>

                                    <div class="mt-2 border border-gray-300 rounded-full px-4 py-1 w-max text-xs">
                                        <p>{{ $item['penulis'] }}</p>
                                    </div>

                                    <button class="text-sm flex gap-2 items-center mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-send-icon lucide-send">
                                            <path
                                                d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                            <path d="m21.854 2.147-10.94 10.939" />
                                        </svg>
                                        Bagikan
                                    </button>
                                </div>
                            </div>

                            {{-- Detail --}}
                            <div class="space-y-3 text-sm">
                                <div class="grid grid-cols-3 gap-2">
                                    <h4 class="font-semibold">Edisi</h4>
                                    <p class="col-span-2">{{ $item->buku->edisi }}</p>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <h4 class="font-semibold">ISBN</h4>
                                    <p class="col-span-2 break-all">{{ $item->buku->isbn }}</p>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <h4 class="font-semibold">No Panggil</h4>
                                    <p class="col-span-2">{{ $item->buku->no_panggil }}</p>
                                </div>

                            </div>

                            {{-- Status --}}
                            <div class="flex flex-col gap-3 pt-2 border-t border-gray-200">

                                @if ($item->status === 'Terlambat')
                                    <div
                                        class="w-max flex items-center justify-center gap-2 border border-red-600 bg-red-600/15 px-4 py-2 text-xs font-medium text-red-600 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" x2="12" y1="8" y2="12" />
                                            <line x1="12" x2="12.01" y1="16" y2="16" />
                                        </svg>
                                        <span>{{ $item->status }}</span>
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
                                        <span>{{ $item->status }}</span>
                                    </div>
                                @endif

                                <div>
                                    <h4 class="text-xs text-gray-500">
                                        Tanggal Pengembalian
                                    </h4>
                                    <h6 class="font-bold text-sm">
                                        {{ date('l, d M Y', strtotime($item->tanggal_pengembalian)) }}
                                    </h6>
                                </div>
                            </div>
                        </div>

                        {{-- DESKTOP --}}
                        <div class="hidden lg:grid grid-cols-6 gap-2">

                            <img src="{{ !empty($item->buku->cover) ? $item->buku->cover : asset('images/default-book-cover.jpg') }}"
                                class="aspect-[1/1.6] w-36 rounded-md object-cover border shadow-md border-gray-300"
                                alt="{{ $item->buku->judul_buku }}">

                            <div class="col-span-3 space-y-4">
                                <h4 class="font-bold text-xl">{{ $item->buku->judul_buku }}</h4>

                                <button class="text-sm flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-send-icon lucide-send">
                                        <path
                                            d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                        <path d="m21.854 2.147-10.94 10.939" />
                                    </svg>
                                    Bagikan
                                </button>

                                @foreach ($item->buku->penulis as $data_penulis)
                                    <div class="border border-gray-300 rounded-full px-6 py-1 w-max text-sm">
                                        <p>{{ $data_penulis->nama_penulis }}</p>
                                    </div>
                                @endforeach

                                <div class="space-y-4">
                                    <div class="grid grid-cols-4 gap-2">
                                        <h4 class="font-bold text-black">Edisi</h4>
                                        <p class="col-span-3">{{ $item->buku->edisi }}</p>
                                    </div>

                                    <div class="grid grid-cols-4 gap-2">
                                        <h4 class="font-bold text-black">ISBN/ISSN</h4>
                                        <p class="col-span-3">{{ $item->buku->isbn }}</p>
                                    </div>

                                    <div class="grid grid-cols-4 gap-2">
                                        <h4 class="font-bold text-black">No Panggil</h4>
                                        <p class="col-span-3">{{ $item->buku->no_panggil }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 flex justify-start items-end flex-col space-y-4">

                                @if ($item->status === 'Ditolak')
                                    <div
                                        class="w-max h-max flex items-center justify-center gap-4 border border-red-600 bg-red-600/15 px-6 py-2 text-nowrap text-sm font-medium text-red-600 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" x2="12" y1="8" y2="12" />
                                            <line x1="12" x2="12.01" y1="16" y2="16" />
                                        </svg>
                                        <span>{{ $item->status }}</span>
                                    </div>
                                @else
                                    <div
                                        class="w-max h-max flex items-center justify-center gap-4 border border-blue-600 bg-blue-600/15 px-6 py-2 text-nowrap text-sm font-medium text-blue-600 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" x2="12" y1="8" y2="12" />
                                            <line x1="12" x2="12.01" y1="16" y2="16" />
                                        </svg>
                                        <span>{{ $item->status }}</span>
                                    </div>
                                @endif

                                <div class="text-end">
                                    <h4 class="text-sm">Tanggal Diajukan</h4>
                                    <h6 class="font-bold">
                                        {{ date('l, d M Y', strtotime($item->tanggal_diajukan)) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $reservasi->firstItem() ?? 0 }} hingga {{ $reservasi->lastItem() ?? 0 }}
                    dari {{ $reservasi->total() }} data
                </p>
                @if ($reservasi->lastPage() > 1)
                    <div class="inline-flex items-center gap-2">
                        <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                            Halaman <span class="font-semibold">{{ $reservasi->currentPage() }}</span>
                            dari <span class="font-semibold">{{ $reservasi->lastPage() }}</span>
                        </div>
                        <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                            @if ($reservasi->onFirstPage())
                                <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $reservasi->previousPageUrl() }}"
                                    class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </a>
                            @endif

                            @php
                                $currentPage = $reservasi->currentPage();
                                $lastPage = $reservasi->lastPage();
                                $start = max($currentPage - 1, 1);
                                $end = min($currentPage + 1, $lastPage);
                                if ($currentPage == 1) {
                                    $end = min(3, $lastPage);
                                }
                                if ($currentPage == $lastPage) {
                                    $start = max($lastPage - 2, 1);
                                }
                            @endphp

                            @foreach ($reservasi->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $reservasi->currentPage())
                                    <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($reservasi->hasMorePages())
                                <a href="{{ $reservasi->nextPageUrl() }}"
                                    class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </a>
                            @else
                                <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="flex flex-col items-center justify-center gap-4 text-center mt-16">
                <img class="w-48" src="{{ asset('static/noDataIcon.png') }}" alt="Data tidak ditemukan">

                <div class="flex flex-col items-center justify-center">
                    <h4 class="text-lg font-semibold text-slate-800">
                        Data Tidak Ditemukan
                    </h4>

                    <p class="w-3/4 text-sm text-slate-500">
                        Mohon maaf, Data yang Anda cari tidak ditemukan, atau belum ada data yang tersedia saat ini.
                    </p>
                </div>
            </div>
        @endif
    </div>


@endsection
