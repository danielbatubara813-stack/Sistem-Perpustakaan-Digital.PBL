@extends('layout.app-admin')

@section('title', 'Kelola Dok Bahasa')
@php
    $title = 'Daftar Dokumen Bahasa';
    $description = 'Kelola Dokumen Bahasa untuk bahasa yang digunakan buku';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        @if (Route::is('admin.data-terkendali.dok-bahasa.create'))
            @php
                $route = route('admin.data-terkendali.dok-bahasa.store');
                $method = 'POST';
            @endphp
        @else
            @php
                $route = route('admin.data-terkendali.dok-bahasa.update', $bahasa->kode_bahasa);
                $method = 'PUT';
            @endphp
        @endif
        <h2 class="font-bold text-lg my-4">From Dokumen Bahasa</h2>
        <form action="{{ $route }}" method="POST" class="space-y-4">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @else
                @method('POST')
            @endif
            @if (Route::is('admin.data-terkendali.dok-bahasa.edit'))
                <input name="kode_bahasa" value="{{ $bahasa->kode_bahasa }}" type="hidden" />
            @else
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start ">
                    <label class="sm:col-span-3 text-sm text-slate-700">Kode Bahasa*</label>
                    <div class="sm:col-span-9">
                        <input name="kode_bahasa"
                            value="{{ Route::is('admin.data-terkendali.dok-bahasa.edit') ? old('kode_bahasa', $bahasa->kode_bahasa) : old('kode_bahasa') }}"
                            type="text" placeholder="Contoh: ID"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('kode_bahasa')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            Kode bahasa akan otomatis diubah menjadi huruf kapital.
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Nama Bahasa*</label>
                <div class="sm:col-span-9">
                    <input name="nama_bahasa"
                        value="{{ Route::is('admin.data-terkendali.dok-bahasa.edit') ? old('nama_bahasa', $bahasa->nama_bahasa) : old('nama_bahasa') }}"
                        type="text" placeholder="Contoh: Bahasa Indonesia"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('nama_bahasa')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Simpan</button>
                <a href="{{ route('admin.data-terkendali.dok-bahasa.index') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
            </div>
        </form>
    </div>

@endsection
