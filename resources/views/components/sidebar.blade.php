{{-- Component sidebar untuk reusability --}}
<div id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-white shadow-xl transition-all duration-300 ease-in-out">
    <div class="relative w-full h-full">
        <button id="buttonSidebar"
            class="absolute top-3 -right-5 bg-blue-800 text-white rounded-full p-2 transition-all duration-300 ease-in-out">
            <svg id="iconBtn" xmlns="http://www.w3.org/2000/svg"
                class="rotate-180 transition-all duration-300 ease-in-out" width="20" height="20"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </button>
        <div class="w-full h-full p-4">
            <div class="flex items-center gap-4">
                <img class="rounded-full w-10 h-10"
                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg" alt="">
                <div>
                    <h1 class="uppercase poppins font-bold text-2xl">Library</h1>
                    <p class="poppins text-xs">Perpustakaan Polibatam</p>
                </div>
            </div>
            <div class="mt-6 poppins">
                @php
                    function is_route_active($routeName, $activeClass = 'bg-blue-800 text-white')
                    {
                        return Route::currentRouteName() === $routeName ? $activeClass : '';
                    }
                @endphp
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ is_route_active('admin.dashboard') }} flex gap-4 items-center rounded-md p-3 relative group overflow-hidden text-black hover:text-white transition-all duration-300">
                            <span
                                class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="20" height="20"
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
                            class="{{ is_route_active('admin.buku') }} flex gap-4 items-center rounded-md p-3 relative group overflow-hidden text-black hover:text-white transition-all duration-300">
                            <span
                                class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-book-icon lucide-book">
                                <path
                                    d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                            </svg>
                            <span class="relative z-10">Buku</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.anggota.daftar') }}"
                            class="{{ request()->routeIs('admin.anggota.*') ? 'bg-blue-800 text-white' : '' }} flex gap-4 items-center rounded-md p-3 relative group overflow-hidden text-black hover:text-white transition-all duration-300">
                            <span
                                class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-users-icon lucide-users">
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
                            class="{{ request()->routeIs('admin.peminjaman*') ? 'bg-blue-800 text-white' : '' }} flex gap-4 items-center rounded-md p-3 relative group overflow-hidden text-black hover:text-white transition-all duration-300">
                            <span
                                class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 6h13" />
                                <path d="M8 12h13" />
                                <path d="M8 18h13" />
                                <path d="M3 6h.01" />
                                <path d="M3 12h.01" />
                                <path d="M3 18h.01" />
                            </svg>
                            <span class="relative z-10">Peminjaman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.data-terkendali.tipe-koleksi.index') }}"
                            class="{{ request()->routeIs('admin.data-terkendali*') ? 'bg-blue-800 text-white' : '' }} flex gap-4 items-center rounded-md p-3 relative group overflow-hidden text-black hover:text-white transition-all duration-300">
                            <span
                                class="absolute inset-0 w-0 bg-blue-800 group-hover:w-full transition-all duration-300 ease-in-out z-0"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-icon lucide-file">
                                <path
                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            </svg>
                            <span class="relative z-10">Data Terkendali</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
