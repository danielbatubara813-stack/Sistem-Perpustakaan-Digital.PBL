@extends('layout.profile-anggota-app')
@section('title', 'reservasi Terkini')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4">
        <div class="flex justify-between items-end">
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
                        <div class="col-span-2 flex justify-start items-end flex-col space-y-4">
                            @if ($item['status_reservasi'] === 'Sudah Konfirmasi')
                                <div
                                    class="w-max h-max flex items-center justify-center gap-4 border border-green-600 bg-green-600/15 px-6 py-2 text-nowrap text-sm font-medium text-green-600 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert-icon lucide-circle-alert">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                    <span>{{ $item['status_reservasi'] }}</span>
                                </div>
                            @else
                                <div
                                    class="w-max h-max flex items-center justify-center gap-4 border border-blue-600 bg-blue-600/15 px-6 py-2 text-nowrap text-sm font-medium text-blue-600 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert-icon lucide-circle-alert">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                    <span>{{ $item['status_reservasi'] }}</span>
                                </div>
                            @endif
                            <div class="text-end">
                                <h4 class="text-sm">Tanggal Pengajuan</h4>
                                <h6 class="font-bold">{{ date('l, d M Y', strtotime($item['tanggal_pengajuan'])) }}</h6>
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
