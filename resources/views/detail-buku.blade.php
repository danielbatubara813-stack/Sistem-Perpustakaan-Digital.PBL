@extends('layout.main-app')
@section('title', 'Detail Buku - ' . $bukuData['judul'])

@section('content')
    <div class="relative h-96">
        <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-10"></div>
        <img class="absolute top-0 left-0 w-full h-full object-cover z-0"
            src="{{ asset('static/backgroundHero.jpg') }}" alt="">
    </div>

    <div class="px-4 sm:px-6 md:px-12 lg:px-18 xl:px-24 py-12 w-full grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

        {{-- Sidebar kiri --}}
        <div class="bg-white h-max p-6 rounded-md border border-gray-300 shadow-md space-y-4 flex flex-col justify-center items-center">
            <img src="{{ $bukuData['cover'] }}"
                onerror="this.src='{{ asset('images/bookcover.png') }}'"
                class="aspect-[1/1.6] w-3/5 lg:w-full rounded-md object-cover border shadow-md border-gray-300"
                alt="{{ $bukuData['judul'] }}">

            <button onclick="copyLink()"
                class="p-2 rounded-md bg-blue-800 flex items-center justify-center gap-4 w-full text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                    <path d="m21.854 2.147-10.94 10.939" />
                </svg>
                <span>Bagikan</span>
            </button>

            <div class="w-full space-y-4">
                <div class="w-full">
                    <h6 class="text-sm lg:text-base">Jumlah Item Buku</h6>
                    <h2 class="text-lg lg:text-xl font-bold">{{ $bukuData['total_item'] }} Item Buku</h2>
                </div>
                <div class="w-full">
                    <h6 class="text-sm lg:text-base">Ketersediaan</h6>
                    <h2 class="text-lg lg:text-xl font-bold {{ $bukuData['ketersediaan'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $bukuData['ketersediaan'] }} Tersedia
                    </h2>
                </div>
            </div>
        </div>

        {{-- Konten utama --}}
        <div class="bg-white col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 p-6 rounded-md border border-gray-300 shadow-md">
            <div class="space-y-4">
                <h2 class="text-3xl lg:text-4xl font-bold w-3/4">{{ $bukuData['judul'] }}</h2>

                {{-- Penulis --}}
                <div class="flex flex-wrap gap-2">
                    @foreach ($bukuData['penulis'] as $penulis)
                        <span class="text-sm md:text-base py-2 px-6 rounded-full border border-black">
                            {{ $penulis }}
                        </span>
                    @endforeach
                </div>

                <h2 class="font-bold text-xl lg:text-2xl">Informasi Detail</h2>

                <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">No Rak</h4>
                        <p class="col-span-4">{{ $bukuData['no_rak'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">Penerbit</h4>
                        <p class="col-span-4">{{ $bukuData['penerbit'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">Bahasa</h4>
                        <p class="col-span-4">{{ $bukuData['bahasa'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">ISBN/ISSN</h4>
                        <p class="col-span-4">{{ $bukuData['isbn'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">Edisi</h4>
                        <p class="col-span-4">{{ $bukuData['edisi'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">No. Panggil</h4>
                        <p class="col-span-4">{{ $bukuData['no_panggil'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">Tipe</h4>
                        <p class="col-span-4">{{ $bukuData['tipe'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">Subjek</h4>
                        <p class="col-span-4">{{ implode(', ', $bukuData['subjek']) }}</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold">Tanggal Terbit</h4>
                        <p class="col-span-4">{{ $bukuData['tanggal_terbit'] }}</p>
                    </div>
                    <div class="col-span-2 lg:col-span-1 grid grid-cols-1 lg:grid-cols-5 gap-2 items-start">
                        <h4 class="font-bold">Deskripsi</h4>
                        <p class="col-span-4 leading-relaxed text-gray-700">{{ $bukuData['deskripsi'] }}</p>
                    </div>
                </div>

                {{-- Daftar Item Buku --}}
                <h2 class="font-bold text-2xl">Daftar Item Buku</h2>
                <div class="overflow-auto">
                    <table class="min-w-full text-left text-sm text-slate-600 border border-gray-300">
                        <thead class="bg-blue-800 text-xs uppercase text-white">
                            <tr>
                                <th class="px-4 py-4 text-nowrap">Nomor Item</th>
                                <th class="px-4 py-4 text-nowrap text-center">No. Panggil</th>
                                <th class="px-4 py-4 text-nowrap text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($bukuData['items'] as $item)
                                <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-50 transition-all duration-150">
                                    <td class="px-4 py-3 text-nowrap">{{ $item['id'] }}</td>
                                    <td class="px-4 py-3 text-nowrap text-center">{{ $bukuData['no_panggil'] }}</td>
                                    <td class="px-4 py-3 text-nowrap text-center font-medium
                                        {{ $item['status'] === 'Tersedia' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item['status'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-gray-400">
                                        Tidak ada item buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Rekomendasi --}}
                @if ($rekomendasi->count() > 0)
                    <h2 class="font-bold text-2xl mt-6">Buku Serupa</h2>
                    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach ($rekomendasi as $rek)
                            <a href="{{ route('detail-buku-page', $rek['id']) }}">
                                <div class="p-2 rounded-md border border-gray-300 bg-white shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                                    <img src="{{ $rek['cover'] }}"
                                        onerror="this.src='{{ asset('images/bookcover.png') }}'"
                                        class="aspect-[1/1.6] w-full rounded-md object-cover"
                                        alt="{{ $rek['judul'] }}">
                                    <div class="mt-2 space-y-1">
                                        <p class="text-gray-500 text-xs line-clamp-1">{{ $rek['penulis'] }}</p>
                                        <p class="font-bold text-xs line-clamp-2">{{ $rek['judul'] }}</p>
                                        <p class="text-xs {{ $rek['ketersediaan'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $rek['ketersediaan'] > 0 ? '✓ Tersedia' : '✗ Habis' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyLink() {
            navigator.clipboard.writeText(window.location.href)
                .then(() => alert('Link berhasil disalin!'))
                .catch(() => alert('Gagal menyalin link'));
        }
    </script>
@endsection
