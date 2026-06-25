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

        <h3 class="font-bold text-lg mt-4 mb-4">CATAT PENGEMBALIAN CEPAT</h3>

        {{-- Input --}}
        <form action="{{ route('admin.pengembalian.cepat-process') }}" method="POST">
            @method('POST')
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-slate-600 mb-2">
                    Kode Item Buku (Sedang Dipinjam)
                </label>

                <input type="text" placeholder="Contoh: E0040150C90DB6E8" name="id_item"
                    class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm
            outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
            </div>
        </form>

        {{-- Table --}}
        @if ($peminjaman)
            <div class="overflow-x-auto mt-6">
                <table class="min-w-225 w-full text-sm text-left text-gray-600">

                    <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                        <tr>
                            <th class="px-4 sm:px-6 py-3">Judul</th>
                            <th class="px-4 sm:px-6 py-3">Kode Item</th>
                            <th class="px-4 sm:px-6 py-3">Masa Peminjaman</th>
                            <th class="px-4 sm:px-6 py-3">Tanggal Kembali</th>
                            <th class="px-4 sm:px-6 py-3">Total Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="odd:bg-white even:bg-slate-100">

                            {{-- Judul --}}
                            <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">

                                <div class="flex items-start gap-4 min-w-70">

                                    <div class="flex items-center gap-4 min-w-70">

                                        <img src="{{ $peminjaman->itemBuku->buku->cover_buku }}"
                                            class="w-12 h-16 object-cover rounded shadow-sm" />

                                        <div>
                                            <h4 class="max-w-xs line-clamp-2 leading-5 font-bold">
                                                {{ $peminjaman->itemBuku->buku->judul_buku }}
                                            </h4>
                                            @foreach ($peminjaman->itemBuku->buku->penulis as $item)
                                                <span>{{ $item->nama_penulis }}</span>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                            </td>

                            {{-- Kode --}}
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $peminjaman->itemBuku->id_item }}
                            </td>

                            {{-- Jatuh Tempo --}}
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap flex flex-col">
                                <span>
                                    Tanggal Pinjam: {{ $peminjaman->tanggal_peminjaman }}
                                </span>
                                <span>
                                    Tanggal Jatuh Tempo: {{ $peminjaman->tanggal_jatuh_tempo }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ now()->format('Y-m-d') }}
                            </td>
                            @php
                                $jatuhTempo = strtotime($peminjaman->tanggal_jatuh_tempo);
                                $sekarang = strtotime(date('Y-m-d'));

                                $jumlahHariKeterlambatan = floor(($sekarang - $jatuhTempo) / (60 * 60 * 24));

                                if ($jumlahHariKeterlambatan < 0) {
                                    $jumlahHariKeterlambatan = 0;
                                }

                                $total_denda = $jumlahHariKeterlambatan * 1000;
                            @endphp
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap {{ $total_denda > 0 ? 'text-red-600 font-bold' : '' }}">
                                Rp {{ number_format($total_denda, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        @endif

        {{-- Member Info --}}
        @if ($peminjaman)
            @if ($peminjaman->anggota)
                <div class="mt-6 border border-slate-200 rounded-md p-4 shadow-sm bg-slate-50">

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
                                <div class="font-bold wrap-break-word">{{ $peminjaman->anggota->nama }}</div>

                                <div class="text-xs text-slate-500 mt-2">ID Anggota</div>
                                <div class="font-bold wrap-break-word">{{ $peminjaman->anggota->nomor_identitas }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-slate-500">Jenis Anggota</div>
                                <div class="font-bold wrap-break-word">
                                    {{ $peminjaman->anggota->jenisKeanggotaan->nama_jenis }}
                                </div>

                                <div class="text-xs text-slate-500 mt-2">Alamat Email</div>
                                <div class="font-bold wrap-break-word">{{ $peminjaman->anggota->email }}</div>
                            </div>

                            <div>
                                <div class="text-xs text-slate-500">No Handphone</div>
                                <div class="font-bold wrap-break-word">{{ $peminjaman->anggota->no_hp }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>
@endsection
