@extends('layout.app-admin')

@section('title', 'Peminjaman')

@php
    $title = $title ?? 'Peminjaman';
    $description = $description ?? 'Kelola daftar peminjaman buku dan catat peminjaman baru.';
    $nomorIdentitas = old('nomor_identitas', request('nomor_identitas'));
    $kodeItem = old('id_item', request('id_item'));
    $maksimalPeminjamanTercapai = (bool) ($loanPreview['maksimal_tercapai'] ?? false);
    $peminjamanDitutup = (bool) ($loanPreview['peminjaman_ditutup'] ?? false);
    $canStore =
        $anggota &&
        $itemBuku &&
        $itemBuku->status_item === 'Tersedia' &&
        !$peminjamanDitutup &&
        !$maksimalPeminjamanTercapai;

    $formatTanggal = function ($tanggal) {
        return $tanggal ? \Carbon\Carbon::parse($tanggal)->format('d-m-Y') : '-';
    };

    $penulisBuku = function ($buku) {
        if (!$buku || !$buku->penulis || !$buku->penulis->count()) {
            return '-';
        }

        return $buku->penulis->pluck('nama_penulis')->implode(', ');
    };

    $coverBuku = function ($buku) {
        $placeholder = 'https://placehold.co/80x120?text=Cover';

        if (!$buku || !$buku->cover_buku) {
            return $placeholder;
        }

        $value = $buku->cover_buku;

        if (preg_match('/^https?:\/\//i', $value)) {
            return $value;
        }

        try {
            $disk = \Illuminate\Support\Facades\Storage::disk('public');
            $path = 'covers/' . $value;

            if ($disk->exists($path)) {
                if (file_exists(public_path('storage/' . $path))) {
                    return asset('storage/' . $path);
                }

                $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                $mime = match ($extension) {
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    default => 'image/jpeg',
                };

                return 'data:' . $mime . ';base64,' . base64_encode($disk->get($path));
            }

            if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', $value) || strlen($value) > 255) {
                return 'data:image/jpeg;base64,' . base64_encode($value);
            }
        } catch (\Throwable $th) {
            return $placeholder;
        }

        return $placeholder;
    };
@endphp

