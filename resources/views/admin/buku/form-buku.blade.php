@extends('layout.app-admin')

@section('title', 'Form Buku')
@php
    $title = 'Daftar Buku';
    $description = 'Kelola koleksi buku dan lihat informasi ringkas setiap judul.';
@endphp
@section('content')
    <div class="bg-white p-4 sm:p-6 rounded-xl shadow mt-4">

        <h2 class="text-lg font-semibold mb-6">DAFTAR BUKU</h2>

        <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-5">

                {{-- Judul --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Judul*</label>

                    <input type="text" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Penulis --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Penulis*</label>

                    <div class="md:col-span-9 space-y-2">
                        {{-- BUTTON OPEN MODAL --}}
                        <button type="button" data-modal-target="modal-penulis" data-modal-toggle="modal-penulis"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all duration-300">
                            Tambah Data Penulis
                        </button>

                        {{-- MODAL --}}
                        <div id="modal-penulis" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

                            <div class="relative p-4 w-full max-w-2xl max-h-full">

                                {{-- CONTENT --}}
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

                                    {{-- BODY --}}
                                    <div class="p-4 md:p-5 space-y-6">

                                        {{-- NAMA PENULIS --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">

                                            <label class="sm:col-span-3 text-sm text-slate-700">
                                                Nama Penulis*
                                            </label>

                                            <div class="sm:col-span-9">

                                                <input name="nama_penulis" value="{{ old('nama_penulis') }}" type="text"
                                                    placeholder="Contoh: Tere Liye"
                                                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                                                @error('nama_penulis')
                                                    <p class="text-sm text-red-600 mt-1">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- TIPE PENULIS --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">

                                            <label class="sm:col-span-3 text-sm text-slate-700">
                                                Tipe Penulis*
                                            </label>

                                            <div class="sm:col-span-9">

                                                <select name="tipe_penulis"
                                                    class="w-full sm:max-w-48 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">

                                                    <option value="Nama Orang">Nama Orang</option>
                                                    <option value="Organisasi">Organisasi</option>
                                                    <option value="Konferensi">Konferensi</option>
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

                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="text" class="w-full border border-gray-400 rounded px-3 py-2">
                    </div>
                </div>

                {{-- No Rak --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">No.Rak*</label>

                    <input type="text" id="no_rak" maxlength="10"
                        class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- No Panggil --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">No.Panggil*</label>

                    <div class="md:col-span-9 flex w-full">
                        <input max="7" type="text" id="no_panggil_1" readonly
                            class="w-24 border border-gray-400 rounded-l px-3 py-2 bg-gray-200">

                        <input type="text" class="flex-1 border border-gray-400 rounded-r px-3 py-2 min-w-0">
                    </div>
                </div>

                {{-- Penerbit --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Penerbit*</label>

                    <input type="text" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- KODE UNIK --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Kode Unik*</label>

                    <div class="md:col-span-9">

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full">

                            {{-- Kode 1 --}}
                            <input type="text" id="kode_1" maxlength="4"
                                class="border border-gray-400 rounded px-3 py-2 uppercase">

                            {{-- Kode 2 --}}
                            <input type="text" id="kode_2" maxlength="4"
                                class="border border-gray-400 rounded px-3 py-2 uppercase">

                            {{-- Kode 3 --}}
                            <input type="text" id="kode_3" readonly
                                class="border border-gray-400 rounded px-3 py-2 bg-gray-100">

                            {{-- Jumlah Buku --}}
                            <input type="number" id="jumlah_buku" min="1" value="1"
                                class="border border-gray-400 rounded px-3 py-2">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center mt-2">

                            {{-- tombol regenerate --}}
                            <button type="button" id="regenBtn"
                                class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition w-full sm:w-max">
                                Regenerate Kode 1 & 2
                            </button>

                            <p class="text-xs text-gray-500">
                                Kode 1 & 2 bisa manual (4 karakter). Kode 3 otomatis dari jumlah buku.
                            </p>

                        </div>
                    </div>
                </div>

                {{-- Bahasa --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Bahasa*</label>

                    <select class="md:col-span-3 w-full border border-gray-400 rounded px-3 py-2">
                        <option>Default</option>
                        <option>Indonesia</option>
                        <option>English</option>
                    </select>
                </div>

                {{-- ISBN --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">ISBN/ISSN*</label>

                    <input type="text" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Edisi --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start md:items-center">
                    <label class="md:col-span-3">Edisi</label>

                    <input type="text" class="md:col-span-9 w-full border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Subjek --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Subjek</label>

                    <select class="md:col-span-3 w-full border border-gray-400 rounded px-3 py-2">
                        <option value="">Pilih Subjek</option>
                        <option value="teknologi">Teknologi</option>
                        <option value="sains">Sains</option>
                        <option value="matematika">Matematika</option>
                        <option value="sejarah">Sejarah</option>
                        <option value="bahasa">Bahasa</option>
                        <option value="sastra">Sastra</option>
                        <option value="ekonomi">Ekonomi</option>
                        <option value="pendidikan">Pendidikan</option>
                        <option value="agama">Agama</option>
                        <option value="seni">Seni & Desain</option>
                    </select>
                </div>

                {{-- Gambar Sampul --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-start">
                    <label class="md:col-span-3">Gambar Sampul</label>

                    <div class="md:col-span-9 flex flex-col sm:flex-row gap-4 sm:items-center">

                        <div
                            class="w-32 h-40 border border-gray-400 rounded flex items-center justify-center overflow-hidden bg-gray-100 shrink-0">
                            <img id="preview" class="hidden w-full h-full object-cover">
                            <span id="placeholder" class="text-gray-400 text-sm">Image</span>
                        </div>

                        <div class="flex flex-col gap-1 w-full">
                            <input type="file" id="coverInput"
                                class="w-full border border-gray-400 rounded
                            file:bg-blue-600 file:text-white file:border-0
                            file:px-4 file:py-2 file:pl-10"
                                name="cover" accept="image/png, image/jpeg">

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
                        Submit
                    </button>

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

    {{-- SCRIPT --}}
    <script>
        const kode1 = document.getElementById('kode_1');
        const kode2 = document.getElementById('kode_2');
        const kode3 = document.getElementById('kode_3');
        const jumlah = document.getElementById('jumlah_buku');

        // 🔹 No Rak → No Panggil
        document.getElementById('no_rak').addEventListener('input', function() {
            document.getElementById('no_panggil_1').value = this.value;
        });

        // 🔹 Random 4 karakter
        function randomCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 4; i++) {
                result += chars[Math.floor(Math.random() * chars.length)];
            }
            return result;
        }

        // 🔹 Format 0001
        function formatNumber(n) {
            return n.toString().padStart(4, '0');
        }

        // 🔹 Generate kode 1 & 2
        function generateKode12() {
            kode1.value = randomCode();
            kode2.value = randomCode();
        }

        // 🔹 Update kode 3
        function updateKode3() {
            kode3.value = formatNumber(parseInt(jumlah.value) || 1);
        }

        // 🔹 Uppercase + limit 4
        function enforce(el) {
            el.addEventListener('input', function() {
                this.value = this.value.toUpperCase().slice(0, 4);
            });
        }

        enforce(kode1);
        enforce(kode2);

        // 🔹 Event
        jumlah.addEventListener('input', updateKode3);
        document.getElementById('regenBtn').addEventListener('click', generateKode12);

        // 🔹 Preview gambar
        document.getElementById('coverInput').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');

            if (!file) return;

            if (file.size > 10 * 1024 * 1024) {
                alert('File terlalu besar (maks 10MB)');
                this.value = '';
                return;
            }

            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                alert('Format harus JPG atau PNG');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });

        // 🔹 Init
        generateKode12();
        updateKode3();
    </script>

@endsection
