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
                        @php
                            $tipePenulisOptions = collect(['Nama Orang', 'Badan Organisasi', 'Konferensi'])
                                ->merge($tipe_penulis ?? [])
                                ->filter()
                                ->unique()
                                ->values();
                            $oldPenulisBaruTipe = old('penulis_baru_tipe', []);
                        @endphp

                        <button type="button" id="penulis_modal_open"
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                            Tambah Data Penulis
                        </button>

                        {{-- Penulis yang dipilih akan muncul di sini; input tersembunyi membawa nilai id_penulis[] --}}
                        <div id="selected-authors"
                            class="min-h-[56px] w-full overflow-hidden rounded-md border border-gray-200 bg-white">
                            {{-- isi awal penulis terpilih saat mengedit atau setelah kesalahan validasi --}}
                            @if(old('id_penulis'))
                                @foreach(old('id_penulis') as $pid)
                                    @php
                                        $pobj = \App\Models\Penulis::find($pid);
                                    @endphp
                                    @if($pobj)
                                        <div class="author-chip flex items-center justify-between gap-3 px-3 py-3" data-id="{{ $pobj->id_penulis }}">
                                            <input type="hidden" name="id_penulis[]" value="{{ $pobj->id_penulis }}">
                                            <span class="min-w-0 text-sm text-slate-900">{{ $pobj->nama_penulis }} <small class="text-slate-500">({{ $pobj->tipe_penulis }})</small></span>
                                            <button type="button" class="remove-author shrink-0 text-sm font-medium text-red-600 hover:text-red-700" aria-label="Hapus penulis">Hapus</button>
                                        </div>
                                    @endif
                                @endforeach
                            @elseif(isset($book) && $book->penulis && $book->penulis->count())
                                @foreach($book->penulis as $p)
                                    <div class="author-chip flex items-center justify-between gap-3 px-3 py-3" data-id="{{ $p->id_penulis }}">
                                        <input type="hidden" name="id_penulis[]" value="{{ $p->id_penulis }}">
                                        <span class="min-w-0 text-sm text-slate-900">{{ $p->nama_penulis }} <small class="text-slate-500">({{ $p->tipe_penulis }})</small></span>
                                        <button type="button" class="remove-author shrink-0 text-sm font-medium text-red-600 hover:text-red-700" aria-label="Hapus penulis">Hapus</button>
                                    </div>
                                @endforeach
                            @endif

                            @if(old('penulis_baru'))
                                @foreach(old('penulis_baru') as $indexPenulisBaru => $namaPenulisBaru)
                                    @if(trim($namaPenulisBaru) !== '')
                                        @php
                                            $tipeBaru = $oldPenulisBaruTipe[$indexPenulisBaru] ?? 'Nama Orang';
                                        @endphp
                                        <div class="author-chip flex items-center justify-between gap-3 px-3 py-3" data-name="{{ strtolower(trim($namaPenulisBaru)) }}">
                                            <input type="hidden" name="penulis_baru[]" value="{{ trim($namaPenulisBaru) }}">
                                            <input type="hidden" name="penulis_baru_tipe[]" value="{{ $tipeBaru }}">
                                            <span class="min-w-0 text-sm text-slate-900">{{ trim($namaPenulisBaru) }} <small class="text-slate-500">({{ $tipeBaru }})</small></span>
                                            <button type="button" class="remove-author shrink-0 text-sm font-medium text-red-600 hover:text-red-700" aria-label="Hapus penulis">Hapus</button>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if(!old('id_penulis') && !old('penulis_baru') && !(isset($book) && $book->penulis && $book->penulis->count()))
                                <p class="px-3 py-3 text-sm text-gray-500">Belum ada penulis dipilih.</p>
                            @endif
                        </div>

                        @error('penulis_input')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('id_penulis')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('penulis_baru')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('penulis_baru_tipe')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        <div id="penulis_modal" class="fixed inset-0 z-[60] hidden bg-slate-900/70 px-4 py-6">
                            <div class="flex min-h-full items-center justify-center">
                                <div class="w-full max-w-2xl overflow-visible rounded-2xl bg-white shadow-xl">
                                    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                                        <h3 class="text-lg font-semibold text-slate-900">Tambah Data Penulis</h3>
                                        <button type="button" id="penulis_modal_close"
                                            class="rounded-md p-1 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                                            aria-label="Tutup modal penulis">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-5 px-5 py-5">
                                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-12 sm:items-start sm:gap-4">
                                            <label for="penulis_input" class="text-sm text-slate-700 sm:col-span-3 sm:pt-2">Nama Penulis*</label>

                                            <div class="relative sm:col-span-9">
                                                <input id="penulis_input" name="penulis_input" type="text"
                                                    placeholder="Pilih atau ketik nama penulis"
                                                    class="w-full rounded-md border border-slate-300 px-3 py-2 pr-10 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                                                    autocomplete="off"
                                                    role="combobox"
                                                    aria-autocomplete="list"
                                                    aria-expanded="false"
                                                    aria-controls="penulis_suggestions" />

                                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>

                                                <div id="penulis_suggestions"
                                                    class="absolute left-0 right-0 top-full z-[70] mt-1 hidden max-h-64 overflow-auto rounded-md border border-gray-400 bg-white py-1 shadow-lg"
                                                    role="listbox"></div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-12 sm:items-start sm:gap-4">
                                            <label for="penulis_tipe_input" class="text-sm text-slate-700 sm:col-span-3 sm:pt-2">Tipe Penulis</label>

                                            <div class="sm:col-span-9">
                                                <select id="penulis_tipe_input"
                                                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 sm:max-w-56">
                                                    @foreach($tipePenulisOptions as $tipePenulisOption)
                                                        <option value="{{ $tipePenulisOption }}">{{ $tipePenulisOption }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end gap-2 border-t border-gray-200 px-5 py-4">
                                        <button type="button" id="penulis_modal_cancel"
                                            class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-gray-200">
                                            Batal
                                        </button>
                                        <button type="button" id="addPenulisBtn"
                                            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                                class="border border-gray-400 rounded px-3 py-2 uppercase" {{ (isset($book) && $book->exists) ? 'readonly' : '' }}>

                            {{-- Kode 2 --}}
                            <input type="text" id="kode_2" name="kode_2" maxlength="4" value="{{ old('kode_2', $kode2Item ?? '') }}"
                                class="border border-gray-400 rounded px-3 py-2 uppercase" {{ (isset($book) && $book->exists) ? 'readonly' : '' }}>

                            {{-- Jumlah Buku --}}
                            <input type="number" id="jumlah_buku" name="jumlah_buku" min="{{ (isset($book) && $book->exists) ? $book->items->count() : 1 }}" value="{{ old('jumlah_buku', (isset($book) && $book->exists) ? $book->items->count() : 1) }}"
                                class="border border-gray-400 rounded px-3 py-2">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center mt-2">

                            {{-- tombol regenerate (only on create) --}}
                            @if(!(isset($book) && $book->exists))
                                <button type="button" id="regenBtn"
                                    class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition w-full sm:w-max">
                                    Regenerate Kode 1 & 2
                                </button>
                            @endif

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
                        @php
                            $selectedSubjek = old('id_subjek', isset($book) ? $book->subjek->pluck('id_subjek')->toArray() : []);
                        @endphp
                        {{-- Dropdown multi-select subjek --}}
                        <div class="relative inline-block text-left w-full sm:max-w-sm">
                            <div>
                                <button id="subjek_dropdown_btn" type="button"
                                    class="flex w-full items-center justify-between rounded-md border border-blue-600 bg-white px-3 py-2 text-left text-sm text-slate-900 outline-none transition focus:ring-2 focus:ring-blue-200"
                                    aria-expanded="false">
                                    <span id="subjek_dropdown_label" class="min-w-0 truncate">Pilih Subjek</span>
                                    <svg class="h-4 w-4 shrink-0 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            </div>

                            <div id="subjek_dropdown_menu" class="absolute left-0 top-full z-50 hidden max-h-72 w-full overflow-auto border border-slate-700 bg-white shadow-lg">
                                <div class="py-1" role="listbox" aria-multiselectable="true">
                                    <button type="button" id="subjek_clear_option"
                                        class="flex w-full items-center px-3 py-2 text-left text-sm text-slate-900 transition hover:bg-blue-600 hover:text-white">
                                        Pilih Subjek
                                    </button>
                                    @if(isset($subjek))
                                        @foreach($subjek as $s)
                                            <label class="subjek-option flex cursor-pointer items-center px-3 py-2 text-sm transition hover:bg-blue-600 hover:text-white {{ in_array($s->id_subjek, (array) $selectedSubjek) ? 'bg-blue-600 text-white' : 'bg-white text-slate-900' }}" data-id="{{ $s->id_subjek }}" role="option" aria-selected="{{ in_array($s->id_subjek, (array) $selectedSubjek) ? 'true' : 'false' }}">
                                                <input type="checkbox" class="subjek-checkbox sr-only" value="{{ $s->id_subjek }}" {{ in_array($s->id_subjek, (array) $selectedSubjek) ? 'checked' : '' }} />
                                                <span class="min-w-0 flex-1 truncate">{{ $s->nama_subjek }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Hidden inputs to submit selected subjek values --}}
                            <div id="subjek_hidden_inputs">
                                @if($selectedSubjek && count($selectedSubjek))
                                    @foreach($selectedSubjek as $sid)
                                        <input type="hidden" name="id_subjek[]" value="{{ $sid }}" />
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @error('id_subjek')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        {{-- kotak yang menampilkan subjek terpilih (visual) --}}
                        <div id="selected-subjek" class="w-full border border-gray-200 rounded px-3 py-2 min-h-[46px] mt-2">
                            @if($selectedSubjek && count($selectedSubjek))
                                @foreach($selectedSubjek as $sid)
                                    @php $sobj = \App\Models\Subjek::find($sid); @endphp
                                    @if($sobj)
                                        <div class="subjek-chip flex items-center justify-between gap-2 my-1" data-id="{{ $sobj->id_subjek }}">
                                            <span class="text-sm">{{ $sobj->nama_subjek }}</span>
                                            <button type="button" class="text-red-600 ml-2 remove-subjek">Hapus</button>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500">Belum ada subjek dipilih.</p>
                            @endif
                        </div>
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

    <script>
        window.PENULIS_DATA = @json(isset($penulis) ? $penulis->map(function($p){ return ['id' => $p->id_penulis, 'nama' => $p->nama_penulis, 'tipe' => $p->tipe_penulis]; }) : []);
    </script>
    @vite('resources/js/formbuku.js')

@endsection
