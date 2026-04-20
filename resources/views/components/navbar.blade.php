{{-- Component navbar untuk reusability --}}
<nav class="fixed top-0 left-0 w-full z-30 shadow-md"
    style="background: linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 60%,#2563eb 100%);">

    {{-- Top bar --}}
    <div class="w-full px-6 py-3 flex items-center justify-between">

        {{-- Brand --}}
        <div class="flex items-center gap-3">
            <img class="w-10 h-10 bg-white rounded-md p-1"
                src="https://upload.wikimedia.org/wikipedia/id/thumb/2/2c/Politeknik_Negeri_Batam.png/1280px-Politeknik_Negeri_Batam.png"
                alt="Logo Polibatam" />
            <div class="leading-tight">
                <h1 class="uppercase poppins font-bold text-lg lg:text-2xl text-white tracking-wide">Library</h1>
                <p class="poppins text-xs text-blue-200">Perpustakaan Polibatam</p>
            </div>
        </div>

        {{-- Desktop links --}}
        <ul class="hidden lg:flex items-center gap-7 poppins font-semibold text-sm text-white">
            <li><a href="{{ route('home-page') }}"
                    class="hover:text-blue-200 transition-colors duration-200">Beranda</a></li>
            <li><a href="{{ route('cari-buku-page') }}" class="hover:text-blue-200 transition-colors duration-200">Cari
                    Buku</a></li>
            <li><a href="{{ route('home-page') }}"
                    class="hover:text-blue-200 transition-colors duration-200">Tentang</a></li>
            <li><a href="{{ route('hubungi-kami-page') }}"
                    class="hover:text-blue-200 transition-colors duration-200">Hubungi
                    Kami</a></li>
            <li>
                <a href="{{ route('register-page') }}"
                    class="border border-white/60 text-white px-4 py-1.5 rounded-full text-sm font-semibold hover:bg-white hover:text-blue-800 transition-all duration-200">
                    Daftar
                </a>
            </li>
            <li>
                <a href="{{ route('login-page') }}"
                    class="bg-white text-blue-800 px-4 py-1.5 rounded-full text-sm font-bold hover:bg-blue-100 transition-all duration-200 shadow">
                    Masuk
                </a>
            </li>
        </ul>

        {{-- Hamburger button (mobile) --}}
        <button id="menu-btn"
            class="block lg:hidden p-2 rounded-lg border border-white/30 hover:bg-white/10 transition-colors duration-200"
            aria-label="Toggle menu" aria-expanded="false">
            <svg id="menu-icon" width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="white"
                stroke-width="2.2" stroke-linecap="round">
                <line id="bar-top" class="transition-all duration-300" x1="2" y1="5" x2="20"
                    y2="5" />
                <line id="bar-mid" class="transition-all duration-200" x1="2" y1="11" x2="20"
                    y2="11" />
                <line id="bar-bot" class="transition-all duration-300" x1="2" y1="17" x2="20"
                    y2="17" />
            </svg>
        </button>
    </div>

    {{-- Mobile dropdown --}}
    <div id="mobile-menu"
        class="bg-white overflow-hidden max-h-0 opacity-0 transition-all duration-300 ease-in-out lg:hidden">
        <ul class="flex flex-col gap-1 px-4 py-3 poppins text-sm font-semibold text-gray-700">
            <li>
                <a href="{{ route('home-page') }}"
                    class="block py-2.5 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-150">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('cari-buku-page') }}"
                    class="block py-2.5 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-150">
                    Cari Buku
                </a>
            </li>
            <li>
                <a href="{{ route('home-page') }}"
                    class="block py-2.5 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-150">
                    Tentang
                </a>
            </li>
            <li>
                <a href="{{ route('hubungi-kami-page') }}"
                    class="block py-2.5 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-150">
                    Hubungi Kami
                </a>
            </li>
            <li class="my-1 h-px bg-gray-200 mx-2"></li>
            <li class="flex gap-3 px-2 pb-2 pt-1">
                <a href="{{ route('register-page') }}"
                    class="flex-1 text-center py-2 rounded-full border-2 border-blue-700 text-blue-700 font-bold hover:bg-blue-700 hover:text-white transition-all duration-200">
                    Daftar
                </a>
                <a href="{{ route('login-page') }}"
                    class="flex-1 text-center py-2 rounded-full bg-blue-700 text-white font-bold hover:bg-blue-800 transition-all duration-200 shadow">
                    Masuk
                </a>
            </li>
        </ul>
    </div>
</nav>

{{-- script untuk buka tutup navbar pada mobile view --}}
<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const barTop = document.getElementById('bar-top');
    const barMid = document.getElementById('bar-mid');
    const barBot = document.getElementById('bar-bot');

    let isOpen = false;

    menuBtn.addEventListener('click', () => {
        isOpen = !isOpen;
        menuBtn.setAttribute('aria-expanded', isOpen);

        if (isOpen) {
            // Open: expand to full content height
            mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
            mobileMenu.classList.remove('opacity-0');
            mobileMenu.classList.add('opacity-100');

            // Hamburger → X
            barTop.setAttribute('style', 'transform: translateY(6px) rotate(45deg); transform-origin: center;');
            barMid.setAttribute('style', 'opacity: 0; transform: scaleX(0);');
            barBot.setAttribute('style',
                'transform: translateY(-6px) rotate(-45deg); transform-origin: center;');
        } else {
            // Close: collapse back
            mobileMenu.style.maxHeight = '0px';
            mobileMenu.classList.remove('opacity-100');
            mobileMenu.classList.add('opacity-0');

            // X → Hamburger
            barTop.setAttribute('style', '');
            barMid.setAttribute('style', '');
            barBot.setAttribute('style', '');
        }
    });

    // Close menu when any mobile link is clicked
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (!isOpen) return;
            isOpen = false;
            menuBtn.setAttribute('aria-expanded', false);
            mobileMenu.style.maxHeight = '0px';
            mobileMenu.classList.remove('opacity-100');
            mobileMenu.classList.add('opacity-0');
            barTop.setAttribute('style', '');
            barMid.setAttribute('style', '');
            barBot.setAttribute('style', '');
        });
    });
</script>
