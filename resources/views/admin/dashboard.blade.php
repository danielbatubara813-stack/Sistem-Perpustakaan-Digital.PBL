{{-- isi content dari halaman dashboard --}}
@extends('layout.app-admin')

@section('title', 'Dashboard')
@php
    $title = 'Dashboard';
    $description = 'Monitoring untuk menampilkan ringkasan data, aktivitas, dan informasi penting secara cepat';
@endphp
@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-start justify-between">
                <div class=" space-y-4">
                    <h4 class="text-sm font-semibold">Jumlah Buku</h4>
                    <h1 class="font-bold text-5xl">{{ $totalBuku }}</h1>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-book-text-icon lucide-book-text">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                    <path d="M8 11h8" />
                    <path d="M8 7h6" />
                </svg>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-start justify-between">
                <div class=" space-y-4">
                    <h4 class="text-sm font-semibold">Jumlah Buku Dipinjam</h4>
                    <h1 class="font-bold text-5xl">{{ $totalBukuDipinjam }}</h1>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-book-text-icon lucide-book-text">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                    <path d="M8 11h8" />
                    <path d="M8 7h6" />
                </svg>
            </div>
            <div class="col-span-1 md:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <h4 class="text-sm font-bold">
                    Buku Terbaru
                    <span class="text-gray-500 font-normal">
                        ({{ $bukuTerbaru->count() }})
                    </span>
                </h4>

                <div class="flex mt-4 gap-3 overflow-x-auto scrollbar-hide py-2">
                    @forelse ($bukuTerbaru as $buku)
                        <div class="shrink-0 relative group overflow-hidden rounded-md">
                            <img class="w-28 h-40 object-cover shadow transition-all duration-300 group-hover:brightness-50"
                                src="{{ $buku->cover_buku && Storage::disk('public')->exists('covers/' . $buku->cover_buku)
                                    ? asset('storage/covers/' . $buku->cover_buku)
                                    : asset('static/bookcover.png') }}"
                                alt="{{ $buku->judul_buku }}">

                            <div
                                class="absolute inset-x-0 bottom-0 p-2 bg-linear-to-t from-black/80 to-transparent
               translate-y-full group-hover:translate-y-0
               transition-transform duration-300">
                                <p class="text-white text-xs font-medium line-clamp-2">
                                    {{ $buku->judul_buku }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">
                            Tidak ada buku yang sedang dipinjam.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold">Anggota</h4>
                    <div>
                        <h1 class="font-bold text-5xl">{{ $totalAnggota }}</h1>
                    </div>
                </div>
                <div class="h-80">
                    <canvas class="mt-6" id="anggotaChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 ">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold">Peminjaman</h4>
                    <div>
                        <h1 class="font-bold text-5xl">{{ $totalPeminjaman }}</h1>
                    </div>
                </div>
                <div class="h-80">
                    <canvas class="mt-6" id="peminjamanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg-lg">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-lg uppercase">Data Peminjaman Terbaru</h2>
            <button onclick="window.location.reload()"
                class="bg-gray-300 text-gray-500 hover:bg-blue-600 rounded-full hover:text-white p-2 transition-all duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-refresh-ccw-icon lucide-refresh-ccw">
                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                    <path d="M16 16h5v5" />
                </svg>
            </button>
        </div>
        <div class="overflow-x-auto mt-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-200 text-slate-600 uppercase text-xs">
                            <th class="px-6 py-4 text-left">Anggota</th>
                            <th class="px-6 py-4 text-left">Nomor Anggota</th>
                            <th class="px-6 py-4 text-left">Jenis Keanggotaan</th>
                            <th class="px-6 py-4 text-center">Jumlah Buku</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($peminjamanTerbaru as $peminjaman)
                            @php
                                $anggota = $peminjaman->anggota;
                                $status = $peminjaman->status;

                                $statusClass = match ($status) {
                                    'Dikembalikan' => 'bg-green-50 text-green-600',
                                    'Dipinjam' => 'bg-blue-50 text-blue-600',
                                    'Terlambat' => 'bg-yellow-50 text-yellow-600',
                                    'Hilang' => 'bg-red-50 text-red-600',
                                    default => 'bg-gray-50 text-gray-600',
                                };

                                $iconClass = match ($status) {
                                    'Dikembalikan' => 'bg-green-600',
                                    'Dipinjam' => 'bg-blue-600',
                                    'Terlambat' => 'bg-yellow-600',
                                    'Hilang' => 'bg-red-600',
                                    default => 'bg-gray-600',
                                };
                            @endphp

                            <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $anggota->profile ? $anggota->profile : asset('static/profileDefault.jpg') }}"
                                            class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-100"
                                            alt="{{ $anggota->nama }}">

                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $anggota->nama }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="font-bold">{{ $anggota->nomor_identitas }}</span><br>
                                    <span class="text-sm">{{ $anggota->email }} </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-medium">
                                        {{ $anggota->jenisKeanggotaan->nama_jenis ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center font-semibold text-slate-700">
                                    1
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2 py-2 rounded-full flex items-center gap-2 w-max {{ $statusClass }}">
                                        <span
                                            class="w-6 h-6 rounded-full flex items-center justify-center text-white {{ $iconClass }}">
                                            @if ($status === 'Hilang')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-x-icon lucide-x">
                                                    <path d="M18 6 6 18" />
                                                    <path d="m6 6 12 12" />
                                                </svg>
                                            @elseif ($status === 'Terlambat')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-info-icon lucide-info">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="M12 16v-4" />
                                                    <path d="M12 8h.01" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-check-icon lucide-check">
                                                    <path d="M20 6 9 17l-5-5" />
                                                </svg>
                                            @endif
                                        </span>

                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-slate-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
