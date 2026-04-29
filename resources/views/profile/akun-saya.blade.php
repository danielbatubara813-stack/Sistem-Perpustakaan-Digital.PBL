@extends('layout.profile-anggota-app')
@section('title', 'Akun Saya')

@section('content')
    <div class="w-full flex flex-col gap-4 p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <h2 class="col-span-2 text-lg font-bold">Data Anggota</h2>

            <div class="col-span-2 ">
                <form action="" class="flex items-center gap-2">
                    <!-- Preview -->
                    <div class="flex items-center justify-center">
                        <img id="preview" src="https://via.placeholder.com/150"
                            class="w-48 h-48 rounded-md object-cover border-2 border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Profile Image
                        </label>
                        <!-- Input File -->
                        <input type="file" id="imageInput" accept="image/*"
                            class="block w-lg border border-gray-300 rounded-md text-sm px-6 py-2 text-gray-500
               file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100
               cursor-pointer" />
                        <p class="text-sm font-bold italic mt-2">Format: JPEG, PNG, JPG. Maks: 10MB</p>
                    </div>
                    <button type="submit"
                        class="bg-blue-600 p-2 w-max px-6 rounded-md text-white flex gap-4 items-center justify-center hover:bg-blue-700 ease-in-out transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                            <path
                                d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        <span>Simpan</span>
                    </button>
                </form>
            </div>
            <!-- Nama Anggota -->
            <div class="flex flex-col gap-4">
                <label for="nama_anggota">Nama Anggota</label>
                <input id="nama_anggota" type="text" value="Daniel Anju Adinov Batubara" readonly
                    class="w-full rounded-md border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 cursor-not-allowed" />
            </div>

            <!-- ID Anggota -->
            <div class="flex flex-col gap-4">
                <label for="id_anggota">ID Anggota</label>
                <input id="id_anggota" type="text" value="3312501025" readonly
                    class="w-full rounded-md border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 cursor-not-allowed" />
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-4">
                <label for="email">Email</label>
                <input id="email" type="email" value="franklin@email.com" readonly
                    class="w-full rounded-md border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 cursor-not-allowed" />
            </div>

            <!-- Tipe Keanggotaan -->
            <div class="flex flex-col gap-4">
                <label for="tipe_keanggotaan">Tipe Keanggotaan</label>
                <input id="tipe_keanggotaan" type="text" value="Mahasiswa" readonly
                    class="w-full rounded-md border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 cursor-not-allowed" />
            </div>

            <!-- Tanggal Registrasi -->
            <div class="flex flex-col gap-4">
                <label for="tanggal_registrasi">Tanggal Registrasi</label>
                <input id="tanggal_registrasi" type="date" value="2026-04-16" readonly
                    class="w-full rounded-md border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 cursor-not-allowed" />
            </div>
        </div>
        <form action="" class="grid grid-cols-2 gap-4">
            <h2 class="col-span-2 text-lg font-bold">Ganti Kata Sandi</h2>
            <!-- Kata Sandi -->
            <div class="flex flex-col gap-2">
                <label for="kata_sandi">Kata Sandi</label>
                <div class="relative">
                    <input id="kata_sandi" type="password" placeholder="Kata Sandi..."
                        class="w-full rounded-md border border-slate-300 px-4 py-3 pr-10 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <button type="button" onmousedown="showPassword('kata_sandi', this)"
                        onmouseup="hidePassword('kata_sandi', this)" onmouseleave="hidePassword('kata_sandi', this)"
                        ontouchstart="showPassword('kata_sandi', this)" ontouchend="hidePassword('kata_sandi', this)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">

                        <!-- Eye -->
                        <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        <!-- Eye Off -->
                        <svg class="eye-close w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m15 18-.722-3.25" />
                            <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                            <path d="m20 15-1.726-2.05" />
                            <path d="m4 15 1.726-2.05" />
                            <path d="m9 18 .722-3.25" />
                        </svg>

                    </button>
                </div>
            </div>

            <!-- Konfirmasi Kata Sandi -->
            <div class="flex flex-col gap-2">
                <label for="konfirm_kata_sandi">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input id="konfirm_kata_sandi" type="password" placeholder="Konfirmasi Kata Sandi..."
                        class="w-full rounded-md border border-slate-300 px-4 py-3 pr-10 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                    <button type="button" onmousedown="showPassword('konfirm_kata_sandi', this)"
                        onmouseup="hidePassword('konfirm_kata_sandi', this)"
                        onmouseleave="hidePassword('konfirm_kata_sandi', this)"
                        ontouchstart="showPassword('konfirm_kata_sandi', this)"
                        ontouchend="hidePassword('konfirm_kata_sandi', this)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">

                        <!-- Eye -->
                        <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        <!-- Eye Off -->
                        <svg class="eye-close w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m15 18-.722-3.25" />
                            <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                            <path d="m20 15-1.726-2.05" />
                            <path d="m4 15 1.726-2.05" />
                            <path d="m9 18 .722-3.25" />
                        </svg>

                    </button>
                </div>
            </div>
            <div class="col-span-2 flex justify-end items-center gap-4">
                <button
                    class="bg-slate-500 py-2 w-max px-6 rounded-md text-white flex gap-4 items-center justify-center
                    hover:bg-slate-600 ease-in-out transition-all duration-300"
                    type="reset">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-rotate-ccw-icon lucide-rotate-ccw">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                    </svg>
                    <span>Reset</span>
                </button>
                <button type="submit"
                    class="bg-blue-600 py-2 w-max px-6 rounded-md text-white flex gap-4 items-center justify-center hover:bg-blue-700 ease-in-out transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                        <path
                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                    <span>Simpan</span>
                </button>

            </div>
        </form>
    </div>
    <script>
        function showPassword(id, btn) {
            const input = document.getElementById(id);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClose = btn.querySelector('.eye-close');

            input.type = "text";
            eyeOpen.classList.add('hidden');
            eyeClose.classList.remove('hidden');
        }

        function hidePassword(id, btn) {
            const input = document.getElementById(id);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClose = btn.querySelector('.eye-close');

            input.type = "password";
            eyeOpen.classList.remove('hidden');
            eyeClose.classList.add('hidden');
        }
    </script>
    <script>
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('preview');

        input.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
