{{-- Halaman Reservasi (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Reservasi')
@php
    $title = 'Reservasi';
    $description = 'Kelola daftar reservasi buku dan konfirmasi permintaan anggota.';
@endphp

@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        <div class="flex items-center justify-between">
            <form action="" method="GET">
                @method('GET')
                @csrf
                <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2">
                    <input name="search" type="text" placeholder="Cari nomor reservasi / anggota / buku..."
                        class="flex-1 min-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <select name="waktu"
                        class="min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua waktu</option>
                        <option value="today" {{ request('waktu') == 'today' ? 'selected' : '' }}>Hari ini</option>
                        <option value="7" {{ request('waktu') == '7' ? 'selected' : '' }}>7 hari terakhir</option>
                        <option value="30" {{ request('waktu') == '30' ? 'selected' : '' }}>30 hari terakhir</option>
                    </select>

                    <select name="status"
                        class="min-w-48 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua status</option>
                        <option value="Menunggu Konfirmasi"
                            {{ request('status') == 'Menunggu Konfirmasi' ? 'selected' : '' }}> Menunggu Konfirmasi</option>
                        <option value="Menunggu Antrian" {{ request('status') == 'Menunggu Antrian' ? 'selected' : '' }}>
                            Menunggu Antrian</option>
                        <option value="Siap Diambil" {{ request('status') == 'Siap Diambil' ? 'selected' : '' }}> Siap
                            Diambil</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}> Selesai</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}> Ditolak</option>
                        <option value="Kadaluarsa" {{ request('status') == 'Kadaluarsa' ? 'selected' : '' }}> Kadaluarsa
                        </option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}> Dibatalkan
                        </option>
                    </select>

                    <button type="submit"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-600 border border-slate-300 text-white hover:bg-blue-700 transition">
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

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        @if (count($reservasi) > 0)
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <h2 class="text-lg font-semibold tracking-wide">
                    {{ count($reservasi) }} Daftar Reservasi
                </h2>
            </div>

            <div class="overflow-x-auto mt-6">
                <table class="min-w-full text-sm text-left text-gray-600 text-nowrap">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                        <tr>
                            <th class="px-6 py-3 w-12">No Reservasi</th>
                            <th class="px-6 py-3">Anggota</th>
                            <th class="px-6 py-3">Buku</th>
                            <th class="px-6 py-3">Tanggal Pengajuan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($reservasi as $item)
                            <tr class="hover:bg-gray-100 odd:bg-white even:bg-slate-50 transition">
                                <td class="px-6 py-4 align-middle font-bold">
                                    {{ $item->nomor_reservasi }}
                                </td>

                                <!-- Anggota -->
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full object-cover object-top"
                                            src="{{ $item->anggota->profile && Storage::disk('public')->exists($item->anggota->profile) ? asset('storage/' . $item->anggota->profile) : asset('static/profileDefault.jpg') }}">
                                        <div>
                                            <div class="font-medium text-gray-900 leading-tight">
                                                {{ $item->anggota->nama }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $item->anggota->nomor_identitas }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Buku -->
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item->buku->cover_buku && Storage::disk('public')->exists('covers/' . $item->buku->cover_buku)
                                            ? asset('storage/covers/' . $item->buku->cover_buku)
                                            : asset('static/bookcover.png') }}"
                                            class="w-12 h-16 object-cover rounded shadow-sm" />
                                        <div>
                                            <div class="font-medium text-gray-900 leading-tight">
                                                {{ $item->buku->judul_buku }}
                                            </div>
                                            @if ($item->id_item)
                                                <div class="text-xs text-slate-500">
                                                    {{ $item->id_item }}
                                                </div>
                                            @else
                                                <div class="text-xs text-slate-500">
                                                    Buku direservasi belum tersedia
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Tanggal -->
                                <td class="px-6 py-4 align-middle whitespace-nowrap">
                                    {{ $item->tanggal_diajukan }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 align-middle">
                                    @if (in_array($item->status, ['Menunggu Konfirmasi', 'Siap Diambil']))
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                            {{ $item->status }}
                                        </span>
                                    @elseif ($item->status == 'Selesai')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            {{ $item->status }}
                                        </span>
                                    @elseif ($item->status == 'Menunggu Antrian')
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                            {{ $item->status }}
                                        </span>
                                    @elseif (in_array($item->status, ['Ditolak', 'Kadaluarsa', 'Dibatalkan']))
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            {{ $item->status }}
                                        </span>
                                    @elseif ($item->status == 'Draft')
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 align-middle text-center">
                                    @if ($item->status == 'Menunggu Konfirmasi')
                                        <div class="flex justify-center gap-2">
                                            {{-- Setujui --}}
                                            <form action="{{ route('admin.peminjaman.reservasi.disetujui') }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="nomor_reservasi"
                                                    value="{{ $item->nomor_reservasi }}">
                                                <button type="submit"
                                                    class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                    Setujui
                                                </button>
                                            </form>


                                            {{-- Tolak --}}
                                            <form action="{{ route('admin.peminjaman.reservasi.ditolak') }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="nomor_reservasi"
                                                    value="{{ $item->nomor_reservasi }}">
                                                <button type="submit"
                                                    class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                    Tolak
                                                </button>
                                            </form>

                                            <button data-modal-target="modal-reservasi-{{ $item->nomor_reservasi }}"
                                                data-modal-toggle="modal-reservasi-{{ $item->nomor_reservasi }}"
                                                class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                                type="button">
                                                Detail
                                            </button>
                                        </div>
                                    @elseif ($item->status == 'Siap Diambil')
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('admin.peminjaman.reservasi.jadikan-peminjaman') }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="nomor_reservasi"
                                                    value="{{ $item->nomor_reservasi }}">
                                                <button type="submit"
                                                    class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                    Jadikan Peminjaman
                                                </button>
                                            </form>
                                            <button data-modal-target="modal-reservasi-{{ $item->nomor_reservasi }}"
                                                data-modal-toggle="modal-reservasi-{{ $item->nomor_reservasi }}"
                                                class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                                type="button">
                                                Detail
                                            </button>
                                        </div>
                                    @else
                                        <button data-modal-target="modal-reservasi-{{ $item->nomor_reservasi }}"
                                            data-modal-toggle="modal-reservasi-{{ $item->nomor_reservasi }}"
                                            class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                            type="button">
                                            Detail
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            <div id="modal-reservasi-{{ $item->nomor_reservasi }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div
                                        class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                            <h3 class="text-lg font-medium text-heading">
                                                Detail Reservasi {{ $item->nomor_reservasi }}
                                            </h3>
                                            <button type="button"
                                                class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="modal-reservasi-{{ $item->nomor_reservasi }}">
                                                <svg class="w-5 h-5" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18 17.94 6M18 18 6.06 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="space-y-6 py-4">

                                            <!-- Status -->
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-slate-800">
                                                        {{ $item->nomor_reservasi }}
                                                    </h3>
                                                    <p class="text-sm text-slate-500">
                                                        Diajukan
                                                        {{ \Carbon\Carbon::parse($item->tanggal_diajukan)->translatedFormat('d F Y H:i') }}
                                                    </p>
                                                </div>

                                                @if (in_array($item->status, ['Menunggu Konfirmasi', 'Siap Diambil']))
                                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                                        {{ $item->status }}
                                                    </span>
                                                @elseif ($item->status == 'Menunggu Antrian')
                                                    <span
                                                        class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                                        {{ $item->status }}
                                                    </span>
                                                @elseif ($item->status == 'Selesai')
                                                    <span
                                                        class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                        {{ $item->status }}
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                        {{ $item->status }}
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Anggota -->
                                            <div class="border border-gray-300 rounded-md shadow-md p-4">
                                                <h4 class="font-semibold text-slate-700 mb-3">
                                                    Informasi Anggota
                                                </h4>

                                                <div class="flex gap-4 items-center">
                                                    <img class="w-16 h-16 rounded-full object-cover"
                                                        src="{{ $item->anggota->profile && Storage::disk('public')->exists($item->anggota->profile)
                                                            ? asset('storage/' . $item->anggota->profile)
                                                            : asset('static/profileDefault.jpg') }}">

                                                    <div>
                                                        <h5 class="font-semibold text-gray-900">
                                                            {{ $item->anggota->nama }}
                                                        </h5>

                                                        <p class="text-sm text-slate-500">
                                                            {{ $item->anggota->nomor_identitas }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Buku -->
                                            <div class="border border-gray-300 rounded-md shadow-md p-4">
                                                <h4 class="font-semibold text-slate-700 mb-3">
                                                    Informasi Buku
                                                </h4>

                                                <div class="flex gap-4">
                                                    <img src="{{ $item->buku->cover_buku && Storage::disk('public')->exists('covers/' . $item->buku->cover_buku)
                                                        ? asset('storage/covers/' . $item->buku->cover_buku)
                                                        : asset('static/bookcover.png') }}"
                                                        class="w-24 h-32 rounded-lg object-cover shadow">

                                                    <div class="space-y-2">

                                                        <div>
                                                            <p class="text-xs text-slate-500">Judul Buku</p>
                                                            <p class="font-medium">{{ $item->buku->judul_buku }}</p>
                                                        </div>

                                                        <div>
                                                            <p class="text-xs text-slate-500">Item Buku</p>

                                                            @if ($item->id_item)
                                                                <p class="font-medium">{{ $item->id_item }}</p>
                                                            @else
                                                                <p class="text-red-500">
                                                                    Belum dialokasikan
                                                                </p>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Timeline -->
                                            <div class="border border-gray-300 rounded-md shadow-md p-4">
                                                <h4 class="font-semibold text-slate-700 mb-4">
                                                    Riwayat Reservasi
                                                </h4>

                                                <div class="space-y-3">

                                                    <div class="flex justify-between border-b border-gray-300 pb-2">
                                                        <span class="text-slate-500">Ditambahkan</span>
                                                        <span>{{ $item->tanggal_ditambahkan }}</span>
                                                    </div>

                                                    <div class="flex justify-between border-b border-gray-300 pb-2">
                                                        <span class="text-slate-500">Diajukan</span>
                                                        <span>{{ $item->tanggal_diajukan }}</span>
                                                    </div>

                                                    <div class="flex justify-between border-b border-gray-300 pb-2">
                                                        <span class="text-slate-500">Dialokasikan</span>
                                                        <span>{{ $item->tanggal_diterima ?? '-' }}</span>
                                                    </div>

                                                    <div class="flex justify-between border-b border-gray-300 pb-2">
                                                        <span class="text-slate-500">Dikonfirmasi</span>
                                                        <span>{{ $item->tanggal_konfirmasi ?? '-' }}</span>
                                                    </div>

                                                    <div class="flex justify-between border-b border-gray-300 pb-2">
                                                        <span class="text-slate-500">Batas Pengambilan</span>
                                                        <span>{{ $item->tanggal_expired ?? '-' }}</span>
                                                    </div>

                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500">Selesai</span>
                                                        <span>{{ $item->tanggal_selesai ?? '-' }}</span>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- Modal footer -->
                                        <div class="flex items-center border-t border-default space-x-4 pt-4 md:pt-5">
                                            <button data-modal-hide="modal-reservasi-{{ $item->nomor_reservasi }}"
                                                type="button"
                                                class="text-gray-700 bg-gray-200 box-border border border-default-medium hover:bg-gray-300 hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $reservasi->firstItem() ?? 0 }} hingga {{ $reservasi->lastItem() ?? 0 }}
                    dari {{ $reservasi->total() }} data
                </p>
                @if ($reservasi->lastPage() > 1)
                    <div class="inline-flex items-center gap-2">
                        <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                            Halaman <span class="font-semibold">{{ $reservasi->currentPage() }}</span>
                            dari <span class="font-semibold">{{ $reservasi->lastPage() }}</span>
                        </div>
                        <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                            @if ($reservasi->onFirstPage())
                                <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $reservasi->previousPageUrl() }}"
                                    class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </a>
                            @endif

                            @php
                                $currentPage = $reservasi->currentPage();
                                $lastPage = $reservasi->lastPage();
                                $start = max($currentPage - 1, 1);
                                $end = min($currentPage + 1, $lastPage);
                                if ($currentPage == 1) {
                                    $end = min(3, $lastPage);
                                }
                                if ($currentPage == $lastPage) {
                                    $start = max($lastPage - 2, 1);
                                }
                            @endphp

                            @foreach ($reservasi->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $reservasi->currentPage())
                                    <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($reservasi->hasMorePages())
                                <a href="{{ $reservasi->nextPageUrl() }}"
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
