@extends('layout.app-admin')

@section('title', 'Kelola Tipe Koleksi')
@php
    $title = 'Daftar Tipe Koleksi';
    $description = 'Kelola Tipe Koleksi untuk tipe buku perpustakaan';
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
                <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">

                    <input id="search" type="text" placeholder="Cari..."
                        class="w-full sm:w-auto sm:flex-1 sm:max-w-36 rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <select id="filter-status"
                        class="flex-1 sm:flex-none rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Status</option>
                        <option>Aktif</option>
                        <option>Tidak Aktif</option>
                    </select>

                    <select id="filter-sort"
                        class="flex-1 sm:flex-none sm:min-w-36 rounded-md border border-slate-300
                    px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Terbaru</option>
                        <option>Terlama</option>
                    </select>

                    <button
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
                </div>

                {{-- Button --}}
                <a href="{{ route('admin.data-terkendali.tipe-koleksi.create') }}"
                    class="w-full md:w-max flex items-center justify-center gap-2
                bg-blue-600 hover:bg-blue-700 text-white rounded-md
                px-3 py-2 text-sm shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Tambah Tipe Koleksi
                </a>

            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <form action="{{ route('admin.data-terkendali.tipe-koleksi.destroy') }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-lg font-semibold tracking-wide">{{ count($tipe_koleksi) }} Daftar tipe koleksi</h2>
                </div>
                <div class="grid grid-cols-2 lg:flex lg:items-center lg:justify-end gap-3">
                    <button id="selectAllTopBtn" type="button"
                        class="inline-flex items-center gap-2 rounded-md bg-slate-400 px-3 py-2 text-sm font-medium text-white hover:bg-slate-500 transition">
                        <!-- unchecked icon -->
                        <svg class="icon-unchecked" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                        </svg>
                        <!-- checked icon (hidden by default) -->
                        <svg class="icon-checked hidden" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                        Seleksi Semua Data
                    </button>
                    <button id="deleteSelected" type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        Hapus Data Diseleksi
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full text-sm text-left text-gray-600 text-nowrap">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                        <tr>
                            <th class="px-6 py-3 w-12">Pilih</th>
                            <th class="px-6 py-3">Tipe Koleksi</th>
                            <th class="px-6 py-3 hidden lg:table-cell">Tanggal Dibuat</th>
                            <th class="px-6 py-3 hidden lg:table-cell">Tanggal Diubah</th>
                            <th class="px-6 py-3 text-right w-12">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipe_koleksi as $type)
                            <tr
                                class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="id_tipe[]" value="{{ $type->id_tipe }}"
                                        class="row-checkbox h-5 w-5 rounded-full border-slate-300 text-blue-600 focus:ring-blue-500" />
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $type->nama_tipe }}</td>
                                <td class="px-6 py-4 hidden lg:table-cell">{{ $type->tanggal_dibuat }}</td>
                                <td class="px-6 py-4 hidden lg:table-cell">{{ $type->tanggal_diubah }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.data-terkendali.tipe-koleksi.edit', $type->id_tipe) }}"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-black bg-amber-300 hover:bg-amber-400 transition"
                                        aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit-2">
                                            <path d="m17 3 4 4L7 21H3v-4L17 3z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">Menampilkan 1 hingga {{ count($tipe_koleksi) }} dari
                    {{ count($tipe_koleksi) }} data
                </p>
                @if (count($tipe_koleksi) > 10)
                    <div class="inline-flex items-center gap-2">
                        <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                            Halaman <span class="font-semibold">{{ $tipe_koleksi->currentPage() }}</span>
                            dari
                            <span class="font-semibold">{{ $tipe_koleksi->lastPage() }}</span>
                        </div>
                        <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                            {{-- Tombol Previous --}}
                            @if ($tipe_koleksi->onFirstPage())
                                <span class="p-2 bg-slate-200 text-blue-600 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-left-icon lucide-chevron-left">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $tipe_koleksi->previousPageUrl() }}"
                                    class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-left-icon lucide-chevron-left">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </a>
                            @endif

                            @php
                                $currentPage = $tipe_koleksi->currentPage();
                                $lastPage = $tipe_koleksi->lastPage();

                                $start = max($currentPage - 1, 1);
                                $end = min($currentPage + 1, $lastPage);

                                // supaya tetap tampil 3 angka kalau di awal
                                if ($currentPage == 1) {
                                    $end = min(3, $lastPage);
                                }

                                // supaya tetap tampil 3 angka kalau di akhir
                                if ($currentPage == $lastPage) {
                                    $start = max($lastPage - 2, 1);
                                }
                            @endphp

                            {{-- Nomor Halaman --}}
                            @foreach ($tipe_koleksi->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $tipe_koleksi->currentPage())
                                    <span class="px-4 py-2 bg-blue-600 text-white rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($tipe_koleksi->hasMorePages())
                                <a href="{{ $tipe_koleksi->nextPageUrl() }}"
                                    class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </a>
                            @else
                                <span class="p-2 bg-slate-200 text-blue-600 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            @endif
                        </div>

                    </div>
                @endif
            </div>

        </form>
    </div>
@endsection
