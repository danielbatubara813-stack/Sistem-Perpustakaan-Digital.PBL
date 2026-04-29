@extends('layout.app-admin')

@section('title', 'Form Buku')
@php
    $title = 'Daftar Buku';
    $description = 'Kelola koleksi buku dan lihat informasi ringkas setiap judul.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-xl shadow mt-4">

        <h2 class="text-lg font-semibold mb-6">DAFTAR BUKU</h2>

        <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">

                {{-- Judul --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">Judul*</label>
                    <input type="text" class="col-span-9 border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Penulis --}}
                <div class="grid grid-cols-12 items-start">
                    <label class="col-span-3">Penulis*</label>
                    <div class="col-span-9 space-y-2">
                        <button type="button" class="bg-blue-800 text-white px-3 py-2 rounded hover:bg-blue-900">
                            Tambah Data Penulis
                        </button>
                        <input type="text" class="w-full border border-gray-400 rounded px-3 py-2">
                    </div>
                </div>

                {{-- No Rak --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">No.Rak*</label>
                    <input type="text" id="no_rak" class="col-span-9 border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- No Panggil --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">No.Panggil*</label>
                    <div class="col-span-9 flex">
                        <input max="7" type="text" id="no_panggil_1" readonly
                            class="w-24 border border-gray-400 rounded-l px-3 py-2 bg-gray-200">
                        <input type="text" class="flex-1 border border-gray-400 rounded-r px-3 py-2">
                    </div>
                </div>

                {{-- Penerbit --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">Penerbit*</label>
                    <input type="text" class="col-span-9 border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- KODE UNIK --}}
                <div class="grid grid-cols-12 items-start">
                    <label class="col-span-3">Kode Unik*</label>

                    <div class="col-span-9">
                        <div class="grid grid-cols-4 gap-3 max-w-lg">

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

                        <div class="flex gap-2 items-center justify-start">
                            {{-- tombol regenerate --}}
                            <button type="button" id="regenBtn"
                                class="bg-blue-800 text-white mt-2 px-3 py-2 rounded text-sm hover:bg-blue-900">
                                Regenerate Kode 1 & 2
                            </button>

                            <p class="text-xs text-gray-500 mt-2">
                                Kode 1 & 2 bisa manual (4 karakter). Kode 3 otomatis dari jumlah buku.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Bahasa --}}
                <div class="grid grid-cols-12 items-start">
                    <label class="col-span-3">Bahasa*</label>
                    <select class="col-span-3 border border-gray-400 rounded px-3 py-2">
                        <option>Default</option>
                        <option>Indonesia</option>
                        <option>English</option>
                    </select>
                </div>

                {{-- ISBN --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">ISBN/ISSN*</label>
                    <input type="text" class="col-span-9 border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Edisi --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">Edisi</label>
                    <input type="text" class="col-span-9 border border-gray-400 rounded px-3 py-2">
                </div>

                {{-- Subjek --}}
                <div class="grid grid-cols-12 items-center">
                    <label class="col-span-3">Subjek</label>
                    <select class="col-span-3 border border-gray-400 rounded px-3 py-2">
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
                <div class="grid grid-cols-12 items-start">
                    <label class="col-span-3">Gambar Sampul</label>

                    <div class="col-span-9 flex items-center gap-4">

                        <div
                            class="w-32 h-40 border border-gray-400 rounded flex items-center justify-center overflow-hidden bg-gray-100">
                            <img id="preview" class="hidden w-full h-full object-cover">
                            <span id="placeholder" class="text-gray-400 text-sm">Image</span>
                        </div>

                        <div class="flex flex-col gap-1">
                            <input type="file" id="coverInput"
                                class="border border-gray-400 rounded file:bg-blue-800 file:text-white" name="cover"
                                accept="image/png, image/jpeg">
                            <span class="text-xs text-gray-500">
                                Maksimum 10MB (JPG, PNG)
                            </span>
                        </div>

                    </div>
                </div>

                {{-- Button --}}
                <div class="mt-6 flex justify-end gap-3">
                    <button type="submit" name="submit" value="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Submit</button>
                    <a href="{{ route('admin.buku') }}"
                        class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
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
