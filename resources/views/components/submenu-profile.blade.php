<!-- Tabs Header -->
<div class="flex border-b border-gray-300">
    <a href="{{ route('profile.reservasi-page') }}"
        class="px-6 py-4 text-sm font-medium border-b-2 
            {{ request()->routeIs('profile.reservasi-page') ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500' }}">
        Reservasi
    </a>
    <a href="{{ route('profile.daftar-reservasi-page') }}"
        class="px-6 py-4 text-sm font-medium border-b-2 
            {{ request()->routeIs('profile.daftar-reservasi-page') ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500' }}">
        Daftar Reservasi
    </a>
    <a href="{{ route('profile.peminjaman-sekarang-page') }}"
        class="px-6 py-4 text-sm font-medium border-b-2 
            {{ request()->routeIs('profile.peminjaman-sekarang-page') ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500' }}">
        Peminjaman Terkini
    </a>

    <a href="{{ route('profile.sejarah-peminjaman-page') }}"
        class="px-6 py-4 text-sm font-medium border-b-2 
            {{ request()->routeIs('profile.sejarah-peminjaman-page') ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500' }}">
        Sejarah Peminjaman
    </a>

    <a href="{{ route('profile.akun-saya-page') }}"
        class="px-6 py-4 text-sm font-medium border-b-2 
            {{ request()->routeIs('profile.akun-saya-page') ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500' }}">
        Akun Saya
    </a>
</div>
