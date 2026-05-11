{{-- Isi content halaman beranda --}}
@extends('layout.main-app')
@section('title', 'Cari Buku')

@section('content')
    <div class="py-12 px-4 md:px-6 lg:px-12 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">

        <div class="hidden md:block w-full">
            @include('components.filter-sidebar')
        </div>

        <div class="md:hidden mb-4">
            <button id="openFilter" class="w-full bg-blue-800 text-white rounded-lg p-3 font-semibold">
                Filter
            </button>
        </div>

        <div id="filterModal" class="fixed inset-0 bg-black/50 z-50 hidden items-end">

            <div class="bg-white w-full max-h-[90vh] rounded-t-3xl overflow-y-auto p-4 animate-slide-up">

                {{-- HEADER --}}
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg">Filter</h2>

                    <button id="closeFilter" class="text-gray-500 text-2xl">
                        &times;
                    </button>
                </div>

                {{-- FILTER --}}
                @include('components.filter-sidebar')

            </div>
        </div>

        <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-lg border border-gray-300 shadow-md p-4">
            <div class="w-full grid grid-cols-3 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-4 xl:flex lg:flex-col gap-4">
                @foreach ($koleksi_baru as $item)
                    <a class="hidden xl:block" href="{{ route('detail-buku-page', $item['id']) }}">
                        <div
                            class="border border-gray-300 p-4 rounded-md transition-all duration-300 ease-in-out hover:shadow-md">
                            <div class="w-full grid grid-cols-1 lg:grid-cols-6 space-y-4 lg:space-y-0 gap-0 lg:gap-2">
                                <img src="{{ $item['cover'] }}"
                                    class="aspect-[1/1.6] w-full max-w-[16rem] lg:w-36 rounded-md object-cover border shadow-md border-gray-300"
                                    alt="">
                                <div class="col-span-4 space-y-4">
                                    <h4 class="font-bold text-xl">{{ $item['judul'] }}</h4>
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
                                    <div class="border border-gray-300 rounded-full px-6 py-1 w-max text-sm">
                                        <p>{{ $item['penulis'] }}</p>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">Edisi</h4>
                                            <p class="col-span-4">{{ $item['edisi'] }}</p>
                                        </div>
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">ISBN/ISSN</h4>
                                            <p class="col-span-4">{{ $item['isbn'] }}</p>
                                        </div>
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">No
                                                Panggil</h4>
                                            <p class="col-span-4">{{ $item['no_panggil'] }}</p>
                                        </div>
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">Deskripsi</h4>
                                            <p class="col-span-4">{{ $item['deskripsi'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="w-36 lg:w-full aspect-square border border-gray-2 rounded-lg text-center flex items-center justify-center flex-col gap-4">
                                    <h4 class="text-sm">Ketersediaan</h4>
                                    <h1 class="text-4xl font-bold">2</h1>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="block xl:hidden" href="{{ route('detail-buku-page', $item['id']) }}">
                        <div
                            class="h-full p-2 rounded-md border border-gray-300 space-y-4 bg-white shadow-md hover:scale-105 transition-all duration-300 ease-in-out">
                            <img src="{{ $item['cover'] }}" class="aspect-[1/1.6] w-full rounded-md object-cover"
                                alt="">
                            <div class="w-full h-max text-start flex flex-col justify-center items-start space-y-2">
                                <h6 class="text-gray-500 text-xs line-clamp-1">{{ $item['penulis'] }}</h6>
                                <h4 class="font-bold text-xs line-clamp-2">{{ $item['judul'] }}</h4>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
            <div class="flex items-center justify-center gap-2 mt-10">
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
    </div>

    <script>
        const openFilter = document.getElementById('openFilter');
        const closeFilter = document.getElementById('closeFilter');
        const filterModal = document.getElementById('filterModal');

        openFilter.addEventListener('click', () => {
            filterModal.classList.remove('hidden');
            filterModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        });

        closeFilter.addEventListener('click', () => {
            filterModal.classList.add('hidden');
            filterModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        });

        filterModal.addEventListener('click', (e) => {
            if (e.target === filterModal) {
                filterModal.classList.add('hidden');
                filterModal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>
@endsection
