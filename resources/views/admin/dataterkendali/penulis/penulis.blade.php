@extends('layout.app-admin')

@section('title', 'Kelola Tipe Koleksi')
@php
    $title = 'Daftar Tipe Koleksi';
    $description = 'Kelola Tipe Koleksi untuk tipe buku perpustakaan';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        <div class="flex items-center justify-between">
            <div class="">
                <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2">
                    <input id="search" type="text" placeholder="Cari..."
                        class="flex-1 min-w-36 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    <select id="filter-status"
                        class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Status</option>
                        <option>Aktif</option>
                        <option>Tidak Aktif</option>
                    </select>
                    <select id="filter-sort"
                        class="min-w-36 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Terbaru</option>
                        <option>Terlama</option>
                    </select>
                    <button
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition"
                        aria-label="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <a href="{{ route('admin.data-terkendali.penulis.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-3 py-2 text-sm shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Tambah Penulis
                </a>
            </div>
        </div>

    </div>
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold tracking-wide">{{ count($penulis) }} Daftar penulis</h2>
            </div>
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
                        <th class="px-6 py-3">Penulis</th>
                        <th class="px-6 py-3">Tipe Penulis</th>
                        <th class="px-6 py-3 hidden lg:table-cell">Tanggal Dibuat</th>
                        <th class="px-6 py-3 hidden lg:table-cell">Tanggal Diubah</th>
                        <th class="px-6 py-3 text-right w-12">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penulis as $data)
                        <tr
                            class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100">
                            <td class="px-6 py-4">
                                <input type="checkbox"
                                    class="row-checkbox h-5 w-5 rounded-full border-slate-300 text-blue-600 focus:ring-blue-500" />
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $data['nama'] }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $data['tipe'] }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">{{ $data['created_at'] }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">{{ $data['updated_at'] }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="#"
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
            <p class="text-sm text-slate-500">Menampilkan 1 hingga {{ count($penulis) }} dari
                {{ count($penulis) }} data
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
