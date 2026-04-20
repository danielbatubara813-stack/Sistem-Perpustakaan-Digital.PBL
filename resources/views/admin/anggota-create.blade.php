@extends('layout.app-admin')

@section('content')
    <div class="p-6 poppins">
        <div class="mb-4 flex items-center justify-between bg-white rounded-lg p-4">
            <h1 class="font-bold text-3xl">Tambah Anggota</h1>
            <div class="font-medium text-gray-900 flex items-center gap-4">
                <img class="rounded-full w-8 h-8"
                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg" alt="">
                <span>Admin</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
            <div class="mb-4 flex items-center justify-between">
                <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                    <a id="daftarTab" href="{{ route('admin.anggota') }}"
                        class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.create') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Daftar
                        Anggota <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span></a>
                    <a href="{{ route('admin.anggota.jenis') }}"
                        class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.jenis*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Jenis
                        Keanggotaan</a>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.anggota.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">
                    <label class="sm:col-span-3 text-sm text-slate-700">Email*</label>
                    <div class="sm:col-span-9">
                        <input name="email" value="{{ old('email') }}" type="email" placeholder=""
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Nomor Identitas*</label>
                    <div class="sm:col-span-9">
                        <input name="identity_number" value="{{ old('identity_number') }}" type="text" placeholder=""
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('identity_number')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Jenis No.Identitas*</label>
                    <div class="sm:col-span-9 flex items-center gap-6">
                        <label class="inline-flex items-center gap-2"><input type="radio" name="identity_type"
                                value="NIM" {{ old('identity_type', 'NIM') == 'NIM' ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600" /> NIM</label>
                        <label class="inline-flex items-center gap-2"><input type="radio" name="identity_type"
                                value="NIDN" {{ old('identity_type') == 'NIDN' ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600" /> NIDN</label>
                        @error('identity_type')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Nama*</label>
                    <div class="sm:col-span-9">
                        <input name="name" value="{{ old('name') }}" type="text" placeholder="Nama lengkap"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Instansi*</label>
                    <div class="sm:col-span-9">
                        <input name="institution" value="{{ old('institution') }}" type="text" placeholder=""
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('institution')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Tanggal Lahir*</label>
                    <div class="sm:col-span-9">
                        <input name="birth_date" value="{{ old('birth_date') }}" type="date"
                            class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('birth_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Tanggal Registrasi*</label>
                    <div class="sm:col-span-9">
                        <input name="registration_date" value="{{ old('registration_date') }}" type="date"
                            class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('registration_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Tipe Keanggotaan*</label>
                    <div class="sm:col-span-9">
                        <select id="membership_type" name="membership_type"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option value="">Pilih tipe keanggotaan</option>
                            <option value="Mahasiswa" {{ old('membership_type') == 'Mahasiswa' ? 'selected' : '' }}>
                                Mahasiswa
                            </option>
                            <option value="Dosen Tetap" {{ old('membership_type') == 'Dosen Tetap' ? 'selected' : '' }}>
                                Dosen
                                Tetap</option>
                            <option value="Dosen Magang" {{ old('membership_type') == 'Dosen Magang' ? 'selected' : '' }}>
                                Dosen Magang</option>
                        </select>
                        @error('membership_type')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Jenis Kelamin*</label>
                    <div class="sm:col-span-9 flex items-center gap-6">
                        <label class="inline-flex items-center gap-2"><input type="radio" name="gender" value="L"
                                {{ old('gender', 'L') == 'L' ? 'checked' : '' }} class="h-4 w-4 text-blue-600" />
                            Laki-laki</label>
                        <label class="inline-flex items-center gap-2"><input type="radio" name="gender" value="P"
                                {{ old('gender') == 'P' ? 'checked' : '' }} class="h-4 w-4 text-blue-600" />
                            Perempuan</label>
                        @error('gender')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Nomor Hp*</label>
                    <div class="sm:col-span-9">
                        <input name="phone" value="{{ old('phone') }}" type="tel" placeholder=""
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Foto KTP*</label>
                    <div class="sm:col-span-9">
                        <div class="flex flex-col md:flex-row gap-4 items-start">
                            <div
                                class="w-48 h-36 border border-dashed border-slate-300 rounded-md flex items-center justify-center overflow-hidden bg-slate-50">
                                <img id="ktpPreview" src="" alt="KTP preview"
                                    class="object-contain w-full h-full hidden" />
                                <div id="ktpPlaceholder" class="text-slate-400">
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
                                <input id="ktpInput" name="ktp_photo" type="file"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                                @error('ktp_photo')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-slate-500 mt-1">Maks 10 MB. Format: jpg, jpeg, png.</p>
                            </div>
                        </div>
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Foto Profil</label>
                    <div class="sm:col-span-9">
                        <div class="flex flex-col md:flex-row gap-4 items-start">
                            <div
                                class="w-48 h-36 border border-dashed border-slate-300 rounded-md flex items-center justify-center overflow-hidden bg-slate-50">
                                <img id="profilePreview" src="" alt="Profile preview"
                                    class="object-contain w-full h-full hidden" />
                                <div id="profilePlaceholder" class="text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="12" cy="8" r="2" />
                                        <path d="M21 21s-4-4-9-4-9 4-9 4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input id="profileInput" name="profile_photo" type="file"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                                @error('profile_photo')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-slate-500 mt-1">Maks 10 MB. Format: jpg, jpeg, png.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Route::is('admin.anggota.verifikasi'))
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit" name="action" value="verify"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Verifikasi</button>
                        <button type="submit" name="action" value="reject"
                            class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Tolak</button>
                        <a href="{{ route('admin.anggota') }}"
                            class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
                    </div>
                @else
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit" name="submit" value="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">Submit</button>
                        <a href="{{ route('admin.anggota') }}"
                            class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">Batal</a>
                    </div>
                @endif
            </form>
        </div>
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

            setupPreview('ktpInput', 'ktpPreview', 'ktpPlaceholder');
            setupPreview('profileInput', 'profilePreview', 'profilePlaceholder');

            // update daftar label based on selected membership on create form
            const daftarLabel = document.getElementById('daftarTypeLabel');
            const membershipSelect = document.getElementById('membership_type');

            function updateDaftarLabel() {
                if (!daftarLabel) return;
                if (!membershipSelect) {
                    daftarLabel.textContent = '';
                    return;
                }
                const txt = membershipSelect.options[membershipSelect.selectedIndex].text || '';
                daftarLabel.textContent = (txt && txt !== 'Pilih tipe keanggotaan') ? `(${txt})` : '';
            }
            if (membershipSelect) {
                membershipSelect.addEventListener('change', updateDaftarLabel);
                updateDaftarLabel();
            }
        })();
    </script>
@endsection
