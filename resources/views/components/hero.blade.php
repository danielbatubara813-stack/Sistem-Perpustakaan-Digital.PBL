    {{-- section hero --}}
    <section id="hero">
        <div class="w-full h-screen max-h-270 relative">
            <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-20">
            </div>
            <img class="absolute top-0 left-0 w-full h-full object-cover z-10"
                src="{{ asset('static/backgroundHero.jpg') }}" alt="">
            <div
                class="absolute top-1/2 left-1/2 transform -translate-1/2 z-20 flex flex-col items-center justify-center gap-16">
                <h1 class="text-white poppins text-4xl uppercase font-bold">Selamat Datang</h1>
                <form action="" method="POST" class="flex items-center gap-2">
                    <input type="text" class="bg-white p-2 md:p-4 rounded-md w-sm md:w-md lg:w-lg focus:outline-0"
                        placeholder="Cari Judul Buku...">
                    <button class="bg-blue-800 text-white p-2 md:p-4 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>
