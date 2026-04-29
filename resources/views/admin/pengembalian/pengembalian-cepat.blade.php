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
            if (!isset($quickBooks)) {
                $quickBooks = [
                    [
                        'judul' => 'PostgreSQL : a comprehensive guide to building, programming, and...',
                        'kode_item' => 'E0040150C90DB6E8',
                        'tanggal_pinjam' => '02-04-2026 10:02:22',
                        'jatuh_tempo' => '09-04-2026 10:02:22',
                        'tanggal_kembali' => '08-04-2026 10:02:22',
                    ],
                ];
            }

            if (!isset($member)) {
                $member = [
                    'name' => 'NICOLAS',
                    'id' => '314265',
                    'jenis' => 'Mahasiswa',
                    'phone' => '08123456789',
                    'email' => 'nicolas@gmail.com',
                ];
            }
        @endphp

        <h3 class="font-bold text-lg mb-4">CATAT PENGEMBALIAN CEPAT</h3>

        <div class="mb-4">
            <label class="block text-sm text-slate-600 mb-2">Kode Item Buku (Sedang Dipinjam)</label>
            <input type="text" placeholder="Contoh: E0040150C90DB6E8"
                class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Kode Item</th>
                        <th class="px-6 py-3">Tanggal Pinjam</th>
                        <th class="px-6 py-3">Jatuh Tempo</th>
                        <th class="px-6 py-3">Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quickBooks as $book)
                        <tr class="odd:bg-white even:bg-slate-100">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-md bg-slate-100 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path d="M21 15 16 10 5 21" />
                                    </svg>
                                </div>
                                <div class="max-w-xl">{{ $book['judul'] }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $book['kode_item'] }}</td>
                            <td class="px-6 py-4">{{ $book['tanggal_pinjam'] }}</td>
                            <td class="px-6 py-4">{{ $book['jatuh_tempo'] }}</td>
                            <td class="px-6 py-4">{{ $book['tanggal_kembali'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 border border-slate-200 rounded-md p-4 shadow-sm bg-slate-50">
            <div class="flex gap-6 items-center">
                <div class="w-28 h-28 bg-white rounded-md flex items-center justify-center border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M8 14s1.5-2 4-2 4 2 4 2" />
                        <path d="M8 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>
                </div>
                <div class="flex-1 grid grid-cols-3 gap-4 items-center">
                    <div>
                        <div class="text-xs text-slate-500">Nama Anggota</div>
                        <div class="font-bold">{{ $member['name'] }}</div>
                        <div class="text-xs text-slate-500 mt-2">ID Anggota</div>
                        <div class="font-bold">{{ $member['id'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500">Jenis Anggota</div>
                        <div class="font-bold">{{ $member['jenis'] }}</div>
                        <div class="text-xs text-slate-500 mt-2">Alamat Email</div>
                        <div class="font-bold">{{ $member['email'] }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-500">No Handphone</div>
                        <div class="font-bold">{{ $member['phone'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
