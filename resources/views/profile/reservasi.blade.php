@extends('layout.profile-anggota-app')
@section('title', 'Peminjaman Terkini')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        @if (count($reservasi) > 0)
            <form action="{{ route('profile.reservasi-ajukan') }}" method="POST">
                @csrf
                @method('POST')
                @foreach ($reservasi as $item)
                    <input type="hidden" name="nomor_reservasi[]" value="{{ $item->nomor_reservasi }}">
                    <div
                        class="border border-gray-300 p-4 rounded-xl transition-all duration-300 ease-in-out hover:shadow-md bg-white">
                        <a href="{{ route('detail-buku-page', $item->buku->id_buku) }}">

                            {{-- MOBILE CARD --}}
                            <div class="grid grid-cols-1 lg:grid-cols-6 gap-4 lg:gap-2">

                                {{-- Book Cover --}}
                                <div class="w-full flex justify-center items-center">
                                    <img src="{{ $item->buku->cover_buku &&
                                    Storage::disk('public')->exists('covers/' . $item->buku->cover_buku)
                                        ? asset('storage/covers/' . $item->buku->cover_buku)
                                        : asset('static/bookcover.png') }}"
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
                    </div>
                @endforeach
                <div class="mt-6 flex gap-2 justify-between lg:justify-end items-center">

                    <button type="submit" name="action" value="kirim"
                        class="rounded-md bg-blue-800 text-white flex items-center justify-center px-6 py-2 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload">
                            <path d="M12 3v12" />
                            <path d="m17 8-5-5-5 5" />
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        </svg>
                        Kirim Reservasi</button>

                    <input type="hidden" name="action">
                    <button type="button" data-action="batal"
                        class="open-cancel-modal rounded-md bg-red-600 text-white flex items-center justify-center px-6 py-2 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        Batal Reservasi</button>
                </div>
            </form>
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
