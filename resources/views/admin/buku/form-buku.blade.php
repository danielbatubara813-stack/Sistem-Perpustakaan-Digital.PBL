@extends('layout.app-admin')

@section('title', 'Form Buku')
@php
    $title = 'Daftar Buku';
    $description = 'Kelola koleksi buku dan lihat informasi ringkas setiap judul.';
@endphp
@section('content')
    <div class="bg-white p-4 sm:p-6 rounded-xl shadow mt-4">

        <h2 class="text-lg font-semibold mb-6">DAFTAR BUKU</h2>

        <form method="POST" action="{{ (isset($book) && $book->exists) ? route('admin.buku.update', $book->id_buku) : route('admin.buku.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($book) && $book->exists)
                @method('PUT')
            @endif

            <div class="space-y-5">

                {{-- Tipe Koleksi --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Tipe Koleksi*</label>

                    <select name="id_tipe" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                        <option value="">Pilih Tipe Koleksi</option>
                        @if(isset($tipe))
                            @foreach($tipe as $t)
                                <option value="{{ $t->id_tipe }}" {{ old('id_tipe', $book->id_tipe ?? '') == $t->id_tipe ? 'selected' : '' }}>{{ $t->nama_tipe }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- Judul --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Judul*</label>

                    <input name="judul_buku" value="{{ old('judul_buku', $book->judul_buku ?? '') }}" type="text" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                    @error('judul_buku')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Penulis*</label>

                    <div class="md:col-span-9 space-y-2">
                        {{-- TOMBOL BUKA MODAL --}}
                        <button type="button" data-modal-target="modal-penulis" data-modal-toggle="modal-penulis"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all duration-300">
                            Tambah Data Penulis
                        </button>

                        {{-- MODAL --}}
                        <div id="modal-penulis" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

                            <div class="relative p-4 w-full max-w-2xl max-h-full">

                                    {{-- ISI MODAL --}}
                                <div class="relative bg-white rounded-lg shadow-sm">

                                    {{-- HEADER --}}
                                    <div class="flex items-center justify-between p-4 border-b rounded-t">

                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Tambah Data Penulis
                                        </h3>

                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                            data-modal-hide="modal-penulis">

                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 12 12M13 1 1 13" />
                                            </svg>

                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    {{-- ISI --}}
                                    <div class="p-4 md:p-5 space-y-6">

                                        {{-- NAMA PENULIS (pilih dari data terkendali) --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">

                                            <label class="sm:col-span-3 text-sm text-slate-700">
                                                Nama Penulis*
                                            </label>

                                            <div class="sm:col-span-9">

                                                    <select id="penulis_select" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                                                    <option value="">Pilih Nama Penulis</option>
                                                    @if(isset($penulis) && $penulis->count())
                                                        @foreach($penulis as $p)
                                                            <option value="{{ $p->id_penulis }}" data-tipe="{{ $p->tipe_penulis }}">{{ $p->nama_penulis }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                @error('id_penulis')
                                                    <p class="text-sm text-red-600 mt-1">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>

                                            <div class="text-center text-sm text-gray-400">atau</div>

                                            {{-- NAMA PENULIS MANUAL --}}
                                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                                                <label class="sm:col-span-3 text-sm text-slate-700">Ketikan Nama Baru</label>
                                                <div class="sm:col-span-9">
                                                    <input id="manual_nama_penulis" name="manual_nama_penulis" type="text" placeholder="Contoh: Tere Liye" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                                                </div>
                                            </div>

                                            {{-- TIPE PENULIS (untuk nama baru) --}}
                                            <div id="tipe_manual_group" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                                                <label class="sm:col-span-3 text-sm text-slate-700">Tipe Penulis (untuk nama baru)</label>
                                                <div class="sm:col-span-9">
                                                    <select id="manual_tipe_penulis" name="manual_tipe_penulis" class="w-full sm:max-w-48 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                                                        @if(isset($tipe_penulis) && count($tipe_penulis))
                                                            @foreach($tipe_penulis as $tp)
                                                                <option value="{{ $tp }}">{{ $tp }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="Nama Orang">Nama Orang</option>
                                                            <option value="Badan Organisasi">Badan Organisasi</option>
                                                            <option value="Konferensi">Konferensi</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                        {{-- TIPE PENULIS (otomatis, ditampilkan saat memilih penulis yang ada) --}}
                                        <div id="tipe_auto_group" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start hidden">

                                            <label class="sm:col-span-3 text-sm text-slate-700">
                                                Tipe Penulis (otomatis)
                                            </label>

                                            <div class="sm:col-span-9">

                                                <select id="tipe_penulis_select" class="w-full sm:max-w-48 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" disabled>
                                                    @if(isset($tipe_penulis) && count($tipe_penulis))
                                                        @foreach($tipe_penulis as $tp)
                                                            <option value="{{ $tp }}">{{ $tp }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="Nama Orang">Nama Orang</option>
                                                        <option value="Badan Organisasi">Badan Organisasi</option>
                                                        <option value="Konferensi">Konferensi</option>
                                                    @endif
                                                </select>

                                                @error('tipe_penulis')
                                                    <p class="text-sm text-red-600 mt-1">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FOOTER --}}
                                    <div class="flex items-center justify-end gap-2 p-4 border-t border-gray-200 rounded-b">

                                        <button data-modal-hide="modal-penulis" type="button"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                                            Batal
                                        </button>

                                        <button type="button" id="addPenulisBtn"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Penulis yang dipilih akan muncul di sini; input tersembunyi membawa nilai id_penulis[] --}}
                        <div id="selected-authors" class="w-full border border-gray-200 rounded px-3 py-2 min-h-[46px]">
                            {{-- isi awal penulis terpilih saat mengedit atau setelah kesalahan validasi --}}
                            @if(old('id_penulis'))
                                @foreach(old('id_penulis') as $pid)
                                    @php
                                        $pobj = \App\Models\Penulis::find($pid);
                                    @endphp
                                    @if($pobj)
                                        <div class="author-chip flex items-center justify-between gap-2 my-1" data-id="{{ $pobj->id_penulis }}">
                                            <input type="hidden" name="id_penulis[]" value="{{ $pobj->id_penulis }}">
                                            <span class="text-sm">{{ $pobj->nama_penulis }} <small class="text-xs text-gray-500">({{ $pobj->tipe_penulis }})</small></span>
                                            <button type="button" class="text-red-600 ml-2 remove-author">Hapus</button>
                                        </div>
                                    @endif
                                @endforeach
                            @elseif(isset($book) && $book->penulis && $book->penulis->count())
                                @foreach($book->penulis as $p)
                                    <div class="author-chip flex items-center justify-between gap-2 my-1" data-id="{{ $p->id_penulis }}">
                                        <input type="hidden" name="id_penulis[]" value="{{ $p->id_penulis }}">
                                        <span class="text-sm">{{ $p->nama_penulis }} <small class="text-xs text-gray-500">({{ $p->tipe_penulis }})</small></span>
                                        <button type="button" class="text-red-600 ml-2 remove-author">Hapus</button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500">Belum ada penulis dipilih.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- No Rak --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">No.Rak*</label>

                    <input name="no_rak" type="text" id="no_rak" maxlength="10" value="{{ old('no_rak', $book->no_rak ?? '') }}"
                        class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- No Panggil --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">No.Panggil*</label>

                    <div class="md:col-span-9 flex w-full">
                        <input max="7" type="text" id="no_panggil_1" name="no_panggil_prefix" readonly value="{{ old('no_panggil_prefix', isset($book) ? substr($book->no_rak ?? '', 0, 7) : '') }}"
                            class="w-24 border border-gray-400 rounded-l px-3 py-2 bg-gray-200">

                        <input name="no_panggil" type="text" class="flex-1 border border-gray-400 rounded-r px-3 py-2 min-w-0" value="{{ old('no_panggil', $book->no_panggil ?? '') }}">
                    </div>
                </div>

                {{-- Penerbit --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Penerbit*</label>

                    <div class="md:col-span-9">
                        @if(isset($penerbit) && $penerbit->count())
                            <select name="id_penerbit" class="w-full border border-gray-400 rounded px-3 py-2">
                                <option value="">Pilih Penerbit</option>
                                @foreach($penerbit as $p)
                                    <option value="{{ $p->id_penerbit }}" {{ old('id_penerbit', $book->id_penerbit ?? '') == $p->id_penerbit ? 'selected' : '' }}>{{ $p->nama_penerbit }}</option>
                                @endforeach
                            </select>
                        @else
                            <input name="id_penerbit" type="text" class="w-full border border-gray-400 rounded px-3 py-2" value="{{ old('id_penerbit', $book->id_penerbit ?? '') }}">
                        @endif
                    </div>
                </div>

                {{-- KODE UNIK --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Kode Unik*</label>

                    <div class="md:col-span-9">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">

                            {{-- Kode 1 --}}
                            <input type="text" id="kode_1" name="kode_1" maxlength="4" value="{{ old('kode_1', $kode1Item ?? '') }}"
                                class="border border-gray-400 rounded px-3 py-2 uppercase">

                            {{-- Kode 2 --}}
                            <input type="text" id="kode_2" name="kode_2" maxlength="4" value="{{ old('kode_2', $kode2Item ?? '') }}"
                                class="border border-gray-400 rounded px-3 py-2 uppercase">

                            {{-- Jumlah Buku --}}
                            <input type="number" id="jumlah_buku" name="jumlah_buku" min="1" value="{{ old('jumlah_buku', (isset($book) && $book->exists) ? $book->items->count() : 1) }}"
                                class="border border-gray-400 rounded px-3 py-2">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center mt-2">

                            {{-- tombol regenerate --}}
                            <button type="button" id="regenBtn"
                                class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition w-full sm:w-max">
                                Regenerate Kode 1 & 2
                            </button>

                            <p class="text-xs text-gray-500">
                                Kode item dibuat berurutan: Kode 1-Kode 2-0001, 0002, dan seterusnya.
                            </p>

                        </div>
                    </div>
                </div>

                {{-- Bahasa --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Bahasa*</label>

                    <select name="kode_bahasa" class="md:col-span-3 w-full border border-gray-400 rounded px-3 py-2">
                        @if(isset($bahasa) && $bahasa->count())
                            @foreach($bahasa as $b)
                                <option value="{{ $b->kode_bahasa }}" {{ old('kode_bahasa', $book->kode_bahasa ?? '') == $b->kode_bahasa ? 'selected' : '' }}>{{ $b->nama_bahasa }}</option>
                            @endforeach
                        @else
                            <option value="">Default</option>
                            <option value="id">Indonesia</option>
                            <option value="en">English</option>
                        @endif
                    </select>
                </div>

                {{-- ISBN --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">ISBN/ISSN*</label>

                    <input name="isbn" type="text" value="{{ old('isbn', $book->isbn ?? '') }}" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                    @error('isbn')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Edisi --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Edisi</label>

                    <input name="edisi" type="text" value="{{ old('edisi', $book->edisi ?? '') }}" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Tanggal Terbit --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Tanggal Terbit</label>

                    <input name="tanggal_terbit" type="date" value="{{ old('tanggal_terbit', isset($book->tanggal_terbit) ?
                        \Carbon\Carbon::parse($book->tanggal_terbit)->format('Y-m-d') : '') }}" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Deskripsi --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Deskripsi</label>

                    <textarea name="deskripsi" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">{{ old('deskripsi', $book->deskripsi ?? '') }}</textarea>
                </div>

                {{-- Subjek --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Subjek*</label>

                    <div class="md:col-span-9">
                        <select name="id_subjek" class="w-full sm:max-w-xs border border-gray-400 rounded px-3 py-2">
                            <option value="">Pilih Subjek</option>
                            @if(isset($subjek))
                                @foreach($subjek as $s)
                                    <option value="{{ $s->id_subjek }}" {{ old('id_subjek', isset($book) ? ($book->subjek->first()->id_subjek ?? '') : '') == $s->id_subjek ? 'selected' : '' }}>{{ $s->nama_subjek }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('id_subjek')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Gambar Sampul --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Gambar Sampul</label>

                    <div class="md:col-span-9 flex flex-col sm:flex-row gap-4 sm:items-center">

                        <div
                            class="w-32 h-40 border border-gray-400 rounded flex items-center justify-center overflow-hidden bg-gray-100 shrink-0">
                            @php
                                $coverSrc = '';
                                if (isset($book) && $book->cover_buku) {
                                    try {
                                        $val = $book->cover_buku;
                                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists('covers/'.$val)) {
                                            $coverSrc = asset('storage/covers/'.$val);
                                        } else {
                                            // jika nilai sudah berupa data URI
                                            if (is_string($val) && str_starts_with($val, 'data:image/')) {
                                                $coverSrc = $val;
                                            } else {
                                                // deteksi konten mirip biner: terdapat karakter yang tidak dapat dicetak
                                                if (is_string($val) && preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', $val)) {
                                                    $coverSrc = 'data:image/jpeg;base64,' . base64_encode($val);
                                                } else {
                                                    // fallback: perlakukan sebagai nama file/path (mungkin tidak ada)
                                                    $coverSrc = asset('storage/covers/'.$val);
                                                }
                                            }
                                        }
                                    } catch (\Throwable $e) {
                                        $coverSrc = '';
                                    }
                                }
                            @endphp

                            <img id="preview" class="w-full h-full object-cover {{ $coverSrc ? '' : 'hidden' }}" src="{{ $coverSrc }}" alt="Cover" onerror="this.classList.add('hidden'); document.getElementById('placeholder').classList.remove('hidden');">
                            <span id="placeholder" class="text-gray-400 text-sm {{ $coverSrc ? 'hidden' : '' }}">Image</span>
                        </div>

                        <div class="flex flex-col gap-1 w-full">
                            <input type="file" id="coverInput"
                                class="w-full border border-gray-400 rounded
                            file:bg-blue-600 file:text-white file:border-0
                            file:px-4 file:py-2 file:pl-10"
                                name="cover" accept="image/png, image/jpeg">

                            @error('cover')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                            <span class="text-xs text-gray-500">
                                Maksimum 10MB (JPG, PNG)
                            </span>
                        </div>

                    </div>
                </div>

                {{-- Button --}}
                <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">

                    <button type="submit" name="submit" value="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    bg-blue-600 hover:bg-blue-700 text-white rounded-md
                    px-4 py-2 text-sm shadow-sm transition">
                        {{ (isset($book) && $book->exists) ? 'Update' : 'Submit' }}
                    </button>

                    @if(isset($book) && $book->exists)
                        <button type="button" onclick="window.singleDeleteAction='{{ route('admin.buku.destroy', $book->id_buku) }}'; if(window.openDeleteModal){ window.openDeleteModal(); } else { alert('Konfirmasi hapus tidak tersedia.'); }" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Hapus</button>
                    @endif

                    <a href="{{ route('admin.buku') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    bg-white border border-slate-300 text-slate-700 rounded-md
                    px-4 py-2 text-sm shadow-sm transition">
                        Batal
                    </a>

                </div>

            </div>
        </form>
    </div>

    @vite('resources/js/formbuku.js')

@endsection
