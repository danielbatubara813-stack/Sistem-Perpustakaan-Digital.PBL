@extends('layout.app-admin')

@section('title', 'Kelola Tipe Koleksi')
@php
    $title = 'Daftar Tipe Koleksi';
    $description = 'Kelola Tipe Koleksi untuk tipe buku perpustakaan';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        @if (Route::is('admin.data-terkendali.tipe-koleksi.create'))
            @php
                $route = route('admin.data-terkendali.tipe-koleksi.store');
                $method = 'POST';
            @endphp
        @else
            @php
                $route = route('admin.data-terkendali.tipe-koleksi.update', $tipe_koleksi->id);
                $method = 'PUT';
            @endphp
        @endif
        <h2 class="font-bold text-lg my-4">From Tipe Koleksi</h2>
        <form action="{{ $route }}" method="POST">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @else
                @method('POST')
            @endif
            @if (Route::is('admin.data-terkendali.tipe-koleksi.edit'))
                <input name="id_tipe" value="{{ $tipe_koleksi->id_tipe }}" type="hidden" />
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Nama Tipe Koleksi*</label>
                <div class="sm:col-span-9">
                    <input name="nama_tipe"
                        value="{{ Route::is('admin.data-terkendali.tipe-koleksi.edit') ? old('nama_tipe', $tipe_koleksi->nama_tipe) : old('nama_tipe') }}"
                        type="text" placeholder="Contoh: Fiksi"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('nama_tipe')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Simpan</button>
                <a href="{{ route('admin.data-terkendali.tipe-koleksi.index') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
            </div>
        </form>
    </div>

@endsection
