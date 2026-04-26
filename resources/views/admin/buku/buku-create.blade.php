@extends('layout.app-admin')

@section('title', 'Form Buku')
@php
    $title = 'Tambah Buku';
    $description = 'Form untuk menambahkan data buku baru ke dalam koleksi.';
@endphp
@section('content')

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold tracking-wide">DAFTAR BUKU</h2>
        </div>

        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                <label class="sm:col-span-3 text-sm text-slate-700">Judul*</label>
                <div class="sm:col-span-9">
                    <input name="judul" value="{{ old('judul') }}" type="text" placeholder=""
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('judul')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Penulis*</label>
                <div class="sm:col-span-9">
                    <div class="mb-2">
                        <button type="button"
                            class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-md px-3 py-2 text-sm transition">Tambah
                            Data Penulis</button>
                    </div>
                    <input name="penulis" value="{{ old('penulis') }}" type="text" placeholder="Nama penulis"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">No.Rak*</label>
                <div class="sm:col-span-9">
                    <input name="no_rak" value="{{ old('no_rak') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Penerbit</label>
                <div class="sm:col-span-9">
                    <input name="penerbit" value="{{ old('penerbit') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">No.Panggil*</label>
                <div class="sm:col-span-9">
                    <input name="no_panggil" value="{{ old('no_panggil') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Kode Unik*</label>
                <div class="sm:col-span-9">
                    <div id="kodeContainer" class="grid grid-cols-2 gap-2 max-w-xs" data-max="4">
                        <input name="kode_unik[]" type="text" maxlength="20" placeholder="Kode 1"
                            value="{{ old('kode_unik.0') }}"
                            class="kode-input rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        <input name="kode_unik[]" type="text" maxlength="20" placeholder="Kode 2"
                            value="{{ old('kode_unik.1') }}"
                            class="kode-input rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                        <input id="kode_unik_auto" name="kode_unik[]" type="text" maxlength="20" placeholder="Otomatis"
                            value="{{ old('kode_unik.2') ?? '' }}" readonly
                            class="kode-input rounded-md border border-slate-300 bg-slate-100 px-3 py-2 text-sm outline-none" />

                        <div id="kodeControls" class="flex flex-col items-start gap-2">
                            <div class="flex items-center gap-2">
                                <button type="button" id="addKodeBtn"
                                    class="rounded-md bg-slate-200 px-3 py-2 text-sm">Tambah Kode</button>
                                <button type="button" id="regenKodeBtn"
                                    class="rounded-md bg-slate-200 px-3 py-2 text-sm">Regenerate</button>
                            </div>
                            <p class="text-xs text-slate-500">Kode 1 &amp; 2: isi manual. Kode 3: otomatis. Maks 4 kode.</p>
                        </div>
                    </div>
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Jumlah Buku</label>
                <div class="sm:col-span-9">
                    <input name="jumlah_buku" type="number" min="1" value="{{ old('jumlah_buku', 1) }}"
                        class="w-32 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Bahasa*</label>
                <div class="sm:col-span-9">
                    <select name="bahasa"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Default</option>
                        <option value="id">Indonesia</option>
                        <option value="en">English</option>
                    </select>
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">ISBN/ISSN*</label>
                <div class="sm:col-span-9">
                    <input name="isbn" value="{{ old('isbn') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Edisi</label>
                <div class="sm:col-span-9">
                    <input name="edisi" value="{{ old('edisi') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Subjek</label>
                <div class="sm:col-span-9">
                    <input name="subjek" value="{{ old('subjek') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                </div>

                <label class="sm:col-span-3 text-sm text-slate-700">Gambar Sampul</label>
                <div class="sm:col-span-9">
                    <div class="flex flex-col md:flex-row gap-4 items-start">
                        <div
                            class="w-36 h-48 border border-dashed border-slate-300 rounded-md flex items-center justify-center overflow-hidden bg-slate-50">
                            <img id="coverPreview" src="" alt="Cover preview" class="object-contain w-full h-full hidden" />
                            <div id="coverPlaceholder" class="text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <path d="M21 15 16 10 5 21" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input id="coverInput" name="cover" type="file"
                                accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                            <p class="text-xs text-slate-500 mt-1">Maksimum 10MB. Format: jpg, jpeg, png.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Simpan</button>
                <a href="{{ route('admin.buku') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
            </div>
        </form>
    </div>

    <script>
        (function() {
            function setupPreview(inputId, previewId, placeholderId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                if (!input) return;
                input.addEventListener('change', function() {
                    const file = this.files && this.files[0];
                    if (!file) {
                        if (preview) preview.classList.add('hidden');
                        if (placeholder) placeholder.classList.remove('hidden');
                        return;
                    }

                    const maxBytes = 10 * 1024 * 1024; // 10 MB
                    const allowedTypes = ['image/jpeg', 'image/png'];

                    if (file.size > maxBytes) {
                        alert('File terlalu besar. Maksimal 10 MB.');
                        this.value = '';
                        if (preview) preview.classList.add('hidden');
                        if (placeholder) placeholder.classList.remove('hidden');
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak diizinkan. Gunakan jpg, jpeg, atau png.');
                        this.value = '';
                        if (preview) preview.classList.add('hidden');
                        if (placeholder) placeholder.classList.remove('hidden');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        if (placeholder) placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }

            setupPreview('coverInput', 'coverPreview', 'coverPlaceholder');

            function generateAutoKode() {
                const prefix = 'BK';
                const rand = Math.random().toString(36).slice(2, 8).toUpperCase();
                const time = Date.now().toString().slice(-4);
                return (prefix + rand + time).slice(0, 20);
            }

            function setAutoKode(force = false) {
                const el = document.getElementById('kode_unik_auto');
                if (!el) return;
                if (!force && el.value && el.value.trim() !== '') return; // don't overwrite existing value
                el.value = generateAutoKode();
            }

            // set on load
            setAutoKode();

            const regen = document.getElementById('regenKodeBtn');
            if (regen) regen.addEventListener('click', function() { setAutoKode(true); });

            // Add / limit kode inputs (max 4)
            const kodeContainer = document.getElementById('kodeContainer');
            const addBtn = document.getElementById('addKodeBtn');

            function countKodeInputs() {
                return kodeContainer.querySelectorAll('input[name="kode_unik[]"]').length;
            }

            function addKodeInput() {
                const max = parseInt(kodeContainer.getAttribute('data-max') || '4', 10);
                const current = countKodeInputs();
                if (current >= max) {
                    alert('Maksimal ' + max + ' kode.');
                    return;
                }

                // create new input
                const input = document.createElement('input');
                input.setAttribute('name', 'kode_unik[]');
                input.setAttribute('type', 'text');
                input.setAttribute('maxlength', '20');
                input.setAttribute('placeholder', 'Kode ' + (current + 1));
                input.className = 'kode-input rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200';

                // insert before controls element
                const controls = document.getElementById('kodeControls');
                kodeContainer.insertBefore(input, controls);

                // hide add button when reaching max
                if (countKodeInputs() >= max && addBtn) addBtn.disabled = true;
            }

            if (addBtn) {
                addBtn.addEventListener('click', addKodeInput);
            }

            // disable add if already at max on load
            if (addBtn && countKodeInputs() >= parseInt(kodeContainer.getAttribute('data-max') || '4', 10)) {
                addBtn.disabled = true;
            }

            // form validation: ensure at most max non-empty kode inputs
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const inputs = Array.from(form.querySelectorAll('input[name="kode_unik[]"]'));
                    const filled = inputs.filter(i => i.value && i.value.trim() !== '').length;
                    const max = parseInt(kodeContainer.getAttribute('data-max') || '4', 10);
                    if (filled > max) {
                        e.preventDefault();
                        alert('Anda hanya boleh memasukkan maksimal ' + max + ' kode.');
                        return false;
                    }
                });
            }
        })();
    </script>

@endsection
