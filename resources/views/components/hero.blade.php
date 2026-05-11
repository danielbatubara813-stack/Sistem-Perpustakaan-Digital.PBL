@php
    $isProfile = request()->routeIs('profile.*');
@endphp

@if ($isProfile)
    {{-- Hero kecil --}}
    <section id="hero">
        <div class="w-full h-64 relative">
            <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-10">
            </div>
            <img class="absolute top-0 left-0 w-full h-full object-cover z-0"
                src="{{ asset('static/backgroundHero.jpg') }}" alt="">
        </div>
    </section>
@else
    {{-- section hero --}}
    <section id="hero">
        <div class="relative w-full min-h-screen overflow-hidden">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-linear-to-l from-black/80 via-black/50 to-black/80 z-20">
            </div>

            {{-- Background --}}
            <img class="absolute inset-0 w-full h-full object-cover z-10" src="{{ asset('static/backgroundHero.jpg') }}"
                alt="Background Hero">

            {{-- Content --}}
            <div
                class="relative z-20 flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8 text-center">

                {{-- Title --}}
                <div class="space-y-4 max-w-3xl">

                    <h1
                        class="text-white poppins uppercase font-bold leading-tight
                    text-3xl sm:text-5xl lg:text-6xl">
                        Selamat Datang
                    </h1>

                </div>

                {{-- Search --}}
                <form action="" method="POST" class="mt-8 w-full max-w-2xl">

                    <div class="flex items-center gap-2">

                        <input type="text" placeholder="Cari Judul Buku..."
                            class="flex-1 bg-white px-4 py-3 text-sm sm:text-base rounded-xl  focus:outline-none">

                        <button type="submit"
                            class="shrink-0 bg-blue-800 hover:bg-blue-900 text-white p-3 sm:p-4 rounded-lg transition-all duration-300">

                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-search">
                                <path d="m21 21-4.34-4.34" />
                                <circle cx="11" cy="11" r="8" />
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endif
