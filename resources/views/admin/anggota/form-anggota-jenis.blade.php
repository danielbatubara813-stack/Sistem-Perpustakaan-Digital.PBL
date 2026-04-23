@extends('layout.app-admin')

@section('title', 'Form Jenis Keanggotaan')
@php
    $title = 'Tambah Jenis Keanggotaan';
    $description = 'Form untuk menambahkan data jenis keanggotaan baru';
@endphp
@section('content')


    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                <a id="daftarTab" href="{{ route('admin.anggota.daftar') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.create') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Daftar
                    Anggota <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span></a>
                <a href="{{ route('admin.anggota.jenis') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.jenis.create') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Jenis
                    Keanggotaan</a>
            </div>
        </div>

        <form action="{{ route('admin.anggota.jenis.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Jenis Keanggotaan*</label>
                <div class="sm:col-span-9">
                    <input name="name" value="{{ old('name') }}" type="text" placeholder="Contoh: Mahasiswa"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Simpan</button>
                <a href="{{ route('admin.anggota.jenis') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
            </div>
        </form>
    </div>
@endsection
