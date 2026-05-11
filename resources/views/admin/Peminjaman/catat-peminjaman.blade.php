@extends('layout.app-admin')
@section('title', 'Peminjaman')
@php
    $title = 'Peminjaman';
    $description = 'Kelola daftar peminjaman buku dan catat peminjaman baru.';
@endphp
@section('content')
    <div class="bg-white p-4 sm:p-6 rounded-lg mt-4 shadow-lg">

        {{-- Tabs --}}
        <div class="mb-4">
            @include('components.submenu-admin')
        </div>

        @php
            if (!isset($member)) {
                $member = [
                    'name' => 'NICOLAS',
                    'id' => '314265',
                    'jenis' => 'Mahasiswa',
                    'phone' => '08123456789',
                    'email' => 'nicolas@gmail.com',
                ];
            }

            if (!isset($memberLoans)) {
                $memberLoans = [
                    [
                        'judul' => 'Laut Bercerita',
                        'penulis' => 'Leila S. Chudori',
                        'cover' =>
                            'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
                        'kode_item' => 'E0040150C90DB6E8',
                        'tanggal_pinjam' => '02-04-2026 10:02:22',
                        'jatuh_tempo' => '02-04-2026 10:02:22',
                    ],
                    [
                        'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                        'penulis' => 'Yuniar Supardi',
                        'cover' =>
                            'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                        'kode_item' => 'E0040150C90DF610',
                        'tanggal_pinjam' => '02-04-2026 10:02:22',
                        'jatuh_tempo' => '02-04-2026 10:02:22',
                    ],
                ];
            }
        @endphp

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">

            <h3 class="font-bold text-lg">
                CATAT PENGEMBALIAN
            </h3>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 w-full lg:w-auto">

                <button
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                bg-blue-600 hover:bg-blue-700 text-white rounded-md
                px-4 py-2 text-sm shadow-sm transition">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-save-icon lucide-save">

                        <path
                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />

                    </svg>

                    Mulai Peminjaman
                </button>

                <a href="{{ route('admin.peminjaman') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                bg-red-600 hover:bg-red-700 text-white rounded-md
                px-4 py-2 text-sm shadow-sm transition">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash2-icon lucide-trash-2">

                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />

                    </svg>

                    Batal Peminjaman
                </a>

            </div>
        </div>

        {{-- Input Member --}}
        <div class="mb-4">
            <label class="block text-sm text-slate-600 mb-2">
                ID Anggota
            </label>

            <input type="text" placeholder="Contoh: 3312501012"
                class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm
            outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
        </div>

        {{-- Member Info --}}
        <div class="mb-6 border border-slate-200 rounded-md p-4 shadow-sm bg-slate-50">

            <div class="flex flex-col lg:flex-row gap-6 lg:items-center">

                {{-- Avatar --}}
                <div
                    class="w-28 h-28 bg-white rounded-md flex items-center justify-center border
                shrink-0 mx-auto lg:mx-0">

                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">

                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M8 14s1.5-2 4-2 4 2 4 2" />
                        <path d="M8 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />

                    </svg>
                </div>

                {{-- Detail --}}
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <div class="text-xs text-slate-500">Nama Anggota</div>
                        <div class="font-bold wrap-break-word">{{ $member['name'] }}</div>

                        <div class="text-xs text-slate-500 mt-2">ID Anggota</div>
                        <div class="font-bold wrap-break-word">{{ $member['id'] }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-slate-500">Jenis Anggota</div>
                        <div class="font-bold wrap-break-word">{{ $member['jenis'] }}</div>

                        <div class="text-xs text-slate-500 mt-2">Alamat Email</div>
                        <div class="font-bold wrap-break-word">{{ $member['email'] }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-slate-500">No Handphone</div>
                        <div class="font-bold wrap-break-word">{{ $member['phone'] }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Input Buku --}}
        <div class="mb-4">
            <label class="block text-sm text-slate-600 mb-2">
                Kode Item Buku (Harus Tersedia)
            </label>

            <input type="text" placeholder="Contoh: E0040150C90DB6E8"
                class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm
            outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto mt-6">

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
                    @foreach ($memberLoans as $loan)
                        <tr class="odd:bg-white even:bg-slate-100">

                            {{-- Action --}}
                            <td class="px-4 sm:px-6 py-4 align-top">
                                <button
                                    class="px-3 py-1 rounded-md bg-slate-200 text-slate-700
                                hover:bg-slate-300 transition whitespace-nowrap">

                                    Perpanjang
                                </button>
                            </td>

                            {{-- Judul --}}
                            <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">

                                <div class="flex items-center gap-4 min-w-70">

                                    <img src="{{ $loan['cover'] }}" class="w-12 h-16 object-cover rounded shadow-sm" />

                                    <div>
                                        <h4 class="max-w-xs line-clamp-2 leading-5 font-bold">{{ $loan['judul'] }}</h4>
                                        <p>{{ $loan['penulis'] }}</p>
                                    </div>

                                </div>
                            </td>

                            {{-- Kode --}}
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $loan['kode_item'] }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $loan['tanggal_pinjam'] }}
                            </td>

                            {{-- Jatuh Tempo --}}
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $loan['jatuh_tempo'] }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
@endsection
