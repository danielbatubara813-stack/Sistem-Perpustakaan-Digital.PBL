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
                    <a href="{{ route('detail-buku-page', $item->buku->id_buku) }}">
                        <div
                            class="border border-gray-300 p-4 rounded-xl transition-all duration-300 ease-in-out hover:shadow-md bg-white">

                            {{-- MOBILE CARD --}}
                            <div class="flex flex-col gap-4 lg:hidden">

                                {{-- Top --}}
                                <div class="flex gap-4">
                                    <img src="{{ !empty($item->buku->cover_buku) ? $item->buku->cover_buku : asset('static/bookcover.png') }}"
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
                                </div>
                            </div>

                            {{-- DESKTOP --}}
                            <div class="hidden lg:grid grid-cols-6 gap-2">

                                <img src="{{ !empty($item->buku->cover_buku) ? $item->buku->cover_buku : asset('static/bookcover.png') }}"
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
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10" />
                                                <line x1="12" x2="12" y1="8" y2="12" />
                                                <line x1="12" x2="12.01" y1="16" y2="16" />
                                            </svg>
                                            <span>{{ $item->status }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
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
