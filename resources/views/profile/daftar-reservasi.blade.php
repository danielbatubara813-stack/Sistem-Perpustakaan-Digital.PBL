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
                <div
                    class="border border-gray-300 p-4 rounded-xl transition-all duration-300 ease-in-out hover:shadow-md bg-white">
                    <a href="{{ route('detail-buku-page', $item->buku->id_buku) }}">

                        {{-- MOBILE CARD --}}
                        <div class="grid grid-cols-1 lg:grid-cols-6 gap-4 lg:gap-2">

                            {{-- Book Cover --}}
                            <div class="w-full flex justify-center items-center">
                                <img src="{{ !empty($item->buku->cover) ? $item->buku->cover : asset('static/bookcover.png') }}"
                                    class="w-28 lg:w-36 aspect-[1/1.6] rounded-lg lg:rounded-md object-cover border border-gray-300 shadow-sm lg:shadow-md"
                                    alt="{{ $item->buku->judul_buku }}">
                            </div>

                            {{-- Book Info --}}
                            <div class="col-span-1 lg:col-span-3 space-y-3 lg:space-y-4">
                                <h4 class="font-bold text-lg lg:text-xl line-clamp-2 lg:line-clamp-none">
                                    {{ $item->buku->judul_buku }}
                                </h4>

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

                                <div class="flex flex-wrap gap-2">
                                    @foreach ($item->buku->penulis as $data_penulis)
                                        <div
                                            class="border border-gray-300 rounded-full px-4 lg:px-6 py-0.5 lg:py-1 w-max text-xs lg:text-sm">
                                            <p>{{ $data_penulis->nama_penulis }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="space-y-2 lg:space-y-4 text-sm">
                                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                        <h4 class="font-semibold lg:font-bold text-black">Edisi</h4>
                                        <p class="col-span-2 lg:col-span-3">{{ $item->buku->edisi }}</p>
                                    </div>

                                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                        <h4 class="font-semibold lg:font-bold text-black">ISBN/ISSN</h4>
                                        <p class="col-span-2 lg:col-span-3 break-all">{{ $item->buku->isbn }}</p>
                                    </div>

                                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                        <h4 class="font-semibold lg:font-bold text-black">No Panggil</h4>
                                        <p class="col-span-2 lg:col-span-3">{{ $item->buku->no_panggil }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Status & Dates --}}
                            <div
                                class="col-span-1 lg:col-span-2 flex flex-col lg:items-end gap-3 lg:gap-4 pt-2 lg:pt-0 border-t lg:border-t-0 border-gray-200">

                                @if (in_array($item->status, ['Ditolak', 'Dibatalkan']))
                                    <div
                                        class="w-max flex items-center justify-center gap-2 lg:gap-4 border border-red-600 bg-red-600/15 px-4 lg:px-6 py-2 text-xs lg:text-sm font-medium text-red-600 rounded-full text-nowrap">
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
                                        class="w-max flex items-center justify-center gap-2 lg:gap-4 border border-blue-600 bg-blue-600/15 px-4 lg:px-6 py-2 text-xs lg:text-sm font-medium text-blue-600 rounded-full text-nowrap">
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

                                <div class="lg:text-end">
                                    <h4 class="text-sm">Tanggal Diajukan</h4>
                                    <h6 class="font-bold">
                                        {{ date('l, d M Y', strtotime($item->tanggal_diajukan)) }}
                                    </h6>
                                </div>

                                @if ($item->tanggal_expired && $item->status === 'Siap Diambil')
                                    <div class="lg:text-end">
                                        <h4 class="text-sm">Tanggal Pengambilan Terakhir</h4>
                                        <h6 class="font-bold">
                                            {{ date('l, d M Y', strtotime($item->tanggal_expired)) }}
                                        </h6>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </a>

                    {{-- Cancel Button --}}
                    @if (!in_array($item->status, ['Selesai', 'Ditolak', 'Dibatalkan']))
                        <div class="col-span-1 lg:col-span-6 w-full flex items-center justify-end z-10">
                            <form action="{{ route('profile.reservasi.jadikan-reservasi') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="nomor_reservasi" value="{{ $item->nomor_reservasi }}">
                                <button type="button"
                                    class="open-cancel-modal text-sm px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition cursor-pointer">
                                    Batalkan Reservasi
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
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
