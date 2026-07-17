@extends('layout.auth-layout')
@section('title', 'Register')
@section('content')
    <div class="flex flex-col items-center w-full min-h-full justify-center py-4">
        <h2 class="text-3xl font-extrabold text-black text-center mb-2">Selamat Datang!</h2>
        <p class="text-sm text-gray-500 text-center mb-8 font-medium">
            Daftarkan akun anda dan nikmati berbagai koleksi buku kami!
        </p>

        <form method="POST" action="/register" enctype="multipart/form-data" autocomplete="off"
            class="space-y-6 w-full md:w-3/4">
            @csrf

            <!-- Email -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Email
                </label>
                <input type="email" name="email" placeholder="Email" autocomplete="off" value="{{ old('email') }}"
                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                    @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Identitas -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <path d="M7 8h6" />
                        <path d="M7 12h4" />
                        <path d="M7 16h2" />
                    </svg>
                    Nomor Identitas
                </label>
                <input type="text" name="identity_number" placeholder="Nomor Identitas" autocomplete="off"
                    value="{{ old('identity_number') }}"
                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                    @error('identity_number') border-red-500 @enderror">
                @error('identity_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Nomor Identitas -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <path d="M7 8h6" />
                        <path d="M7 12h4" />
                        <path d="M7 16h2" />
                    </svg>
                    Jenis Nomor Identitas
                </label>
                <div class="flex items-center gap-6">
                    @php $selectedIdentityType = old('identity_type', 'NIM'); @endphp
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-black cursor-pointer">
                        <input type="radio" name="identity_type" value="NIM"
                            {{ $selectedIdentityType == 'NIM' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-600">
                        NIM
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-black cursor-pointer">
                        <input type="radio" name="identity_type" value="NIDN"
                            {{ $selectedIdentityType == 'NIDN' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-600">
                        NIDN
                    </label>
                </div>
                @error('identity_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Nama Lengkap
                </label>
                <input type="text" name="name" placeholder="Nama Lengkap" autocomplete="off"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                    @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipe Keanggotaan -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" />
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    </svg>
                    Tipe Keanggotaan
                </label>
                <select name="membership_type"
                    class="w-full px-4 py-3 border border-gray-400 rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                    @error('membership_type') border-red-500 @enderror">
                    <option value="" disabled selected>Pilih Tipe Keanggotaan</option>
                    @foreach ($jenisKeanggotaan as $jenis)
                        <option value="{{ $jenis->id_jenis }}"
                            {{ old('membership_type') == $jenis->id_jenis ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
                @error('membership_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Jenis Kelamin
                </label>
                <div class="flex items-center gap-6">
                    @php $selectedGender = old('gender', 'L'); @endphp
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-black cursor-pointer">
                        <input type="radio" name="gender" value="L"
                            {{ $selectedGender == 'L' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-600">
                        Laki-laki
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-black cursor-pointer">
                        <input type="radio" name="gender" value="P"
                            {{ $selectedGender == 'P' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-600">
                        Perempuan
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Telepon & Tanggal Lahir -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2 text-start">
                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127 1.04.306 2.07.54 3.07a2 2 0 0 1-.45 1.96L7.91 8.52a16 16 0 0 0 6.07 6.07l1.77-1.77a2 2 0 0 1 1.96-.45c1 .235 2.03.414 3.07.54A2 2 0 0 1 22 16.92z" />
                        </svg>
                        No Telepon
                    </label>
                    <input type="text" name="phone" placeholder="No Telepon" autocomplete="off"
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                        @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 text-start">
                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4" />
                            <path d="M8 2v4" />
                            <path d="M3 10h18" />
                        </svg>
                        Tanggal Lahir
                    </label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                        class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                        @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Photo KTP -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3z" />
                        <circle cx="12" cy="13" r="3" />
                    </svg>
                    Photo KTP
                </label>
                <div class="flex flex-col md:flex-row gap-4 items-start">
                    <div
                        class="w-48 h-36 border border-dashed border-gray-400 rounded-[10px] flex items-center justify-center overflow-hidden bg-gray-50">
                        <img id="ktpPreview" src="" alt="KTP"
                            class="object-contain w-full h-full hidden" />
                        <div id="ktpPlaceholder" class="text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <path d="M21 15 16 10 5 21" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input id="ktpInput" type="file" name="ktp_photo"
                            accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                        @error('ktp_photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Maks 10 MB. Format: jpg, jpeg, png.</p>
                    </div>
                </div>
            </div>

            <!-- Photo Profil -->
            <div class="space-y-2 text-start">
                <label class="flex items-center gap-2 text-xs font-bold text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Photo Profil <span class="font-normal text-gray-500">(opsional)</span>
                </label>
                <div class="flex flex-col md:flex-row gap-4 items-start">
                    <div
                        class="w-48 h-36 border border-dashed border-gray-400 rounded-[10px] flex items-center justify-center overflow-hidden bg-gray-50">
                        <img id="profilePreview" src="" alt="Profil"
                            class="object-contain w-full h-full hidden" />
                        <div id="profilePlaceholder" class="text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="12" cy="8" r="2" />
                                <path d="M21 21s-4-4-9-4-9 4-9 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input id="profileInput" type="file" name="profile_photo"
                            accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="text-sm" />
                        @error('profile_photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Maks 10 MB. Format: jpg, jpeg, png.</p>
                    </div>
                </div>
            </div>

            <!-- Kata Sandi & Konfirmasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2 text-start">
                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Kata Sandi
                    </label>
                    <input type="password" name="password" placeholder="Kata Sandi" autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all
                        @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 text-start">
                    <label class="flex items-center gap-2 text-xs font-bold text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Konfirmasi Kata Sandi
                    </label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi"
                        autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-400 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all">
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Terjadi kesalahan, silakan periksa kembali inputan Anda.</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tombol Daftar -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-blue-800 text-white font-bold py-3.5 rounded-full hover:bg-blue-900 transition-colors shadow-lg text-sm tracking-widest uppercase">
                    Daftar Akun
                </button>
            </div>

            <div class="text-center text-xs font-bold text-black">
                Sudah punya akun?
                <a href="{{ route('login-page') }}"
                    class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">Masuk</a>
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
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        placeholder?.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }

            setupPreview('ktpInput', 'ktpPreview', 'ktpPlaceholder');
            setupPreview('profileInput', 'profilePreview', 'profilePlaceholder');
        })();
    </script>
@endsection
