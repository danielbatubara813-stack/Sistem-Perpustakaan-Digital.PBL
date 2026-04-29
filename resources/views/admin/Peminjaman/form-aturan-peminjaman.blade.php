@extends('layout.app-admin')

@section('title', 'Aturan Peminjaman')
@php
    $title = 'Aturan Peminjaman';
    $description = 'Kelola aturan peminjaman berdasarkan tipe keanggotaan dan koleksi';
@endphp

@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        <h2 class="font-bold text-lg my-4">Form Aturan Peminjaman</h2>

        <form action="#" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">

                <!-- Tipe Keanggotaan -->
                <label class="sm:col-span-3 text-sm text-slate-700">Tipe Keanggotaan*</label>
                <div class="sm:col-span-9">
                    <select name="tipe_keanggotaan"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Pilih Tipe Keanggotaan --</option>
                        <option>Mahasiswa</option>
                        <option>Dosen Tetap</option>
                        <option>Dosen Magang</option>
                        <option>Staff</option>
                    </select>
                </div>

                <!-- Tipe Koleksi -->
                <label class="sm:col-span-3 text-sm text-slate-700">Tipe Koleksi*</label>
                <div class="sm:col-span-9">
                    <select name="tipe_koleksi"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Pilih Tipe Koleksi --</option>
                        <option>Fiksi</option>
                        <option>Referensi</option>
                        <option>Non-Fiksi</option>
                        <option>Majalah</option>
                    </select>
                </div>

                <!-- Maksimal Peminjaman -->
                <label class="sm:col-span-3 text-sm text-slate-700">Maksimal Peminjaman*</label>
                <div class="sm:col-span-9">
                    <input type="number" name="maks_peminjaman" placeholder="Contoh: 3 buku"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <!-- Periode Peminjaman -->
                <label class="sm:col-span-3 text-sm text-slate-700">Periode Peminjaman (Hari)*</label>
                <div class="sm:col-span-9">
                    <input type="number" name="periode_peminjaman" placeholder="Contoh: 7 hari"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <!-- Masa Toleransi -->
                <label class="sm:col-span-3 text-sm text-slate-700">Masa Toleransi (Hari)*</label>
                <div class="sm:col-span-9">
                    <input type="number" name="masa_toleransi" placeholder="Contoh: 2 hari"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    <p class="text-xs text-slate-500 mt-1">
                        Waktu toleransi keterlambatan sebelum dikenakan denda.
                    </p>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">
                    Simpan
                </button>
                <a href="{{ route('admin.peminjaman.aturan') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
