{{-- Component sidebar untuk reusability --}}
<div id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-white shadow-xl transition-all duration-300 ease-in-out">
    <div class="relative w-full h-full flex flex-col">

        {{-- Toggle Button --}}
        <button id="buttonSidebar"
            class="absolute top-4 -right-5 bg-blue-800 text-white rounded-full p-2 transition-all duration-300 ease-in-out z-10">
            <svg id="iconBtn" xmlns="http://www.w3.org/2000/svg"
                class="rotate-180 transition-all duration-300 ease-in-out" width="18" height="18"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </button>

        {{-- Header --}}
        <div class="flex items-center gap-3 p-5 pb-4">
            <img class="rounded-full w-10 h-10"
                src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg" alt="">
            <div>
                <h1 class="poppins font-bold text-base tracking-wide uppercase leading-tight">Library</h1>
                <p class="poppins text-xs text-gray-500">Perpustakaan Polibatam</p>
            </div>
        </div>

        {{-- Divider --}}
        <div class="mx-4 border-t border-gray-200"></div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 poppins overflow-y-auto">
            @php
                function is_route_active($routeName)
                {
                    return Route::currentRouteName() === $routeName
                        ? 'bg-blue-800 text-white font-semibold'
                        : 'text-gray-700';
                }
            @endphp
            <ul class="space-y-1 text-sm">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ is_route_active('admin.dashboard') }} flex gap-3 items-center rounded-lg px-3 py-2.5 relative group overflow-hidden hover:text-white transition-all duration-300">
                        <span class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1" />
                            <rect width="7" height="5" x="14" y="3" rx="1" />
                            <rect width="7" height="9" x="14" y="12" rx="1" />
                            <rect width="7" height="5" x="3" y="16" rx="1" />
                        </svg>
                        <span class="relative z-10">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.buku') }}"
                        class="{{ is_route_active('admin.buku') }} flex gap-3 items-center rounded-lg px-3 py-2.5 relative group overflow-hidden hover:text-white transition-all duration-300">
                        <span class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        </svg>
                        <span class="relative z-10">Daftar Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.anggota.daftar') }}"
                        class="{{ request()->routeIs('admin.anggota.*') ? 'bg-blue-800 text-white font-semibold' : 'text-gray-700' }} flex gap-3 items-center rounded-lg px-3 py-2.5 relative group overflow-hidden hover:text-white transition-all duration-300">
                        <span class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        <span class="relative z-10">Anggota</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.peminjaman') }}"
                        class="{{ request()->routeIs('admin.peminjaman*') ? 'bg-blue-800 text-white font-semibold' : 'text-gray-700' }} flex gap-3 items-center rounded-lg px-3 py-2.5 relative group overflow-hidden hover:text-white transition-all duration-300">
                        <span class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 6h13" /><path d="M8 12h13" /><path d="M8 18h13" />
                            <path d="M3 6h.01" /><path d="M3 12h.01" /><path d="M3 18h.01" />
                        </svg>
                        <span class="relative z-10">Peminjaman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengembalian') }}"
                        class="{{ request()->routeIs('admin.pengembalian*') ? 'bg-blue-800 text-white font-semibold' : 'text-gray-700' }} flex gap-3 items-center rounded-lg px-3 py-2.5 relative group overflow-hidden hover:text-white transition-all duration-300">
                        <span class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H7" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>
                        <span class="relative z-10">Pengembalian</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.data-terkendali.tipe-koleksi.index') }}"
                        class="{{ request()->routeIs('admin.data-terkendali*') ? 'bg-blue-800 text-white font-semibold' : 'text-gray-700' }} flex gap-3 items-center rounded-lg px-3 py-2.5 relative group overflow-hidden hover:text-white transition-all duration-300">
                        <span class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        </svg>
                        <span class="relative z-10">Data Terkendali</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Divider --}}
        <div class="mx-4 border-t border-gray-200"></div>

        {{-- Logout --}}
        <div class="p-3 poppins">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ url('admin/login') }}">
                <button type="submit"
                    class="w-full flex gap-3 items-center rounded-lg px-3 py-2.5 text-sm text-gray-700
                           bg-gray-200 relative group overflow-hidden hover:text-white transition-all duration-300">
                    <span class="absolute inset-0 w-0 bg-red-600 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="18" height="18"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span class="relative z-10">Logout</span>
                </button>
            </form>
        </div>

    </div>
</div>
