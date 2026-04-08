{{-- Component footer untuk reusability --}}
<footer class="w-full bg-white">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-8 py-12">
        <div class="space-y-8">
            <div class="flex items-center gap-4">
                <img class="w-10 h-10"
                    src="https://upload.wikimedia.org/wikipedia/id/thumb/2/2c/Politeknik_Negeri_Batam.png/1280px-Politeknik_Negeri_Batam.png"
                    alt="">
                <div>
                    <h1 class="uppercase font-bold text-md">Library</h1>
                    <p class="text-xs">Perpustakaan Polibatam</p>
                </div>
            </div>
            <p class="text-lg">Website ini merupakan website perpustakaan Politeknik Negeri Batam untuk melihat dan
                meminjam buku</p>
            <div>
                <ul class="flex items-center gap-4 text-white">
                    <li class="bg-red-600 w-10 aspect-square p-2 rounded-lg">
                        <a href="" class="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-brand-youtube">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M18 3a5 5 0 0 1 5 5v8a5 5 0 0 1 -5 5h-12a5 5 0 0 1 -5 -5v-8a5 5 0 0 1 5 -5zm-9 6v6a1 1 0 0 0 1.514 .857l5 -3a1 1 0 0 0 0 -1.714l-5 -3a1 1 0 0 0 -1.514 .857z" />
                            </svg>
                        </a>
                    </li>
                    <li class="bg-pink-600 w-10 aspect-square p-2 rounded-lg">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4l0 -8" />
                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                <path d="M16.5 7.5v.01" />
                            </svg>
                        </a>
                    </li>
                    <li class="bg-blue-900 w-10 aspect-square p-2 rounded-lg">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-brand-facebook">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M18 2a1 1 0 0 1 .993 .883l.007 .117v4a1 1 0 0 1 -.883 .993l-.117 .007h-3v1h3a1 1 0 0 1 .991 1.131l-.02 .112l-1 4a1 1 0 0 1 -.858 .75l-.113 .007h-2v6a1 1 0 0 1 -.883 .993l-.117 .007h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-6h-2a1 1 0 0 1 -.993 -.883l-.007 -.117v-4a1 1 0 0 1 .883 -.993l.117 -.007h2v-1a6 6 0 0 1 5.775 -5.996l.225 -.004h3z" />
                            </svg>
                        </a>
                    </li>
                    <li class="bg-cyan-600 w-10 aspect-square p-2 rounded-lg">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="space-y-8">
            <h2 class="text-xl font-bold">Link</h2>
            <ul>
                <li class="w-full py-2 rounded-md hover:underline text-lg transition-all duration-150 ease-in-out"><a
                        href="{{ route('home-page') }}">Beranda</a></li>
                <li class="w-full py-2 rounded-md hover:underline text-lg transition-all duration-150 ease-in-out"><a
                        href="{{ route('home-page') }}">Cari Buku</a></li>
                <li class="w-full py-2 rounded-md hover:underline text-lg transition-all duration-150 ease-in-out"><a
                        href="{{ route('home-page') }}">Tentang</a></li>
                <li class="w-full py-2 rounded-md hover:underline text-lg transition-all duration-150 ease-in-out"><a
                        href="{{ route('home-page') }}">Hubungi Kami</a></li>
                <li class="w-full py-2 rounded-md hover:underline text-lg transition-all duration-150 ease-in-out">
                    <a href="{{ route('home-page') }}">Daftar</a>
                </li>
                <li class="w-full py-2 rounded-md hover:underline text-lg transition-all duration-150 ease-in-out">
                    <a href="{{ route('login-page') }}">Masuk</a>
                </li>
            </ul>
        </div>
        <div class="space-y-8">
            <h2 class="text-xl font-bold">Hubungi Kami</h2>
            <ul>
                <li class="w-full py-2 rounded-md text-lg flex flex-row items-start justify-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 aspect-square" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-phone-icon lucide-phone">
                        <path
                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                    </svg>
                    <a class="transition-all duration-150 ease-in-out hover:underline"
                        href="{{ route('home-page') }}">+62-778-469858</a>
                </li>
                <li class="w-full py-2 rounded-md text-lg flex flex-row items-start justify-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 aspect-square" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-mail-icon lucide-mail">
                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                    </svg>
                    <a class="transition-all duration-150 ease-in-out hover:underline"
                        href="{{ route('home-page') }}">perpus@polibatam.ac.id </a>
                </li>
                <li class="w-full py-2 rounded-md text-lg flex flex-row items-start justify-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 aspect-square" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-map-pinned-icon lucide-map-pinned">
                        <path
                            d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0" />
                        <circle cx="12" cy="8" r="2" />
                        <path
                            d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712" />
                    </svg>
                    <a class="transition-all duration-150 ease-in-out hover:underline"
                        href="{{ route('home-page') }}">Jl. Ahmad
                        Yani, Batam Kota, Kota Batam, Kep. Riau.Indonesia</a>
                </li>
            </ul>
        </div>
        <div>
            <iframe class="border border-gray-400 rounded-lg aspect-video w-full"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d997.2644827729761!2d104.04850971886985!3d1.1186286865586696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d989aa75af33bd%3A0xe426a7c17236e2de!2sPerpustakaan%20Polibatam!5e0!3m2!1sid!2sid!4v1775569662493!5m2!1sid!2sid"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</footer>
