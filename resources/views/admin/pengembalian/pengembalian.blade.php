{{-- Halaman Pengembalian (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Pengembalian')
@php
    $title = 'Pengembalian';
    $description = 'Kelola pengembalian buku dan catat pengembalian baru.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        {{-- Tabs --}}

        <div class="mb-4 flex items-center justify-between">
            <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                <a href="{{ route('admin.pengembalian') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.pengembalian') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">Daftar
                    Pengembalian</a>
                <a href="{{ route('admin.pengembalian.buku') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.pengembalian.buku') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">Pengembalian
                    Buku</a>
                <a href="{{ route('admin.pengembalian.cepat') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.pengembalian.cepat') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">Pengembalian
                    Cepat</a>
            </div>
        </div>
        @php
            if (!isset($member)) {
                $member = [
                    'name' => 'NICOLAS',
                    'id' => '314265',
                ];
            }

            if (!isset($memberLoans)) {
                $memberLoans = [
                    [
                        'judul' => 'PostgreSQL : a comprehensive guide to building, programming, and...',
                        'kode_item' => 'E0040150C90DB6E8',
                        'tanggal_pinjam' => '02-04-2026 10:02:22',
                        'jatuh_tempo' => '09-04-2026 10:02:22',
                        'tanggal_kembali' => '08-04-2026 10:02:22',
                        'denda' => '0 Rp',
                    ],
                    [
                        'judul' => 'Laut Bercerita',
                        'kode_item' => 'E0040150C90DF610',
                        'tanggal_pinjam' => '02-04-2026 10:02:22',
                        'jatuh_tempo' => '09-04-2026 10:02:22',
                        'tanggal_kembali' => '09-04-2026 10:02:22',
                        'denda' => '5.000 Rp',
                    ],
                ];
            }
        @endphp

        <div class="flex items-center justify-between mb-6">
            <div class="">
                <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2">
                    <input id="search2" type="text" placeholder="Cari..."
                        class="flex-1 min-w-56 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    <select id="filter-tanggal2"
                        class="min-w-40 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Hari ini</option>
                        <option>7 hari</option>
                        <option>30 hari</option>
                    </select>
                    <select id="filter-status2"
                        class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option>Semua Status</option>
                        <option>Dikembalikan</option>
                        <option>Terlambat</option>
                        <option>Hilang</option>
                    </select>
                    <select id="filter-sort2"
                        class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
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

                <!-- Export PDF removed to match wireframe -->
            </div>
        </div>

        <h4 class="text-sm font-semibold mb-2">12 Daftar Pengembalian</h4>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 w-12">Pilih</th>
                        <th class="px-6 py-3">Anggota</th>
                        <th class="px-6 py-3">Kode Item</th>
                        <th class="px-6 py-3">Tanggal Pinjam</th>
                        <th class="px-6 py-3">Jatuh Tempo</th>
                        <th class="px-6 py-3">Tanggal Kembali</th>
                        <th class="px-6 py-3">Denda</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memberLoans as $loan)
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
                                    <div>{{ $member['name'] }}</div>
                                    <div class="text-xs text-slate-500">{{ $member['id'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $loan['kode_item'] }}</td>
                            <td class="px-6 py-4">{{ $loan['tanggal_pinjam'] }}</td>
                            <td class="px-6 py-4">{{ $loan['jatuh_tempo'] }}</td>
                            <td class="px-6 py-4">{{ $loan['tanggal_kembali'] ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $loan['denda'] ?? '0 Rp' }}</td>
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
    </div>
@endsection
