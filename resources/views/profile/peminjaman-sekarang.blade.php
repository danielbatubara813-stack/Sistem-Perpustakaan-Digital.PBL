@extends('layout.profile-anggota-app')
@section('title', 'Peminjaman Terkini')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-2">
            {{-- Jumlah dinamis --}}
            <p>Saat ini terdapat <strong>{{ $totalAktif }}</strong> peminjaman aktif...</p>
            <form action="" class="flex items-center gap-2">
                <input id="search" type="text" placeholder="Cari buku yang dipinjam..."
                    class="flex-1 min-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                <button class="w-10 h-10 aspect-square rounded-md bg-blue-800 text-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </button>
            </form>
        </div>

        @forelse ($peminjaman as $item)
            @php
                $sudahDiperpanjang = !empty($item->tanggal_perpanjangan);
            @endphp
            <div
                class="border border-gray-300 p-4 rounded-xl transition-all duration-300 ease-in-out hover:shadow-md bg-white">
                {{-- MOBILE CARD --}}
                <div class="grid grid-cols-1 lg:grid-cols-6 gap-4 lg:gap-2">

                    {{-- Book Cover --}}
                    <div class="w-full flex flex-col items-center gap-3">
                        <a href="{{ route('detail-buku-page', $item->itemBuku->buku->id_buku) }}">
                            <img src="{{ $item->itemBuku->buku->cover_buku &&
                            Storage::disk('public')->exists('covers/' . $item->itemBuku->buku->cover_buku)
                                ? asset('storage/covers/' . $item->itemBuku->buku->cover_buku)
                                : asset('static/bookcover.png') }}"
                                class="w-28 lg:w-36 aspect-[1/1.6] rounded-lg lg:rounded-md object-cover border border-gray-300 shadow-sm lg:shadow-md"
                                alt="{{ $item->itemBuku->buku->judul_buku }}">
                        </a>

                        @if (!$sudahDiperpanjang)
                            <form
                                action="{{ route('profile.peminjaman.perpanjang', $item->kode_peminjaman) }}"
                                method="POST" class="w-28 lg:w-36">
                                @csrf
                                <button type="submit" title="Perpanjang peminjaman"
                                    class="inline-flex w-full items-center justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    Perpanjang
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Book Info --}}
                    <div class="col-span-1 lg:col-span-3 space-y-3 lg:space-y-4">
                        <a href="{{ route('detail-buku-page', $item->itemBuku->buku->id_buku) }}"
                            class="block hover:text-blue-700 transition">
                            <h4 class="font-bold text-lg lg:text-xl line-clamp-2 lg:line-clamp-none">
                                {{ $item->itemBuku->buku->judul_buku }}
                            </h4>
                        </a>

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

                            <div class="flex flex-wrap gap-2">
                                @foreach ($item->itemBuku->buku->penulis as $data_penulis)
                                    <div
                                        class="border border-gray-300 rounded-full px-4 lg:px-6 py-0.5 lg:py-1 w-max text-xs lg:text-sm">
                                        <p>{{ $data_penulis->nama_penulis }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-3 lg:space-y-4 text-sm lg:pt-2">
                                <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                    <h4 class="font-semibold lg:font-bold">Edisi</h4>
                                    <p class="col-span-2 lg:col-span-3">{{ $item->itemBuku->buku->edisi }}</p>
                                </div>
                                <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                    <h4 class="font-semibold lg:font-bold">ISBN/ISSN</h4>
                                    <p class="col-span-2 lg:col-span-3 break-all">{{ $item->itemBuku->buku->isbn }}</p>
                                </div>
                                <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                    <h4 class="font-semibold lg:font-bold">No Panggil</h4>
                                    <p class="col-span-2 lg:col-span-3">{{ $item->itemBuku->buku->no_panggil }}</p>
                                </div>
                                <div class="grid grid-cols-3 lg:grid-cols-4 gap-2">
                                    <h4 class="font-semibold lg:font-bold">Kode Item</h4>
                                    <p class="col-span-2 lg:col-span-3 break-all">{{ $item->id_item }}</p>
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
                                <h4 class="text-xs lg:text-sm text-gray-500">Tanggal Peminjaman</h4>
                                <h6 class="font-bold text-sm lg:text-base">
                                    {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                            <div class="lg:text-end">
                                <h4 class="text-xs lg:text-sm text-gray-500">Tanggal Jatuh Tempo</h4>
                                <h6 class="font-bold text-sm lg:text-base">
                                    {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        </div>

                    </div>

            </div>
        @empty
            <div class="text-center py-12 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4" width="48" height="48"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                </svg>
                <p class="text-lg font-medium">Anda belum memiliki sejarah peminjaman.</p>
            </div>
        @endforelse
    </div>
@endsection
