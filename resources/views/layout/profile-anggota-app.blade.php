{{-- Layout atau template halaman utama --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Perpustakaan Politeknik Negeri Batam</title>

    @vite(['resources/css/app.css'])

    <style>
        .slider-thumb {
            pointer-events: none;
        }

        .slider-thumb::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            border: 2px solid #3b82f6;
            cursor: pointer;
            pointer-events: all;
        }

        .slider-thumb::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            border: 2px solid #3b82f6;
            cursor: pointer;
            pointer-events: all;
        }
    </style>
</head>

<body class="bg-gray-200 max-w-480 mx-auto overflow-x-hidden poppins antialiased">
    @include('components.navbar')
    {{-- section hero --}}
    @include('components.hero')
    <section class="profile">
        <div class="relative">
            <div
                class="absolute -top-16 left-0 grid grid-cols-1 lg:grid-cols-4 w-full gap-0 lg:gap-4 z-20 px-4 sm:px-6 md:px-12 lg:px-24">
                <div class="bg-white rounded-md shadow-md p-4 w-full mb-8 h-max">
                    <div class="flex flex-row lg:flex-col gap-6">

                        {{-- Foto --}}
                        <div class="flex flex-col gap-2 justify-center lg:block">
                            <img class="w-32 h-32 sm:w-40 sm:h-40 lg:w-56 lg:h-56 rounded-xl object-cover object-top shadow-md"
                                src="https://i.pinimg.com/736x/76/07/75/760775dfd783a04a3251e384b1a591eb.jpg"
                                alt="">
                            <div class="block lg:hidden">
                                <form action="" method="POST" class="w-full">
                                    @csrf
                                    @method('POST')

                                    <button
                                        class="bg-red-600 w-full rounded-md text-white flex gap-3 items-center justify-center px-4 py-3 hover:bg-red-700 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-log-out-icon lucide-log-out">
                                            <path d="m16 17 5-5-5-5" />
                                            <path d="M21 12H9" />
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        </svg>

                                        <span class="text-sm sm:text-base font-medium">
                                            Keluar
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Informasi --}}
                        <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">

                            <div class="col-span-2 lg:col-span-1">
                                <h6 class="text-sm text-slate-500">Nama Anggota</h6>
                                <h6 class="font-bold text-base sm:text-lg">
                                    Daniel Anju Adinov Batubara
                                </h6>
                            </div>

                            <div>
                                <h6 class="text-sm text-slate-500">ID Anggota</h6>
                                <h6 class="font-bold text-sm sm:text-lg">3312501025</h6>
                            </div>

                            <div>
                                <h6 class="text-sm text-slate-500">Jenis Keanggotaan</h6>
                                <h6 class="font-bold text-sm sm:text-lg">Mahasiswa</h6>
                            </div>

                            <div>
                                <h6 class="text-sm text-slate-500">Total Peminjaman</h6>
                                <h6 class="font-bold text-sm sm:text-lg">15 Peminjaman</h6>
                            </div>

                            <div>
                                <h6 class="text-sm text-slate-500">Total Judul Dipinjam</h6>
                                <h6 class="font-bold text-sm sm:text-lg">9 Judul Buku</h6>
                            </div>

                            {{-- Tombol --}}
                            <div class="hidden col-span-2 lg:col-span-1 lg:flex w-full items-end">
                                <form action="" method="POST" class="w-full">
                                    @csrf
                                    @method('POST')

                                    <button
                                        class="bg-red-600 w-full rounded-md text-white flex gap-3 items-center justify-center px-4 py-3 hover:bg-red-700 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-log-out-icon lucide-log-out">
                                            <path d="m16 17 5-5-5-5" />
                                            <path d="M21 12H9" />
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        </svg>

                                        <span class="text-sm sm:text-base font-medium">
                                            Keluar
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tabs Header -->
                <div class="col-span-3 bg-white rounded-md shadow-md w-full mb-8">

                    @include('components.submenu-profile')

                    <div class="w-full">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
<script>
    (function() {
        const MIN = 1950,
            MAX = 2025;
        const sliderDari = document.getElementById('sliderDari');
        const sliderKe = document.getElementById('sliderKe');
        const inputDari = document.getElementById('inputDari');
        const inputKe = document.getElementById('inputKe');
        const fill = document.getElementById('sliderFill');
        const errMsg = document.getElementById('errMsg');
        const panel = document.getElementById('panel');
        const chevron = document.getElementById('chevron');
        const toggleBtn = document.getElementById('toggleBtn');

        let isOpen = true;

        function pct(v) {
            return (v - MIN) / (MAX - MIN) * 100;
        }

        function updateFill() {
            const a = parseInt(sliderDari.value);
            const b = parseInt(sliderKe.value);
            fill.style.left = pct(a) + '%';
            fill.style.width = (pct(b) - pct(a)) + '%';
        }

        sliderDari.addEventListener('input', () => {
            let v = parseInt(sliderDari.value);
            if (v > parseInt(sliderKe.value)) {
                v = parseInt(sliderKe.value);
                sliderDari.value = v;
            }
            inputDari.value = v;
            errMsg.classList.add('hidden');
            updateFill();
        });

        sliderKe.addEventListener('input', () => {
            let v = parseInt(sliderKe.value);
            if (v < parseInt(sliderDari.value)) {
                v = parseInt(sliderDari.value);
                sliderKe.value = v;
            }
            inputKe.value = v;
            errMsg.classList.add('hidden');
            updateFill();
        });

        inputDari.addEventListener('input', () => {
            let v = Math.max(MIN, Math.min(MAX, parseInt(inputDari.value) || MIN));
            if (v > parseInt(inputKe.value)) {
                errMsg.classList.remove('hidden');
                return;
            }
            errMsg.classList.add('hidden');
            sliderDari.value = v;
            updateFill();
        });

        inputKe.addEventListener('input', () => {
            let v = Math.max(MIN, Math.min(MAX, parseInt(inputKe.value) || MAX));
            if (v < parseInt(inputDari.value)) {
                errMsg.classList.remove('hidden');
                return;
            }
            errMsg.classList.add('hidden');
            sliderKe.value = v;
            updateFill();
        });

        toggleBtn.addEventListener('click', () => {
            isOpen = !isOpen;
            panel.style.maxHeight = isOpen ? '200px' : '0px';
            panel.style.opacity = isOpen ? '1' : '0';
            chevron.style.transform = isOpen ? 'rotate(90deg)' : 'rotate(0deg)';
        });

        updateFill();
    })();
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sections = document.querySelectorAll(".filter-collapse");

        sections.forEach(section => {
            const button = section.querySelector(".collapse-btn");
            const content = section.querySelector(".collapse-content");
            const icon = section.querySelector(".collapse-icon");

            // default terbuka
            content.style.maxHeight = content.scrollHeight + "px";
            content.style.opacity = "1";
            icon.style.transform = "rotate(90deg)"; // kanan -> bawah

            button.addEventListener("click", function() {
                const isOpen = content.style.maxHeight !== "0px";

                if (isOpen) {
                    content.style.maxHeight = "0px";
                    content.style.opacity = "0";
                    icon.style.transform = "rotate(0deg)"; // kembali ke kanan
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                    content.style.opacity = "1";
                    icon.style.transform = "rotate(90deg)"; // ke bawah
                }
            });
        });
    });
</script>

</html>
