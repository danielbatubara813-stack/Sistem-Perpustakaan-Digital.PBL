@extends('layout.app-admin')

@section('title', 'Form Jenis Keanggotaan')

@php
    $title = 'Daftar Jenis Keanggotaan';
    $description = 'Kelola jenis keanggotaan untuk pembatasan akses';
@endphp

@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                <a href="{{ route('admin.anggota.daftar') }}"
                    class="px-4 py-2 text-sm text-slate-600">
                    Daftar Anggota
                </a>

                <a href="{{ route('admin.anggota.jenis') }}"
                    class="px-4 py-2 text-sm bg-blue-600 text-white shadow rounded">
                    Jenis Keanggotaan
                </a>
            </div>
        </div>

        @if (Route::is('admin.anggota.jenis.create'))
            @php
                $route = route('admin.anggota.jenis.store');
                $method = 'POST';
            @endphp
        @else
            @php
                $route = route('admin.anggota.jenis.update', $type->id_jenis);
                $method = 'PUT';
            @endphp
        @endif

        <h2 class="font-bold text-lg my-4">Form Jenis Keanggotaan</h2>

        <form action="{{ $route }}" method="POST" class="space-y-4">
            @csrf

            @if ($method == 'PUT')
                @method('PUT')
            @else
                @method('POST')
            @endif

            @if (Route::is('admin.anggota.jenis.edit'))
                <input
                    name="id_jenis"
                    value="{{ $type->id_jenis }}"
                    type="hidden" />
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">
                    Jenis Keanggotaan*
                </label>

                <div class="sm:col-span-9">
                    <input
                        name="name"
                        value="{{ Route::is('admin.anggota.jenis.edit')
                            ? old('name', $type->nama_jenis)
                            : old('name') }}"
                        type="text"
                        placeholder="Contoh: Mahasiswa"
                        class="w-full max-w-96 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    @error('name')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">
                    Simpan
                </button>

                <a href="{{ route('admin.anggota.jenis') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
