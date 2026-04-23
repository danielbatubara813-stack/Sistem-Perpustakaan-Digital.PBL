@extends('layout.main-app')

@section('title', 'Detail Buku ' . $buku['judul'])

@section('content')
    <div class="relative h-96">
        <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-10">
        </div>
        <img class="absolute top-0 left-0 w-full h-full object-cover z-0" src="{{ asset('static/backgroundHero.jpg') }}"
            alt="">
    </div>
    <div
        class="px-4 sm:px-6 md:px-12 lg:18 xl:px-24 py-12 w-full grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 space-y-4 lg:space-y-0 gap-0 md:gap-4">
        <div
            class="bg-white h-max p-6 rounded-md border border-gray-300 shadow-md space-y-4 flex flex-col justify-center items-center">
            <img src="{{ $buku['cover'] }}"
                class="aspect-[1/1.6] w-3/5 lg:w-full rounded-md object-fit border shadow-md border-gray-300" alt="">
            <button onclick="copyLink()"
                class="p-2 rounded-md bg-blue-800 flex items-center justify-center gap-4 w-full text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-send-icon lucide-send">
                    <path
                        d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                    <path d="m21.854 2.147-10.94 10.939" />
                </svg>
                <span>Bagikan</span>
            </button>
            <div class="w-full space-y-4">
                <div class="w-full">
                    <h6 class="text-sm lg:text-base">Total Peminjaman</h6>
                    <h2 class="text-lg lg:text-xl font-bold">15 Peminjaman</h2>
                </div>
                <div class="w-full">
                    <h6 class="text-sm lg:text-base">Jumlah Item Buku</h6>
                    <h2 class="text-lg lg:text-xl font-bold">2 Item Buku</h2>
                </div>
            </div>
        </div>
        <div
            class="bg-white col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 p-6 rounded-md border border-gray-300 shadow-md">
            <div class="space-y-4">
                <h2 class="text-3xl lg:text-4xl font-bold w-3/4">{{ $buku['judul'] }}</h2>
                <div class="flex flex-wrap">
                    <h2 class="text-sm md:text-lg lg:text-xl py-2 px-6 rounded-full border border-black">
                        {{ $buku['penulis'] }}</h2>
                </div>
                <h2 class="font-bold text-xl lg:text-2xl">Informasi Detail</h2>
                <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">No Rak</h4>
                        <p class="col-span-4">813</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">Penerbit</h4>
                        <p class="col-span-4">Gramedia</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">Bahasa</h4>
                        <p class="col-span-4">Bahasa Indonesia</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">ISBN/ISSN</h4>
                        <p class="col-span-4">9786024246945</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">Edisi</h4>
                        <p class="col-span-4">Cet. 47</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">No. Panggil</h4>
                        <p class="col-span-4">{{ $buku['no_panggil'] }}</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                        <h4 class="font-bold text-black">Subjek</h4>
                        <p class="col-span-4">Fiksi</p>
                    </div>

                    <div class="col-span-2 lg:col-span-1 grid grid-cols-1 lg:grid-cols-5 gap-2 items-start">
                        <h4 class="font-bold text-black">Deskripsi</h4>
                        <p class="col-span-4 leading-relaxed text-gray-700">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil corporis laborum
                            dolore voluptates atque aliquid tempore voluptas blanditiis beatae vitae unde nulla,
                            necessitatibus aut ea sunt inventore quis porro veniam?
                        </p>
                    </div>
                </div>

                <h2 class="font-bold text-2xl">Daftar Buku</h2>
                <div class="overflow-auto">
                    <table class="min-w-full text-left text-sm text-slate-600 border border-gray-300">
                        <thead class="bg-blue-800 text-xs uppercase text-white">
                            <tr>
                                <th class="px-4 py-4 text-nowrap">Nomor Rak</th>
                                <th class="px-4 py-4 text-nowrap text-center align-center">Nomor Panggil</th>
                                <th class="px-4 py-4 text-nowrap text-center align-center">Nomor Item</th>
                                <th class="px-4 py-4 text-nowrap text-center align-center">Status Buku</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">

                            @foreach ($buku['copy'] as $item)
                                <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-50 transition-all duration-150">
                                    <td class="px-3 py-3 text-nowrap">{{ $item['lokasi'] }}</td>
                                    <td class="px-3 py-3 text-nowrap text-slate-700 text-center align-center">
                                        {{ $item['nomor_panggil'] }}
                                    </td>
                                    <td class="px-3 py-3 text-nowrap text-slate-700 text-center align-center">
                                        {{ $item['nomor_item'] }}
                                    </td>

                                    <td
                                        class="px-3 py-3 text-nowrap font-medium text-center align-center {{ $item['status'] == 'Tersedia' ? 'text-green-600' : 'text-red-600' }}">

                                        {{ $item['status'] }}

                                        @if ($item['status'] == 'Sedang Dipinjam')
                                            <div class="text-xs text-slate-500 mt-1">
                                                Jatuh Tempo: {{ $item['tanggal_pinjam'] }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        function copyLink() {
            const url = window.location.href;

            navigator.clipboard.writeText(url)
                .then(() => {
                    alert('Link berhasil disalin!');
                })
                .catch(err => {
                    alert('Gagal menyalin link');
                    console.error(err);
                });
        }
    </script>
@endsection
