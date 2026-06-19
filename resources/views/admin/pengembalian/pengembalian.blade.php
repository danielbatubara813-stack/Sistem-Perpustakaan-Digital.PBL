{{-- Halaman Pengembalian (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Pengembalian')
@php
    $title = 'Pengembalian';
    $description = 'Kelola pengembalian buku dan catat pengembalian baru.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="flex flex-col gap-4">

            {{-- Tabs --}}
            @include('components.submenu-admin')

            {{-- Filter --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                <form method="GET" action="{{ route('admin.pengembalian.index') }}">
                    <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">

                        <input name="search" value="{{ request('search') }}" type="text"
                            placeholder="Cari anggota atau judul buku..."
                            class="w-full sm:w-auto sm:flex-1 sm:max-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                        <select name="tanggal"
                            class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">

                            <option value="">Semua Tanggal</option>
                            <option value="hari_ini" {{ request('tanggal') == 'hari_ini' ? 'selected' : '' }}>Hari ini
                            </option>
                            <option value="7_hari" {{ request('tanggal') == '7_hari' ? 'selected' : '' }}>7 hari</option>
                            <option value="30_hari" {{ request('tanggal') == '30_hari' ? 'selected' : '' }}>30 hari</option>
                        </select>

                        {{-- <select name="status"
                            class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">

                            <option value="">Semua Status</option>
                            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                                Dikembalikan
                            </option>
                            <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>
                                Terlambat
                            </option>
                            <option value="Hilang" {{ request('status') == 'Hilang' ? 'selected' : '' }}>
                                Hilang
                            </option>
                        </select> --}}

                        <select name="sort"
                            class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">

                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                                Terbaru
                            </option>

                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                                Terlama
                            </option>
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        @if (count($pengembalian) > 0)
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <h4 class="text-sm font-semibold mb-2">{{ $pengembalian->total() }} Daftar Pengembalian</h4>

                <div class="flex items-center justify-end gap-3">
                    <button id="selectAllTopBtn" type="button"
                        class="inline-flex items-center gap-2 rounded-md bg-slate-400 px-3 py-2 text-sm font-medium text-white hover:bg-slate-500 transition">
                        <svg class="icon-unchecked" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                        </svg>
                        <svg class="icon-checked hidden" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                        Seleksi Semua Data
                    </button>
                    <button id="deleteSelected"
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

                    <!-- Export PDF removed to match wireframe -->
                </div>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-sm text-left text-gray-600 text-nowrap">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                        <tr>
                            <th class="px-6 py-3 w-12">Pilih</th>
                            <th class="px-6 py-3">Anggota</th>
                            <th class="px-6 py-3">Kode Item</th>
                            <th class="px-6 py-3">Masa Peminjaman</th>
                            <th class="px-6 py-3">Tanggal Kembali</th>
                            <th class="px-6 py-3">Denda</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $item)
                            <tr
                                class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100">
                                <td class="px-6 py-4">
                                    <input type="checkbox"
                                        class="row-checkbox h-5 w-5 rounded-full border-slate-300 text-blue-600 focus:ring-blue-500" />
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                    <img class="rounded-full w-10 h-10"
                                        src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg"
                                        alt="">
                                    <div>
                                        <div class="text-xs text-black font-bold w-36 text-wrap">
                                            {{ $item->peminjaman->anggota->nama }}</div>
                                        <div class="text-xs text-slate-500">
                                            {{ $item->peminjaman->anggota->nomor_identitas }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold uppercase">{{ $item->peminjaman->itemBuku->buku->judul_buku }}
                                    </div>
                                    <div class="text-sm">{{ $item->peminjaman->id_item }}</div>
                                </td>
                                <td class="px-4 sm:px-6 py-4">
                                    <div>
                                        Tanggal Pinjam: {{ $item->peminjaman->tanggal_peminjaman }}
                                    </div>
                                    <div>
                                        Tanggal Jatuh Tempo: {{ $item->peminjaman->tanggal_jatuh_tempo }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $item->tanggal_pengembalian ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($item->total_denda, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">{{ $item->peminjaman->status }}</td>
                                <td class="px-6 py-4">
                                    <button
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-yellow-300 text-black hover:bg-yellow-400 transition"
                                        aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit-2">
                                            <path d="m17 3 4 4L7 21H3v-4L17 3z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $pengembalian->firstItem() ?? 0 }} hingga {{ $pengembalian->lastItem() ?? 0 }}
                    dari {{ $pengembalian->total() }} data
                </p>
                @if ($pengembalian->lastPage() > 1)
                    <div class="inline-flex items-center gap-2">
                        <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                            Halaman <span class="font-semibold">{{ $pengembalian->currentPage() }}</span>
                            dari <span class="font-semibold">{{ $pengembalian->lastPage() }}</span>
                        </div>
                        <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                            @if ($pengembalian->onFirstPage())
                                <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $pengembalian->previousPageUrl() }}"
                                    class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </a>
                            @endif

                            @php
                                $currentPage = $pengembalian->currentPage();
                                $lastPage = $pengembalian->lastPage();
                                $start = max($currentPage - 1, 1);
                                $end = min($currentPage + 1, $lastPage);
                                if ($currentPage == 1) {
                                    $end = min(3, $lastPage);
                                }
                                if ($currentPage == $lastPage) {
                                    $start = max($lastPage - 2, 1);
                                }
                            @endphp

                            @foreach ($pengembalian->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $pengembalian->currentPage())
                                    <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($pengembalian->hasMorePages())
                                <a href="{{ $pengembalian->nextPageUrl() }}"
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
        @else
            <div class="flex flex-col items-center justify-center gap-4 text-center">
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
