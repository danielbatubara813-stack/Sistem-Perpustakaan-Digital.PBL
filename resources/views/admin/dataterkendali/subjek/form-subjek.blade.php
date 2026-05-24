@extends('layout.app-admin')

@section('title', 'Kelola Subjek')
@php
    $title = 'Daftar Subjek';
    $description = 'Kelola Subjek untuk subjek buku perpustakaan';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            @include('components.submenu-admin')
        </div>

        @if (Route::is('admin.data-terkendali.subjek.create'))
            @php
                $route = route('admin.data-terkendali.subjek.store');
                $method = 'POST';
            @endphp
        @else
            @php
                $route = route('admin.data-terkendali.subjek.update');
                $method = 'PUT';
            @endphp
        @endif
        <h2 class="font-bold text-lg my-4">From Subjek</h2>
        <form action="{{ $route }}" method="POST" class="space-y-4">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @else
                @method('POST')
            @endif
            @if (Route::is('admin.data-terkendali.subjek.edit'))
                <input name="id_subjek" value="{{ $subjek->id_subjek }}" type="hidden" />
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Nama Subjek*</label>
                <div class="sm:col-span-9">
                    <input name="nama_subjek"
                        value="{{ Route::is('admin.data-terkendali.subjek.edit') ? old('nama_subjek', $subjek->nama_subjek) : old('nama_subjek') }}"
                        type="text" placeholder="Contoh: Teknologi"
                        class="w-full max-w-96 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('nama_subjek')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Simpan</button>
                <a href="{{ route('admin.data-terkendali.subjek.index') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
            </div>
        </form>
    </div>

@endsection
