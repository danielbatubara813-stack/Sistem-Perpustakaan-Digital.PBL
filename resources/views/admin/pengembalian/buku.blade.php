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
            <div class="mb-4">
                <label class="block text-sm text-slate-600 mb-2">
                    ID Anggota
                </label>

                <div class="relative flex gap-4 items-center">
                    {{-- Input Search --}}
                    <input type="text" id="searchAnggota" placeholder="Cari nomor identitas atau nama..." autocomplete="off"
                        class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">

                    {{-- Value yang dikirim --}}
                    <input type="hidden" name="nomor_identitas" id="nomor_identitas"
                        value="{{ request('nomor_identitas') }}">

                    {{-- Dropdown --}}
                    <div id="dropdownAnggota"
                        class="absolute top-12 left-0 right-0 mt-1 bg-white border border-slate-300 rounded-md shadow-lg max-h-64 max-w-80 overflow-y-auto hidden z-20">

                        @foreach ($anggotaData as $item)
                            <div class="anggota-item px-4 py-3 cursor-pointer hover:bg-blue-50 border-b border-gray-300 last:border-b-0"
                                data-id="{{ $item->nomor_identitas }}"
                                data-search="{{ strtolower($item->nomor_identitas . ' ' . $item->nama) }}">

                                <div class="font-medium">
                                    {{ $item->nama }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $item->nomor_identitas }}
                                </div>
                            </div>
                        @endforeach

                    </div>

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
                    <img class="w-28 h-28 rounded-xl object-cover object-top shadow-md"
                        src="{{ $anggota->profile && Storage::disk('public')->exists($anggota->profile)
                            ? asset('storage/' . $anggota->profile)
                            : asset('static/profileDefault.jpg') }}"
                        alt="{{ $anggota->nama }}">

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

                    @if ($peminjaman->count())
                        <table class="min-w-237.5 w-full text-sm text-left text-gray-600">

                            <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 w-32">Pilih</th>
                                    <th class="px-4 sm:px-6 py-3">Judul</th>
                                    <th class="px-4 sm:px-6 py-3">Kode Item</th>
                                    <th class="px-4 sm:px-6 py-3">Tanggal Pinjam</th>
                                    <th class="px-4 sm:px-6 py-3">Jatuh Tempo</th>
                                    <th class="px-4 sm:px-6 py-3">Total Denda</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($peminjaman as $loan)
                                    <tr class="odd:bg-white even:bg-slate-100">

                                        {{-- Button --}}
                                        <td class="px-4 sm:px-6 py-4 align-top">
                                            <form action="{{ route('admin.pengembalian.kembalikan') }}" method="POST">
                                                @method('POST')
                                                @csrf
                                                <input type="hidden" name="kode_peminjaman"
                                                    value="{{ $loan->kode_peminjaman }}">
                                                <button type="submit"
                                                    class="px-3 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition whitespace-nowrap">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Judul --}}
                                        <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">

                                            <div class="flex items-start gap-4 min-w-70">

                                                <div class="flex items-center gap-4 min-w-70">

                                                    <img src="{{ $loan->itemBuku->buku->cover_buku &&
                                                    Storage::disk('public')->exists('covers/' . $loan->itemBuku->buku->cover_buku)
                                                        ? asset('storage/covers/' . $loan->itemBuku->buku->cover_buku)
                                                        : asset('static/bookcover.png') }}"
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
                                        @php
                                            $jatuhTempo = strtotime($loan->tanggal_jatuh_tempo);
                                            $sekarang = strtotime(date('Y-m-d'));

                                            $jumlahHariKeterlambatan = floor(
                                                ($sekarang - $jatuhTempo) / (60 * 60 * 24),
                                            );

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

    <script>
        const input = document.getElementById('searchAnggota');
        const dropdown = document.getElementById('dropdownAnggota');
        const hiddenInput = document.getElementById('nomor_identitas');

        const items = document.querySelectorAll('.anggota-item');

        // buka dropdown saat fokus
        input.addEventListener('focus', () => {
            dropdown.classList.remove('hidden');
        });

        // filter
        input.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            dropdown.classList.remove('hidden');
            items.forEach(item => {
                if (item.dataset.search.includes(keyword)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });

        // pilih data
        items.forEach(item => {
            item.addEventListener('click', function() {
                const nama = this.querySelector('.font-medium').textContent.trim();
                const nim = this.dataset.id;

                input.value = `${nama} (${nim})`;
                hiddenInput.value = nim;

                dropdown.classList.add('hidden');
            });
        });

        // klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
