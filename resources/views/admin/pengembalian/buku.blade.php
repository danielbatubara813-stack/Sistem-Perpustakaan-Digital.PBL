@extends('layout.app-admin')
@section('title', 'Pengembalian')
@php
    $title = 'Pengembalian';
    $description = 'Kelola pengembalian buku dan catat pengembalian baru.';
@endphp
@section('content')
    <div class="bg-white p-4 sm:p-6 rounded-lg mt-4 shadow-lg">

        {{-- Tabs --}}
        @include('components.submenu-admin')

        <h3 class="font-bold text-lg mt-4 mb-4">CATAT PENGEMBALIAN</h3>

        <form action="" method="GET">
            @method('GET')
            @csrf
            {{-- Input ID --}}
            <div class="mb-4">
                <label class="block text-sm text-slate-600 mb-2">ID Anggota</label>

                <div class="flex gap-4">
                    <input type="text" name="nomor_identitas" value="{{ request('nomor_identitas') }}"
                        placeholder="Contoh: 3312501012"
                        class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    <button type="submit" class="px-4 py-3 bg-blue-600 text-white rounded-md">
                        Cari
                    </button>
                </div>
            </div>
        </form>

        {{-- peminjaman Info --}}
        @if ($anggota)
            <div class="mb-6 border border-slate-200 rounded-md p-4 shadow-sm bg-slate-50">

                <div class="flex flex-col lg:flex-row gap-6 lg:items-center">

                    {{-- Avatar --}}
                    <div
                        class="w-28 h-28 bg-white rounded-md flex items-center justify-center border shrink-0 mx-auto lg:mx-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M8 14s1.5-2 4-2 4 2 4 2" />
                            <path d="M8 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                        </svg>
                    </div>

                    {{-- Detail --}}
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        <div>
                            <div class="text-xs text-slate-500">Nama Anggota</div>
                            <div class="font-bold wrap-break-word">{{ $anggota->nama }}</div>

                            <div class="text-xs text-slate-500 mt-2">ID Anggota</div>
                            <div class="font-bold wrap-break-word">{{ $anggota->nomor_identitas }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-500">Jenis Anggota</div>
                            <div class="font-bold wrap-break-word">{{ $anggota->jenisKeanggotaan->nama_jenis }}</div>

                            <div class="text-xs text-slate-500 mt-2">Alamat Email</div>
                            <div class="font-bold wrap-break-word">{{ $anggota->email }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-500">No Handphone</div>
                            <div class="font-bold wrap-break-word">{{ $anggota->no_hp }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Table --}}
        @if ($anggota)
            <div class="overflow-x-auto mt-6">
                @if (request()->filled('nomor_identitas'))

                    @if ($peminjamanLoans->count())
                        <table class="min-w-237.5 w-full text-sm text-left text-gray-600">

                            <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 w-32">Pilih</th>
                                    <th class="px-4 sm:px-6 py-3">Judul</th>
                                    <th class="px-4 sm:px-6 py-3">Kode Item</th>
                                    <th class="px-4 sm:px-6 py-3">Tanggal Pinjam</th>
                                    <th class="px-4 sm:px-6 py-3">Jatuh Tempo</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($peminjamanLoans as $loan)
                                    <tr class="odd:bg-white even:bg-slate-100">

                                        {{-- Button --}}
                                        <td class="px-4 sm:px-6 py-4 align-top">
                                            <form action="{{ route('admin.pengembalian.kembalikan') }}" method="POST">
                                                @method('POST')
                                                @csrf
                                                <input type="hidden" name="kode_peminjaman"
                                                    value="{{ $loan->kode_peminjaman }}">
                                                <button type="submit"
                                                    class="px-3 py-1 rounded-md bg-slate-200 text-slate-700 hover:bg-slate-300 transition whitespace-nowrap">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Judul --}}
                                        <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">

                                            <div class="flex items-start gap-4 min-w-70">

                                                <div class="flex items-center gap-4 min-w-70">

                                                    <img src="{{ $loan->itemBuku->buku->cover_buku }}"
                                                        class="w-12 h-16 object-cover rounded shadow-sm" />

                                                    <div>
                                                        <h4 class="max-w-xs line-clamp-2 leading-5 font-bold">
                                                            {{ $loan->itemBuku->buku->judul_buku }}
                                                        </h4>
                                                        @foreach ($loan->itemBuku->buku->penulis as $item)
                                                            <span>{{ $item->nama_penulis }}</span>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            </div>

                                        </td>

                                        {{-- Kode --}}
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            {{ $loan->itemBuku->id_item }}
                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            {{ $loan->tanggal_peminjaman }}
                                        </td>

                                        {{-- Jatuh Tempo --}}
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            {{ $loan->tanggal_jatuh_tempo }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <div class="p-4 bg-yellow-100 rounded">
                            Tidak ada data peminjaman ditemukan.
                        </div>
                    @endif

                @endif
            </div>
        @endif

    </div>
@endsection
