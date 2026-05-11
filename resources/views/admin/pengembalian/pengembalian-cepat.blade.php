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

        @php
            if (!isset($quickBooks)) {
                $quickBooks = [
                    [
                        'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                        'penulis' => 'Yuniar Supardi',
                        'cover' =>
                            'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                        'kode_item' => 'E0040150C90DF610',
                        'tanggal_pinjam' => '02-04-2026 10:02:22',
                        'jatuh_tempo' => '09-04-2026 10:02:22',
                        'tanggal_kembali' => '09-04-2026 10:02:22',
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


        <h3 class="font-bold text-lg mt-4 mb-4">CATAT PENGEMBALIAN CEPAT</h3>

        {{-- Input --}}
        <div class="mb-4">
            <label class="block text-sm text-slate-600 mb-2">
                Kode Item Buku (Sedang Dipinjam)
            </label>

            <input type="text" placeholder="Contoh: E0040150C90DB6E8"
                class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm
            outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto mt-6">
            <table class="min-w-225 w-full text-sm text-left text-gray-600">

                <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                    <tr>
                        <th class="px-4 sm:px-6 py-3">Judul</th>
                        <th class="px-4 sm:px-6 py-3">Kode Item</th>
                        <th class="px-4 sm:px-6 py-3">Tanggal Pinjam</th>
                        <th class="px-4 sm:px-6 py-3">Jatuh Tempo</th>
                        <th class="px-4 sm:px-6 py-3">Tanggal Kembali</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($quickBooks as $book)
                        <tr class="odd:bg-white even:bg-slate-100">

                            <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">

                                <div class="flex items-start gap-4 min-w-70">

                                    <div class="flex items-center gap-4 min-w-70">

                                        <img src="{{ $book['cover'] }}" class="w-12 h-16 object-cover rounded shadow-sm" />

                                        <div>
                                            <h4 class="max-w-xs line-clamp-2 leading-5 font-bold">{{ $book['judul'] }}</h4>
                                            <p>{{ $book['penulis'] }}</p>
                                        </div>

                                    </div>
                                </div>
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $book['kode_item'] }}
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $book['tanggal_pinjam'] }}
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $book['jatuh_tempo'] }}
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $book['tanggal_kembali'] }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- Member Info --}}
        <div class="mt-6 border border-slate-200 rounded-md p-4 shadow-sm bg-slate-50">

            <div class="flex flex-col lg:flex-row gap-6 lg:items-center">

                {{-- Avatar --}}
                <div class="w-28 h-28 bg-white rounded-md flex items-center justify-center border shrink-0 mx-auto lg:mx-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M8 14s1.5-2 4-2 4 2 4 2" />
                        <path d="M8 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>
                </div>

                {{-- Member Detail --}}
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <div class="text-xs text-slate-500">Nama Anggota</div>
                        <div class="font-bold wrap-break-word ">{{ $member['name'] }}</div>

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
    </div>
@endsection
