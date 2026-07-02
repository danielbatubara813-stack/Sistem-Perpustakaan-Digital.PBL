@extends('layout.app-admin')

@section('title', 'Form Anggota')
@php
    $title       = isset($anggota) ? 'Edit Anggota' : 'Tambah Anggota';
    $description = 'Form untuk menambahkan data anggota baru ke dalam sistem perpustakaan, termasuk informasi identitas dan keanggotaan.';
@endphp
@section('content')

    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                <a href="{{ route('admin.anggota.daftar') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.create', 'admin.anggota.edit') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                    Daftar Anggota
                </a>
                <a href="{{ route('admin.anggota.jenis') }}"
                    class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.jenis*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                    Jenis Keanggotaan
                </a>
            </div>
        </div>

        {{-- action & method otomatis: edit → PUT /{id}, create → POST / --}}
        @if (isset($anggota))
            <form method="POST" action="{{ route('admin.anggota.update', $anggota->id_anggota) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
        @else
            <form method="POST" action="{{ route('admin.anggota.store') }}" enctype="multipart/form-data">
                @csrf
        @endif

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-start">

                {{-- Email --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Email*</label>
                <div class="sm:col-span-9">
                    <input name="email" value="{{ old('email', $anggota->email ?? '') }}" type="email"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nomor Identitas --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Nomor Identitas*</label>
                <div class="sm:col-span-9">
                    <input name="identity_number" value="{{ old('identity_number', $anggota->nomor_identitas ?? '') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('identity_number')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Jenis No Identitas --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Jenis No.Identitas*</label>
                <div class="sm:col-span-9 flex items-center gap-6">
                    @php $selectedIdentityType = old('identity_type', $anggota->jenis_nomor_identitas ?? 'NIM'); @endphp
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="identity_type" value="NIM"
                            {{ $selectedIdentityType == 'NIM' ? 'checked' : '' }} class="h-4 w-4 text-blue-600" /> NIM
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="identity_type" value="NIDN"
                            {{ $selectedIdentityType == 'NIDN' ? 'checked' : '' }} class="h-4 w-4 text-blue-600" /> NIDN
                    </label>
                    @error('identity_type')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nama --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Nama*</label>
                <div class="sm:col-span-9">
                    <input name="name" value="{{ old('name', $anggota->nama ?? '') }}" type="text" placeholder="Nama lengkap"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Instansi
                <label class="sm:col-span-3 text-sm text-slate-700">Instansi*</label>
                <div class="sm:col-span-9">
                    <input name="institution" value="{{ old('institution', $anggota->instansi ?? '') }}" type="text"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('institution')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div> --}}

                {{-- Tanggal Lahir --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Tanggal Lahir*</label>
                <div class="sm:col-span-9">
                    <input name="birth_date" value="{{ old('birth_date', $anggota->tanggal_lahir ?? '') }}" type="date"
                        class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('birth_date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tanggal Registrasi: auto saat create, readonly saat edit --}}
                @if (isset($anggota))
                    <label class="sm:col-span-3 text-sm text-slate-700">Tanggal Registrasi</label>
                    <div class="sm:col-span-9">
                        <input type="date"
                            value="{{ $anggota->tanggal_daftar ? \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('Y-m-d') : '' }}"
                            readonly
                            class="rounded-md border border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500 cursor-not-allowed" />
                        <p class="text-xs text-slate-400 mt-1">Tanggal registrasi tidak dapat diubah.</p>
                    </div>
                @endif

                {{-- Tipe Keanggotaan --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Tipe Keanggotaan*</label>
                <div class="sm:col-span-9">
                    <select id="membership_type" name="membership_type"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Pilih tipe keanggotaan</option>
                        @foreach ($jenisKeanggotaan as $jenis)
                            <option value="{{ $jenis->id_jenis }}"
                                {{ old('membership_type', $anggota->id_jenis ?? '') == $jenis->id_jenis ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('membership_type')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Jenis Kelamin --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Jenis Kelamin*</label>
                <div class="sm:col-span-9 flex items-center gap-6">
                    @php
                        // DB simpan 'Laki-Laki'/'Perempuan', form kirim 'L'/'P'
                        $dbGender       = $anggota->jenis_kelamin ?? '';
                        $genderNorm     = match($dbGender) {
                            'Laki-Laki' => 'L',
                            'Perempuan' => 'P',
                            default     => $dbGender,
                        };
                        $selectedGender = old('gender', $genderNorm ?: 'L');
                    @endphp
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="gender" value="L"
                            {{ $selectedGender == 'L' ? 'checked' : '' }} class="h-4 w-4 text-blue-600" /> Laki-laki
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="gender" value="P"
                            {{ $selectedGender == 'P' ? 'checked' : '' }} class="h-4 w-4 text-blue-600" /> Perempuan
                    </label>
                    @error('gender')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nomor HP --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Nomor Hp*</label>
                <div class="sm:col-span-9">
                    <input name="phone" value="{{ old('phone', $anggota->no_hp ?? '') }}" type="tel"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                    @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status & Verifikasi (hanya tampil saat edit) --}}
                @if (isset($anggota))
                    <label class="sm:col-span-3 text-sm text-slate-700">Status Anggota</label>
                    <div class="sm:col-span-9">
                        <select name="status_anggota"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option value="Aktif"       {{ old('status_anggota', $anggota->status_anggota) == 'Aktif'       ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status_anggota', $anggota->status_anggota) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <label class="sm:col-span-3 text-sm text-slate-700">Verifikasi Admin</label>
                    <div class="sm:col-span-9">
                        <select name="verifikasi_admin"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option value="Menunggu"      {{ old('verifikasi_admin', $anggota->verifikasi_admin) == 'Menunggu'      ? 'selected' : '' }}>Menunggu</option>
                            <option value="Terverifikasi" {{ old('verifikasi_admin', $anggota->verifikasi_admin) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="Ditolak"       {{ old('verifikasi_admin', $anggota->verifikasi_admin) == 'Ditolak'       ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                @endif

                {{-- Foto KTP --}}
                <label class="sm:col-span-3 text-sm text-slate-700">
                    Foto KTP{{ isset($anggota) ? '' : '*' }}
                </label>
                <div class="sm:col-span-9">
                    <div class="flex flex-col md:flex-row gap-4 items-start">
                        <div class="w-48 h-36 border border-dashed border-slate-300 rounded-md flex items-center justify-center overflow-hidden bg-slate-50">
                            @if (isset($anggota) && $anggota->foto_ktp)
                                <img id="ktpPreview" src="{{ asset('storage/' . $anggota->foto_ktp) }}" alt="KTP" class="object-contain w-full h-full" />
                                <div id="ktpPlaceholder" class="text-slate-400 hidden">
                            @else
                                <img id="ktpPreview" src="" alt="KTP" class="object-contain w-full h-full hidden" />
                                <div id="ktpPlaceholder" class="text-slate-400">
                            @endif
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <path d="M21 15 16 10 5 21" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input id="ktpInput" name="ktp_photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                            @error('ktp_photo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-slate-500 mt-1">Maks 10 MB. Format: jpg, jpeg, png.</p>
                        </div>
                    </div>
                </div>

                {{-- Foto Profil --}}
                <label class="sm:col-span-3 text-sm text-slate-700">Foto Profil</label>
                <div class="sm:col-span-9">
                    <div class="flex flex-col md:flex-row gap-4 items-start">
                        <div class="w-48 h-36 border border-dashed border-slate-300 rounded-md flex items-center justify-center overflow-hidden bg-slate-50">
                            @if (isset($anggota) && $anggota->profile)
                                <img id="profilePreview" src="{{ asset('storage/' . $anggota->profile) }}" alt="Profil" class="object-contain w-full h-full" />
                                <div id="profilePlaceholder" class="text-slate-400 hidden">
                            @else
                                <img id="profilePreview" src="" alt="Profil" class="object-contain w-full h-full hidden" />
                                <div id="profilePlaceholder" class="text-slate-400">
                            @endif
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="12" cy="8" r="2" />
                                    <path d="M21 21s-4-4-9-4-9 4-9 4" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input id="profileInput" name="profile_photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                            @error('profile_photo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-slate-500 mt-1">Maks 10 MB. Format: jpg, jpeg, png.{{ isset($anggota) ? ' Kosongkan jika tidak ingin mengganti.' : '' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow-sm transition">
                    {{ isset($anggota) ? 'Simpan Perubahan' : 'Submit' }}
                </button>
                <a href="{{ route('admin.anggota.daftar') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 rounded-md px-4 py-2 text-sm shadow-sm transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

    <script>
        (function () {
            function setupPreview(inputId, previewId, placeholderId) {
                const input       = document.getElementById(inputId);
                const preview     = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                if (!input) return;

                input.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (!file) {
                        preview?.classList.add('hidden');
                        placeholder?.classList.remove('hidden');
                        return;
                    }
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File terlalu besar. Maksimal 10 MB.');
                        this.value = '';
                        preview?.classList.add('hidden');
                        placeholder?.classList.remove('hidden');
                        return;
                    }
                    if (!['image/jpeg', 'image/png'].includes(file.type)) {
                        alert('Tipe file tidak diizinkan. Gunakan jpg, jpeg, atau png.');
                        this.value = '';
                        preview?.classList.add('hidden');
                        placeholder?.classList.remove('hidden');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = e => {
                        if (preview) { preview.src = e.target.result; preview.classList.remove('hidden'); }
                        placeholder?.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }

            setupPreview('ktpInput',     'ktpPreview',     'ktpPlaceholder');
            setupPreview('profileInput', 'profilePreview', 'profilePlaceholder');

            // Update label tab sesuai tipe keanggotaan yang dipilih
            const membershipSelect = document.getElementById('membership_type');
            function updateDaftarLabel() {
                if (!daftarLabel || !membershipSelect) return;
                const txt = membershipSelect.options[membershipSelect.selectedIndex]?.text || '';
                daftarLabel.textContent = (txt && txt !== 'Pilih tipe keanggotaan') ? `(${txt})` : '';
            }
            membershipSelect?.addEventListener('change', updateDaftarLabel);
            updateDaftarLabel();
        })();
    </script>
@endsection
