<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library | Perpustakaan Politeknik Negeri Batam</title>

    @vite(['resources/css/app.css', 'resources/css/font.css'])
</head>

<body class="bg-gray-200 max-w-480 mx-auto overflow-x-hidden">
    @include('components.sidebar')
    <div id="contentSection" class="w-full lg:w-[calc(100%-16rem)] ml-0 lg:ml-64 transition-all duration-300">
        @yield('content')
    </div>
</body>
<script>
    const sidebar = document.getElementById("sidebar");
    const button = document.getElementById("buttonSidebar");
    const content = document.getElementById("contentSection");
    const icon = document.getElementById("iconBtn");

    let isOpen = true;

    button.addEventListener("click", () => {

        if (isOpen) {
            sidebar.classList.replace("left-0", "-left-64");

            content.classList.remove("lg:ml-64", "lg:w-[calc(100%-16rem)]");
            content.classList.add("ml-0", "w-full");

            button.classList.add('-right-15')
            button.classList.remove('-right-5')

            icon.classList.remove('rotate-180')

        } else {
            sidebar.classList.replace("-left-64", "left-0");

            content.classList.remove("ml-0", "w-full");
            content.classList.add("lg:ml-64", "lg:w-[calc(100%-16rem)]");
            button.classList.remove('-right-15')
            button.classList.add('-right-5')

            icon.classList.add('rotate-180')
        }

        isOpen = !isOpen;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxAnggota = document.getElementById('anggotaChart');

    const anggotaBaru = 200
    const anggotaInactive = 500
    const anggotaPerpanjang = 200

    const data = {
        labels: [
            'Baru',
            'Perpanjang',
            'Tidak Aktif',
        ],
        datasets: [{
            label: 'Keanggotaan',
            data: [anggotaBaru, anggotaPerpanjang, anggotaInactive],
            backgroundColor: [
                'rgb(37 99 235)',
                'rgb(59 130 246)',
                'rgb(96 165 250)'
            ],
            hoverOffset: 4
        }]
    };

    new Chart(ctxAnggota, {
        type: 'doughnut',
        data: data,
    });
</script>

<script>
    const ctxPeminjaman = document.getElementById('peminjamanChart');

    const peminjamanDikembalikan = 200
    const peminjamanProses = 500
    const peminjamanTerlambat = 200
    const peminjamanHilang = 200

    const data2 = {
        labels: [
            'Dikembalikan',
            'Proses',
            'Terlambat',
            'Hilang',
        ],
        datasets: [{
            label: 'Jumlah Peminjaman',
            data: [peminjamanDikembalikan, peminjamanProses, peminjamanTerlambat, peminjamanHilang],
            backgroundColor: [
                'rgb(234 88 12)',
                'rgb(249 115 22)',
                'rgb(251 146 60)',
                'rgb(253 186 116)'
            ],
            hoverOffset: 4
        }]
    };

    new Chart(ctxPeminjaman, {
        type: 'doughnut',
        data: data2,
    });
</script>

</html>
