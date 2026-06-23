{{-- Halaman Aturan Peminjaman (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Aturan Peminjaman')
@php
    $title = 'Peminjaman';
    $description = 'Aturan peminjaman untuk tiap tipe keanggotaan dan koleksi.';
@endphp

@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                @include('components.submenu-admin')
            </div>

            <form method="GET" action="{{ route('admin.peminjaman.aturan') }}"
                class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">
                    <input name="search" value="{{ request('search') }}" type="text" placeholder="Cari tipe keanggotaan..."
                        data-auto-submit-search
                        class="w-full sm:w-auto sm:flex-1 sm:max-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <select name="tanggal" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua Tanggal</option>
                        <option value="hari_ini" {{ in_array(request('tanggal'), ['hari_ini', 'Hari ini'], true) ? 'selected' : '' }}>Hari ini</option>
                        <option value="7_hari" {{ in_array(request('tanggal'), ['7_hari', '7 hari'], true) ? 'selected' : '' }}>7 hari</option>
                        <option value="30_hari" {{ in_array(request('tanggal'), ['30_hari', '30 hari'], true) ? 'selected' : '' }}>30 hari</option>
                    </select>

                    <select name="sort" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none sm:min-w-36 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="terbaru" {{ in_array(request('sort', 'terbaru'), ['terbaru', 'Terbaru'], true) ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="terlama" {{ in_array(request('sort'), ['terlama', 'Terlama'], true) ? 'selected' : '' }}>
                            Terlama
                        </option>
                    </select>

                    <button type="submit"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition shrink-0"
                        aria-label="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </button>
                </div>

                <a href="{{ route('admin.peminjaman.aturan.create') }}"
                    class="w-full md:w-max flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Tambah Aturan
                </a>
            </form>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <form id="multi-delete-form" action="{{ route('admin.peminjaman.aturan.destroyMultiple') }}"
            data-delete-name="id_aturan" method="POST">
            @csrf
            @method('DELETE')

            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-lg font-semibold tracking-wide">
                        {{ $rules->total() }} Daftar aturan peminjaman
                    </h2>
                </div>

                <div class="grid grid-cols-2 lg:flex lg:items-center lg:justify-end gap-3">
                    <button id="selectAllTopBtn" type="button"
                        class="inline-flex items-center gap-2 rounded-md bg-slate-400 px-3 py-2 text-sm font-medium text-white hover:bg-slate-500 transition">
                        <svg class="icon-unchecked" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                        </svg>
                        <svg class="icon-checked hidden" xmlns="http://www.w3.org/2000/svg" width="14"
                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                        Seleksi Semua Data
                    </button>

                    <button id="deleteSelected" type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
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
                            <th class="px-6 py-3">Tipe Keanggotaan</th>
                            <th class="px-6 py-3">Tipe Koleksi</th>
                            <th class="px-6 py-3 text-center">Maksimal Peminjaman</th>
                            <th class="px-6 py-3 text-center">Periode Peminjaman</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rules as $rule)
                            <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100">
                                <td class="px-6 py-4">
                                    <input type="checkbox" value="{{ $rule->id_aturan }}"
                                        class="row-checkbox h-5 w-5 rounded-full border-slate-300 text-blue-600 focus:ring-blue-500" />
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $rule->jenisKeanggotaan?->nama_jenis ?? 'Semua Jenis Anggota' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $rule->tipeKoleksi?->nama_tipe ?? 'Semua Tipe Koleksi' }}
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    {{ $rule->batas_peminjaman }} Buku
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    {{ $rule->periode_peminjaman }} Hari
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.peminjaman.aturan.edit', $rule->id_aturan) }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-black bg-amber-300 hover:bg-amber-400 transition"
                                            aria-label="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m17 3 4 4L7 21H3v-4L17 3z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-slate-500">
                                    Tidak ada data aturan peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $rules->firstItem() ?? 0 }} hingga {{ $rules->lastItem() ?? 0 }}
                dari {{ $rules->total() }} data
            </p>

            @if ($rules->lastPage() > 1)
                <div class="inline-flex items-center gap-2">
                    <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                        Halaman <span class="font-semibold">{{ $rules->currentPage() }}</span>
                        dari <span class="font-semibold">{{ $rules->lastPage() }}</span>
                    </div>

                    <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                        @if ($rules->onFirstPage())
                            <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $rules->previousPageUrl() }}"
                                class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </a>
                        @endif

                        @php
                            $currentPage = $rules->currentPage();
                            $lastPage = $rules->lastPage();
                            $start = max($currentPage - 1, 1);
                            $end = min($currentPage + 1, $lastPage);
                            if ($currentPage === 1) {
                                $end = min(3, $lastPage);
                            }
                            if ($currentPage === $lastPage) {
                                $start = max($lastPage - 2, 1);
                            }
                        @endphp

                        @foreach ($rules->getUrlRange($start, $end) as $page => $url)
                            @if ($page === $rules->currentPage())
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($rules->hasMorePages())
                            <a href="{{ $rules->nextPageUrl() }}"
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