@section('content')
    <div class="bg-white p-4 sm:p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4">
            @include('components.submenu-admin')
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
            <h3 class="font-bold text-lg">
                CATAT PEMINJAMAN
            </h3>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 w-full lg:w-auto">
                <button type="submit" form="store-peminjaman-form" @disabled(!$canStore)
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-md px-4 py-2 text-sm shadow-sm transition
                    {{ $canStore ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-slate-300 text-slate-500 cursor-not-allowed' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                    Simpan Peminjaman
                </button>

                <a href="{{ route('admin.peminjaman') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        <form id="lookup-peminjaman-form" action="{{ route('admin.peminjaman.catat-peminjaman') }}" method="GET">
            <div class="mb-4">
                <label class="block text-sm text-slate-600 mb-2">
                    ID Anggota
                </label>

                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="nomor_identitas" value="{{ $nomorIdentitas }}"
                        placeholder="Contoh: 3312501012"
                        class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <button type="submit"
                        class="w-full sm:w-auto px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                        Cari
                    </button>
                </div>

                @error('nomor_identitas')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

                @if ($anggotaNotFound)
                    <div class="mt-3 p-4 bg-yellow-100 rounded">
                        ID anggota tidak ditemukan.
                    </div>
                @endif
            </div>
        </form>

        <form id="store-peminjaman-form" action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf
            <input type="hidden" name="nomor_identitas" value="{{ $nomorIdentitas }}">
            <input type="hidden" name="id_item" value="{{ $kodeItem }}">
        </form>

        @if ($anggota)
            <div class="mb-6 border border-slate-200 rounded-md p-4 shadow-sm bg-slate-50">
                <div class="flex flex-col lg:flex-row gap-6 lg:items-center">
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

                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <div class="text-xs text-slate-500">Nama Anggota</div>
                            <div class="font-bold break-words">{{ $anggota->nama }}</div>

                            <div class="text-xs text-slate-500 mt-2">ID Anggota</div>
                            <div class="font-bold break-words">{{ $anggota->nomor_identitas }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-500">Jenis Anggota</div>
                            <div class="font-bold break-words">{{ $anggota->jenisKeanggotaan?->nama_jenis ?? '-' }}</div>

                            <div class="text-xs text-slate-500 mt-2">Alamat Email</div>
                            <div class="font-bold break-words">{{ $anggota->email }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-500">No Handphone</div>
                            <div class="font-bold break-words">{{ $anggota->no_hp }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($memberLoans->count())
                <div class="overflow-x-auto mt-6 mb-6">
                    <table class="min-w-237.5 w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                            <tr>
                                <th class="px-4 sm:px-6 py-3">Judul</th>
                                <th class="px-4 sm:px-6 py-3">Kode Item</th>
                                <th class="px-4 sm:px-6 py-3">Tanggal Pinjam</th>
                                <th class="px-4 sm:px-6 py-3">Jatuh Tempo</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($memberLoans as $loan)
                                <tr class="odd:bg-white even:bg-slate-100">
                                    <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">
                                        <div class="flex items-center gap-4 min-w-70">
                                            <img src="{{ $coverBuku($loan->itemBuku?->buku) }}"
                                                class="w-12 h-16 object-cover rounded shadow-sm" alt="">

                                            <div>
                                                <h4 class="max-w-xs line-clamp-2 leading-5 font-bold">
                                                    {{ $loan->itemBuku?->buku?->judul_buku ?? '-' }}
                                                </h4>
                                                <p>{{ $penulisBuku($loan->itemBuku?->buku) }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        {{ $loan->id_item }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        {{ $formatTanggal($loan->tanggal_peminjaman) }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        {{ $formatTanggal($loan->tanggal_jatuh_tempo) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mb-6 p-4 bg-yellow-100 rounded">
                    Tidak ada data peminjaman ditemukan.
                </div>
            @endif
        @endif

        <div class="mb-4">
            <label class="block text-sm text-slate-600 mb-2">
                Kode Item Buku (Harus Tersedia)
            </label>

            <input type="text" name="id_item" form="lookup-peminjaman-form" value="{{ $kodeItem }}"
                placeholder="Contoh: E0040150C90DB6E8"
                class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

            @error('id_item')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror

            @if ($itemNotFound)
                <div class="mt-3 p-4 bg-yellow-100 rounded">
                    Kode item buku tidak ditemukan.
                </div>
            @endif
        </div>

        @if ($itemBuku)
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
                        <tr class="odd:bg-white even:bg-slate-100">
                            <td class="px-4 sm:px-6 py-4 align-top">
                                <span
                                    class="px-3 py-1 rounded-md whitespace-nowrap inline-flex
                                    {{ $itemBuku->status_item === 'Tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $itemBuku->status_item === 'Tersedia' ? 'Dipilih' : $itemBuku->status_item }}
                                </span>
                            </td>

                            <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">
                                <div class="flex items-center gap-4 min-w-70">
                                    <img src="{{ $coverBuku($itemBuku->buku) }}"
                                        class="w-12 h-16 object-cover rounded shadow-sm" alt="">

                                    <div>
                                        <h4 class="max-w-xs line-clamp-2 leading-5 font-bold">
                                            {{ $itemBuku->buku?->judul_buku ?? '-' }}
                                        </h4>
                                        <p>{{ $penulisBuku($itemBuku->buku) }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ $itemBuku->buku?->tipe?->nama_tipe ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $itemBuku->id_item }}
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $formatTanggal($loanPreview['tanggal_peminjaman'] ?? null) }}
                            </td>

                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                {{ $formatTanggal($loanPreview['tanggal_jatuh_tempo'] ?? null) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($itemBuku->status_item !== 'Tersedia')
                <div class="mt-4 p-4 bg-yellow-100 rounded">
                    Item buku tidak bisa dipinjam karena statusnya {{ $itemBuku->status_item }}.
                </div>
            @elseif (!$anggota)
                <div class="mt-4 p-4 bg-yellow-100 rounded">
                    Pilih anggota terlebih dahulu sebelum menyimpan peminjaman.
                </div>
            @elseif ($peminjamanDitutup)
                <div class="mt-4 p-4 bg-yellow-100 rounded">
                    Buku dengan tipe koleksi ini tidak boleh dipinjam berdasarkan aturan peminjaman.
                </div>
            @elseif ($maksimalPeminjamanTercapai)
                <div class="mt-4 p-4 bg-yellow-100 rounded">
                    Anggota sudah mencapai maksimal peminjaman untuk aturan ini
                    ({{ $loanPreview['jumlah_peminjaman_aktif'] ?? 0 }}/{{ $loanPreview['batas_peminjaman'] ?? 0 }} buku).
                </div>
            @endif
        @endif
    </div>
@endsection
