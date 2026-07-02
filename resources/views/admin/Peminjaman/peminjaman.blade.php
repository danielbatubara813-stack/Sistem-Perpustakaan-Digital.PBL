{{-- Halaman Peminjaman (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Peminjaman')
@php
    $title = 'Peminjaman';
    $description = 'Kelola daftar peminjaman buku dan catat peminjaman baru.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="flex flex-col gap-4">

            {{-- Submenu --}}
            <div class="flex items-center justify-between">
                @include('components.submenu-admin')
            </div>

            {{-- Filter + Button --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                {{-- Filter Group --}}
                <form method="GET" action="{{ route('admin.peminjaman') }}"
                    class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">

                    <input name="search" value="{{ request('search') }}" type="text" placeholder="Cari anggota..."
                        data-auto-submit-search
                        class="w-full sm:w-auto sm:flex-1 sm:max-w-56 rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <select name="tanggal" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua Tanggal</option>
                        <option value="hari_ini" {{ in_array(request('tanggal'), ['hari_ini', 'Hari ini'], true) ? 'selected' : '' }}>Hari ini</option>
                        <option value="7_hari" {{ in_array(request('tanggal'), ['7_hari', '7 hari'], true) ? 'selected' : '' }}>7 hari</option>
                        <option value="30_hari" {{ in_array(request('tanggal'), ['30_hari', '30 hari'], true) ? 'selected' : '' }}>30 hari</option>
                    </select>

                    <select name="jatuh_tempo" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua</option>
                        <option value="jatuh_tempo" {{ in_array(request('jatuh_tempo'), ['jatuh_tempo', 'sudah_jatuh_tempo', 'Jatuh Tempo', 'Sudah Jatuh Tempo'], true) ? 'selected' : '' }}>
                            Jatuh Tempo
                        </option>
                        <option value="belum_jatuh_tempo" {{ in_array(request('jatuh_tempo'), ['belum_jatuh_tempo', 'Belum Jatuh Tempo'], true) ? 'selected' : '' }}>
                            Belum Jatuh Tempo
                        </option>
                    </select>

                    <select name="sort" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="terbaru" {{ in_array(request('sort', 'terbaru'), ['terbaru', 'Terbaru'], true) ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ in_array(request('sort'), ['terlama', 'Terlama'], true) ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white
                    border border-slate-300 text-slate-700 hover:bg-slate-50 transition shrink-0"
                        aria-label="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </button>
                </form>

                {{-- Button --}}
                <a href="{{ route('admin.peminjaman.catat-peminjaman') }}"
                    class="w-full md:w-max flex items-center justify-center gap-2
                bg-blue-600 hover:bg-blue-700 text-white rounded-md
                px-4 py-2 text-sm shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Catat Pinjaman
                </a>

            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold tracking-wide">{{ $loans->total() }} Daftar peminjaman</h2>
            </div>
        </div>
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full text-sm text-left text-gray-600 text-nowrap">
                <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                    <tr>
                        <th class="px-6 py-3">Kode Peminjaman</th>
                        <th class="px-6 py-3">Anggota</th>
                        <th class="px-6 py-3">Buku / Kode Item</th>
                        <th class="px-6 py-3">Tanggal Pinjam</th>
                        <th class="px-6 py-3">Jatuh Tempo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $loan->kode_peminjaman }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                <img class="rounded-full w-10 h-10"
                                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg"
                                    alt="">

                                <div>
                                    <div>{{ $loan->anggota?->nama ?? '-' }}</div>

                                    <div class="text-xs text-slate-500">
                                        {{ $loan->anggota?->nomor_identitas ?? '-' }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">
                                    {{ $loan->itemBuku?->buku?->judul_buku ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $loan->id_item }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $loan->tanggal_peminjaman }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $loan->tanggal_jatuh_tempo }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-slate-500">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $loans->firstItem() ?? 0 }} hingga {{ $loans->lastItem() ?? 0 }}
                dari {{ $loans->total() }} data
            </p>

            @if ($loans->lastPage() > 1)
                <div class="inline-flex items-center gap-2">
                    <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                        Halaman <span class="font-semibold">{{ $loans->currentPage() }}</span>
                        dari <span class="font-semibold">{{ $loans->lastPage() }}</span>
                    </div>

                    <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                        @if ($loans->onFirstPage())
                            <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $loans->previousPageUrl() }}"
                                class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </a>
                        @endif

                        @php
                            $currentPage = $loans->currentPage();
                            $lastPage = $loans->lastPage();
                            $start = max($currentPage - 1, 1);
                            $end = min($currentPage + 1, $lastPage);
                            if ($currentPage === 1) {
                                $end = min(3, $lastPage);
                            }
                            if ($currentPage === $lastPage) {
                                $start = max($lastPage - 2, 1);
                            }
                        @endphp

                        @foreach ($loans->getUrlRange($start, $end) as $page => $url)
                            @if ($page === $loans->currentPage())
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($loans->hasMorePages())
                            <a href="{{ $loans->nextPageUrl() }}"
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
    </div>

    <script>
        document.querySelectorAll('[data-auto-submit-search]').forEach((input) => {
            let timeoutId;

            input.addEventListener('input', () => {
                clearTimeout(timeoutId);

                timeoutId = setTimeout(() => {
                    input.form?.requestSubmit();
                }, 350);
            });
        });
    </script>
@endsection
