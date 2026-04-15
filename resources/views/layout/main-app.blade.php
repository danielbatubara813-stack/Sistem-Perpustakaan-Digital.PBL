{{-- Layout atau template halaman utama --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library | Perpustakaan Politeknik Negeri Batam</title>

    @vite(['resources/css/app.css', 'resources/css/font.css'])

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

<body class="bg-gray-200 max-w-480 mx-auto overflow-x-hidden poppins">
    @include('components.navbar')
    @if (Route::is('home-page', 'cari-buku-page'))
        @include('components.hero')
    @endif
    @yield('content')
    @include('components.footer')
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
