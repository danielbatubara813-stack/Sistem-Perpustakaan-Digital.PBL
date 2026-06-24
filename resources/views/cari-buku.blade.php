@extends('layout.main-app')
@section('title', 'Cari Buku')

@section('content')
    <div class="py-12 px-4 md:px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="hidden md:block w-full">
                @include('components.filter-sidebar')
            </div>

            <div class="md:hidden mb-4">
                <button id="openFilter" class="w-full bg-blue-800 text-white rounded-lg p-3 font-semibold">
                    Filter & Urutkan
                </button>
            </div>

            <div id="filterModal" class="fixed inset-0 bg-black/50 z-50 hidden items-end">
                <div class="bg-white w-full max-h-[90vh] rounded-t-3xl overflow-y-auto p-4 animate-slide-up">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-bold text-lg">Filter & Urutkan</h2>
                        <button id="closeFilter" type="button" class="text-gray-500 text-2xl">&times;</button>
                    </div>
                    @include('components.filter-sidebar')
                </div>
            </div>

            <div id="daftar-buku" class="col-span-1 md:col-span-2 lg:col-span-3 scroll-mt-28">
                <p class="mb-4 text-sm text-gray-600">
                    Menampilkan <strong>{{ $koleksi_baru->count() }}</strong> dari <strong>{{ $koleksi_baru->total() }}</strong> buku
                </p>

                <div class="space-y-4">
                    @forelse ($koleksi_baru as $item)
                        <a href="{{ route('detail-buku-page', $item['id']) }}" class="block">
                            <div class="border border-gray-300 p-4 rounded-lg bg-white shadow-md hover:shadow-lg transition-all duration-300">
                                <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
                                    <div class="sm:col-span-1 flex justify-center sm:justify-start">
                                        <img src="{{ $item['cover'] }}" class="aspect-[1/1.6] w-full max-w-sm rounded-md object-cover border border-gray-300 shadow-md" alt="{{ $item['judul'] }}">
                                    </div>

                                    <div class="sm:col-span-4 space-y-2 flex flex-col justify-between">
                                        <div class="space-y-2">
                                            <h4 class="font-bold text-lg line-clamp-2 text-gray-900">{{ $item['judul'] }}</h4>
                                            <div class="space-y-1 text-xs md:text-sm text-gray-600">
                                                <p><strong>Penulis:</strong> {{ $item['penulis'] }}</p>
                                                <p><strong>Penerbit:</strong> {{ $item['penerbit'] }}</p>
                                                <p><strong>ISBN:</strong> {{ $item['isbn'] }}</p>
                                                <p><strong>Tipe:</strong> {{ $item['tipe'] }} | <strong>Bahasa:</strong> {{ $item['bahasa'] }}</p>
                                                <p class="line-clamp-2 text-gray-500">{{ $item['deskripsi'] }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-1 flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <h4 class="text-xs font-semibold text-gray-600 text-center mb-2">Ketersediaan</h4>
                                        <h1 class="text-3xl font-bold {{ $item['ketersediaan'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item['ketersediaan'] }}
                                        </h1>
                                        <p class="text-xs text-gray-500 text-center mt-1">dari {{ $item['total_item'] }} item</p>
                                        <span class="text-xs {{ $item['ketersediaan'] > 0 ? 'text-green-600' : 'text-red-600' }} font-semibold mt-2">
                                            {{ $item['ketersediaan'] > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="bg-white rounded-lg border border-gray-300 shadow-md p-8 text-center">
                            <p class="text-gray-600 text-lg">Tidak ada buku yang ditemukan.</p>
                            <p class="text-gray-500 text-sm mt-2">Coba sesuaikan filter atau cari dengan kata kunci lain.</p>
                        </div>
                    @endforelse
                </div>

                @if ($koleksi_baru->hasPages())
                    <div class="mt-8">
                        {{ $koleksi_baru->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const openFilter = document.getElementById('openFilter');
        const closeFilter = document.getElementById('closeFilter');
        const filterModal = document.getElementById('filterModal');

        if (openFilter && closeFilter && filterModal) {
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

            filterModal.addEventListener('click', (event) => {
                if (event.target === filterModal) {
                    filterModal.classList.add('hidden');
                    filterModal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }

        window.addEventListener('load', () => {
            const params = new URLSearchParams(window.location.search);

            if (params.get('scroll') !== 'daftar-buku') {
                return;
            }

            const target = document.getElementById('daftar-buku');

            if (!target) {
                return;
            }

            setTimeout(() => {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 250);
        });
    </script>
@endsection
