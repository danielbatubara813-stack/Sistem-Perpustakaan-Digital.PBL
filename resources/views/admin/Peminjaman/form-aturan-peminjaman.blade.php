@extends('layout.app-admin')

@section('title', 'Aturan Peminjaman')
@php
    $title = 'Aturan Peminjaman';
    $description = 'Kelola aturan peminjaman berdasarkan tipe keanggotaan dan koleksi';
    $isEdit = isset($rule) && $rule->exists;
    $formAction = $isEdit
        ? route('admin.peminjaman.aturan.update', $rule->id_aturan)
        : route('admin.peminjaman.aturan.store');
@endphp

@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        <h2 class="font-bold text-lg my-4">
            {{ $isEdit ? 'Edit Aturan Peminjaman' : 'Form Aturan Peminjaman' }}
        </h2>

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Tipe Keanggotaan</label>
                <div class="sm:col-span-9">
                    <select name="id_jenis"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua Jenis Anggota</option>
                        @foreach(($jenisKeanggotaan ?? collect()) as $jenis)
                            <option value="{{ $jenis->id_jenis }}"
                                {{ old('id_jenis', $rule->id_jenis ?? '') == $jenis->id_jenis ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_jenis')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Tipe Koleksi</label>
                <div class="sm:col-span-9">
                    <select name="id_tipe"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua Tipe Koleksi</option>
                        @foreach(($tipeKoleksi ?? collect()) as $tipe)
                            <option value="{{ $tipe->id_tipe }}"
                                {{ old('id_tipe', $rule->id_tipe ?? '') == $tipe->id_tipe ? 'selected' : '' }}>
                                {{ $tipe->nama_tipe }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_tipe')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Maksimal Peminjaman*</label>
                <div class="sm:col-span-9">
                    <input type="number" name="batas_peminjaman"
                        value="{{ old('batas_peminjaman', $rule->batas_peminjaman ?? '') }}"
                        min="0" max="255" placeholder="Contoh: 0 buku"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('batas_peminjaman')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Periode Peminjaman (Hari)*</label>
                <div class="sm:col-span-9">
                    <input type="number" name="periode_peminjaman"
                        value="{{ old('periode_peminjaman', $rule->periode_peminjaman ?? '') }}"
                        min="1" max="255" placeholder="Contoh: 7 hari"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('periode_peminjaman')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">
                    {{ $isEdit ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.peminjaman.aturan') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
