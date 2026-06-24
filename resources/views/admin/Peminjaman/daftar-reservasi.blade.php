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
            <div>
                <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2">
                    <input type="text" placeholder="Cari nomor reservasi / anggota / buku..."
                        class="flex-1 min-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <select
                        class="min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua waktu</option>
                        <option value="today">Hari ini</option>
                        <option value="7">7 hari terakhir</option>
                        <option value="30">30 hari terakhir</option>
                    </select>

                    <select
                        class="min-w-48 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua status</option>
                        <option value="Draft"> Draft</option>
                        <option value="Menunggu Konfirmasi"> Menunggu Konfirmasi</option>
                        <option value="Menunggu Antrian"> Menunggu Antrian</option>
                        <option value="Siap Diambil"> Siap Diambil</option>
                        <option value="Selesai"> Selesai</option>
                        <option value="Ditolak"> Ditolak</option>
                        <option value="Kadaluarsa"> Kadaluarsa</option>
                        <option value="Dibatalkan"> Dibatalkan</option>
                    </select>

                    <button
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        @if (count($reservasi) > 0)
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <h2 class="text-lg font-semibold tracking-wide">
                    {{ count($reservasi) }} Daftar Reservasi
                </h2>

                <div class="flex items-center justify-end gap-3">
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
                </div>
            </div>

            <div class="overflow-x-auto mt-6">
                <table class="min-w-full text-sm text-left text-gray-600 text-nowrap">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                        <tr>
                            <th class="px-6 py-3 w-12">Pilih</th>
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

                                <!-- Checkbox -->
                                <td class="px-6 py-4 align-middle">
                                    <input type="checkbox"
                                        class="row-checkbox h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" />
                                </td>

                                <!-- Anggota -->
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full object-cover"
                                            src="https://i.pravatar.cc/100?u={{ $item['identity'] }}">
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
                                        <img src="{{ $item->buku->cover_buku }}"
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
                                        </div>
                                    @elseif ($item->status == 'Siap Diambil')
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
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
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
