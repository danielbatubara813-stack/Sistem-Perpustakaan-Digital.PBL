@extends('layout.app-admin')

@section('title', 'Kelola Anggota')
@php
    $title = 'Daftar Keanggotaan';
    $description = 'Kelola keanggotaan dan verifikasi pendaftaran anggota.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="flex flex-col gap-4">
        {{-- Banner notif anggota menunggu verifikasi --}}
            @if ($anggotaMenunggu > 0)
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="text-sm font-semibold">
                        Ada <strong>{{ $anggotaMenunggu }}</strong> anggota baru menunggu verifikasi.
                    </span>
                </div>
            @endif

            {{-- Tabs --}}
            <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">
                <a id="daftarTab" href="{{ route('admin.anggota.daftar') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.daftar') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                    Daftar Anggota
                </a>
                <a href="{{ route('admin.anggota.jenis') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.jenis*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                    Jenis Keanggotaan
                </a>
            </div>

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.anggota.daftar') }}" id="filterForm">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                    <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..."
                            class="w-full sm:w-auto sm:flex-1 sm:max-w-56 rounded-md border border-slate-300
                            px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                        <select name="id_jenis"
                            class="flex-1 sm:flex-none sm:min-w-48 rounded-md border border-slate-300
                            px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option value="">Tipe Keanggotaan</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id_jenis }}" {{ request('id_jenis') == $j->id_jenis ? 'selected' : '' }}>
                                    {{ $j->nama_jenis }}
                                </option>
                            @endforeach
                        </select>

                        <select name="verifikasi"
                            class="flex-1 sm:flex-none rounded-md border border-slate-300
                            px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option value="">Status</option>
                            <option value="Menunggu"      {{ request('verifikasi') == 'Menunggu'      ? 'selected' : '' }}>Menunggu</option>
                            <option value="Terverifikasi" {{ request('verifikasi') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="Ditolak"       {{ request('verifikasi') == 'Ditolak'       ? 'selected' : '' }}>Ditolak</option>
                        </select>

                        <select name="sort"
                            class="flex-1 sm:flex-none sm:min-w-40 rounded-md border border-slate-300
                            px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
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

                    <a href="{{ route('admin.anggota.create') }}"
                        class="w-full md:w-max flex items-center justify-center gap-2
                        bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Tambah Anggota
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold tracking-wide">{{ $anggota->total() }} Daftar anggota</h2>
            </div>
            <div class="grid grid-cols-2 lg:flex lg:items-center lg:justify-end gap-3">
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

                <form id="multi-delete-form" method="POST" action="{{ route('admin.anggota.destroy') }}" data-delete-name="ids">
                    @csrf
                    @method('DELETE')
                    <div id="bulkIds"></div>
                    <button type="button" id="deleteSelected"
                        class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        Hapus Data Diseleksi
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full text-sm text-left text-gray-600 text-nowrap">
                <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 w-12">Pilih</th>
                        <th class="px-6 py-3">NO.Identitas</th>
                        <th class="px-6 py-3">Nama Anggota</th>
                        <th class="px-6 py-3 hidden lg:table-cell">Tipe Keanggotaan</th>
                        <th class="px-6 py-3 hidden lg:table-cell">Status</th>
                        <th class="px-6 py-3 hidden lg:table-cell">Terakhir Diubah</th>
                        <th class="px-6 py-3 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anggota as $member)
                        <tr ondblclick="window.location.href='{{ route('admin.anggota.edit', $member->id_anggota) }}'"
                            class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100 cursor-pointer">
                            <td class="px-6 py-4">
                                <input type="checkbox"
                                    class="row-checkbox h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                    value="{{ $member->id_anggota }}" />
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $member->nomor_identitas }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <div class="flex items-center gap-2">
                                    {{ $member->nama }}
                                    @if ($member->status_anggota === 'Aktif')
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">{{ $member->jenisKeanggotaan->nama_jenis ?? 'N/A' }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                @if ($member->verifikasi_admin === 'Terverifikasi')
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Terverifikasi
                                    </span>
                                @elseif ($member->verifikasi_admin === 'Menunggu')
                                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                        Menunggu
                                    </span>
                                @elseif ($member->verifikasi_admin === 'Ditolak')
                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">{{ $member->tanggal_diubah }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.anggota.edit', $member->id_anggota) }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-md text-black bg-amber-300 hover:bg-amber-400 transition"
                                    aria-label="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
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
            <p class="text-sm text-slate-500">
                Menampilkan {{ $anggota->firstItem() ?? 0 }} hingga {{ $anggota->lastItem() ?? 0 }}
                dari {{ $anggota->total() }} data
            </p>
            @if ($anggota->lastPage() > 1)
                <div class="inline-flex items-center gap-2">
                    <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                        Halaman <span class="font-semibold">{{ $anggota->currentPage() }}</span>
                        dari <span class="font-semibold">{{ $anggota->lastPage() }}</span>
                    </div>
                    <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                        @if ($anggota->onFirstPage())
                            <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"><path d="m15 18-6-6 6-6" /></svg>
                            </span>
                        @else
                            <a href="{{ $anggota->previousPageUrl() }}"
                                class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"><path d="m15 18-6-6 6-6" /></svg>
                            </a>
                        @endif

                        @php
                            $currentPage = $anggota->currentPage();
                            $lastPage    = $anggota->lastPage();
                            $start = max($currentPage - 1, 1);
                            $end   = min($currentPage + 1, $lastPage);
                            if ($currentPage == 1)         $end   = min(3, $lastPage);
                            if ($currentPage == $lastPage) $start = max($lastPage - 2, 1);
                        @endphp

                        @foreach ($anggota->getUrlRange($start, $end) as $page => $url)
                            @if ($page == $anggota->currentPage())
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($anggota->hasMorePages())
                            <a href="{{ $anggota->nextPageUrl() }}"
                                class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
                            </a>
                        @else
                            <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        (function () {
            const selectAllBtn  = document.getElementById('selectAllTopBtn');
            const iconUnchecked = selectAllBtn?.querySelector('.icon-unchecked');
            const iconChecked   = selectAllBtn?.querySelector('.icon-checked');
            const checkboxes    = () => document.querySelectorAll('.row-checkbox');
            let   allSelected   = false;

            selectAllBtn?.addEventListener('click', function () {
                allSelected = !allSelected;
                checkboxes().forEach(cb => cb.checked = allSelected);
                iconUnchecked?.classList.toggle('hidden',  allSelected);
                iconChecked  ?.classList.toggle('hidden', !allSelected);
            });
        })();
    </script>

    @include('components.confirm-delete')

@endsection
