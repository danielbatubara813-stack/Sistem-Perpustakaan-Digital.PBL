@extends('layout.app-admin')

@section('title', 'Kelola Tipe Koleksi')
@php
    $title = 'Daftar Tipe Koleksi';
    $description = 'Kelola Tipe Koleksi untuk tipe buku perpustakaan';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                <a id="daftarTab" href="{{ route('admin.data-terkendali.tipe-koleksi.index') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.tipe-koleksi*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Tipe
                    Koleksi <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span></a>
                <a href="{{ route('admin.data-terkendali.subjek.index') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.subjek*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Subjek</a>
                <a href="{{ route('admin.data-terkendali.dok-bahasa.index') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.dok-bahasa*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Dok
                    Bahasa</a>
            </div>
            <div>
                <a href="{{ route('admin.anggota.jenis.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-3 py-2 text-sm shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Tambah Tipe Koleksi
                </a>
            </div>
        </div>

        @if (Route::is('admin.data-terkendali.tipe-koleksi.create'))
            @php
                $route = route('admin.data-terkendali.tipe-koleksi.store');
                $method = 'POST';
            @endphp
        @else
            @php
                $route = route('admin.data-terkendali.tipe-koleksi.update', $tipe->id);
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
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Nama Tipe Koleksi*</label>
                <div class="sm:col-span-9">
                    <input name="nama_tipe_koleksi" value="{{ old('nama_tipe_koleksi') }}" type="text"
                        placeholder="Contoh: Mahasiswa"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('nama_tipe_koleksi')
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
