{{-- Tamplate atau layout halaman admin --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Perpustakaan Politeknik Negeri Batam</title>

    {{-- akses tailwind offline yang telah dinstall dan font dari google font --}}
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-200 max-w-480 mx-auto overflow-x-hidden poppins antialiased">
    {{-- component sidebar dari folder (components.sidebar) --}}
    @include('components.sidebar')
    {{-- content utama --}}
    <div id="contentSection" class="w-full lg:w-[calc(100%-16rem)] ml-0 lg:ml-64 transition-all duration-300">
        <div class="p-6">
            <x-header-admin :title="$title ?? 'Dashboard'" :description="$description ?? 'Default description'" />
            @yield('content')
        </div>
    </div>

    @include('components.alert')
    @include('components.confirm-delete')
</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
{{-- Script buka tutup sidebar --}}
@vite(['resources/js/openCloseSidebar.js', 'resources/js/selectDataAndConfirmDelete.js'])

@if (Route::is('admin.dashboard'))
    {{-- Script untuk grafik chart pada dashboard admin --}}
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
@endif

</html>
