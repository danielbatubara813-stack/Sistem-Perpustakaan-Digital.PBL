@extends('layout.app-admin')

@section('title', 'Form Buku')

@section('content')
<div class="bg-white p-6 rounded-xl shadow mt-4">

    <h2 class="text-lg font-semibold mb-6">DAFTAR BUKU</h2>

    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-4">

            {{-- Judul --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">Judul*</label>
                <input type="text" class="col-span-9 border rounded px-3 py-2">
            </div>

            {{-- Penulis --}}
            <div class="grid grid-cols-12 items-start">
                <label class="col-span-3">Penulis*</label>
                <div class="col-span-9 space-y-2">
                    <button type="button" class="bg-gray-300 px-3 py-2 rounded">
                        Tambah Data Penulis
                    </button>
                    <input type="text" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            {{-- No Rak --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">No.Rak*</label>
                <input type="text" id="no_rak"
                    class="col-span-9 border rounded px-3 py-2">
            </div>

            {{-- No Panggil --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">No.Panggil*</label>
                <div class="col-span-9 flex gap-2">
                    <input type="text" id="no_panggil_1"
                        class="w-24 border rounded px-3 py-2">
                    <input type="text"
                        class="flex-1 border rounded px-3 py-2">
                </div>
            </div>

            {{-- Penerbit --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">Penerbit*</label>
                <input type="text" class="col-span-9 border rounded px-3 py-2">
            </div>

            {{-- KODE UNIK --}}
            <div class="grid grid-cols-12 items-start">
                <label class="col-span-3">Kode Unik*</label>

                <div class="col-span-9">
                    <div class="grid grid-cols-2 gap-3 max-w-md">

                        {{-- Kode 1 --}}
                        <input type="text" id="kode_1" maxlength="4"
                            class="border rounded px-3 py-2 uppercase">

                        {{-- Kode 2 --}}
                        <input type="text" id="kode_2" maxlength="4"
                            class="border rounded px-3 py-2 uppercase">

                        {{-- Kode 3 --}}
                        <input type="text" id="kode_3" readonly
                            class="border rounded px-3 py-2 bg-gray-100">

                        {{-- Jumlah Buku --}}
                        <input type="number" id="jumlah_buku" min="1" value="1"
                            class="border rounded px-3 py-2">

                    </div>

                    {{-- tombol regenerate --}}
                    <button type="button" id="regenBtn"
                        class="mt-2 px-3 py-1 bg-gray-200 rounded text-sm hover:bg-gray-300">
                        Regenerate Kode 1 & 2
                    </button>

                    <p class="text-xs text-gray-500 mt-2">
                        Kode 1 & 2 bisa manual (4 karakter). Kode 3 otomatis dari jumlah buku.
                    </p>
                </div>
            </div>

            {{-- Bahasa --}}
            <div class="grid grid-cols-12 items-start">
                <label class="col-span-3">Bahasa*</label>
                <select class="col-span-3 border rounded px-3 py-2">
                    <option>Default</option>
                    <option>Indonesia</option>
                    <option>English</option>
                </select>
            </div>

            {{-- ISBN --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">ISBN/ISSN*</label>
                <input type="text" class="col-span-9 border rounded px-3 py-2">
            </div>

            {{-- Edisi --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">Edisi</label>
                <input type="text" class="col-span-9 border rounded px-3 py-2">
            </div>

            {{-- Subjek --}}
            <div class="grid grid-cols-12 items-center">
                <label class="col-span-3">Subjek</label>
                <input type="text" class="col-span-6 border rounded px-3 py-2">
            </div>

            {{-- Gambar Sampul --}}
            <div class="grid grid-cols-12 items-start">
                <label class="col-span-3">Gambar Sampul</label>

                <div class="col-span-9 flex items-center gap-4">

                    <div class="w-32 h-40 border rounded flex items-center justify-center overflow-hidden bg-gray-100">
                        <img id="preview" class="hidden w-full h-full object-cover">
                        <span id="placeholder" class="text-gray-400 text-sm">Image</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <input type="file" id="coverInput" name="cover"
                            accept="image/png, image/jpeg">
                        <span class="text-xs text-gray-500">
                            Maksimum 10MB (JPG, PNG)
                        </span>
                    </div>

                </div>
            </div>

            {{-- Button --}}
            <div class="flex justify-end gap-3 pt-4">
                <button class="bg-gray-300 px-4 py-2 rounded">Simpan</button>
                <button class="bg-gray-300 px-4 py-2 rounded">Batal</button>
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
    document.getElementById('no_rak').addEventListener('input', function () {
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
        el.addEventListener('input', function () {
            this.value = this.value.toUpperCase().slice(0, 4);
        });
    }

    enforce(kode1);
    enforce(kode2);

    // 🔹 Event
    jumlah.addEventListener('input', updateKode3);
    document.getElementById('regenBtn').addEventListener('click', generateKode12);

    // 🔹 Preview gambar
    document.getElementById('coverInput').addEventListener('change', function () {
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
        reader.onload = function (e) {
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
