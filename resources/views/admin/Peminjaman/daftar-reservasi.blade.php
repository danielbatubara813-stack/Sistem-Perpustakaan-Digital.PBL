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
                    <input type="text" placeholder="Cari..."
                        class="flex-1 min-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <select
                        class="min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Hari ini</option>
                        <option>7 hari</option>
                        <option>30 hari</option>
                    </select>

                    <select
                        class="min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Menunggu</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                    </select>

                    <button
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                        🔍
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash2-icon lucide-trash-2">
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
            <table class="min-w-full text-sm text-left text-gray-600">
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
                                            {{ $item['nama_pengaju'] }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $item['identity'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Buku -->
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['cover'] }}" class="w-12 h-16 object-cover rounded shadow-sm" />
                                    <div>
                                        <div class="font-medium text-gray-900 leading-tight">
                                            {{ $item['judul'] }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $item['penulis'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                {{ $item['tanggal_pengajuan'] }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 align-middle">
                                @if ($item['status_reservasi'] == 'Menunggu Konfirmasi')
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                        Menunggu
                                    </span>
                                @elseif ($item['status_reservasi'] == 'Sudah Konfirmasi')
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 align-middle text-center">
                                @if ($item['status_reservasi'] == 'Menunggu Konfirmasi')
                                    <div class="flex justify-center gap-2">
                                        <button
                                            class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition">
                                            Setujui
                                        </button>
                                        <button
                                            class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                            Tolak
                                        </button>
                                    </div>
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
            <p class="text-sm text-slate-500">Menampilkan 1 hingga {{ count($reservasi) }} dari {{ count($reservasi) }} data
            </p>
            <div class="inline-flex items-center rounded-2xl bg-slate-100 p-1">
                <button
                    class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">&lt;</button>
                <button class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-medium text-white">1</button>
                <button
                    class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">2</button>
                <button
                    class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">3</button>
                <button
                    class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">&gt;</button>
            </div>
        </div>
    </div>
@endsection
