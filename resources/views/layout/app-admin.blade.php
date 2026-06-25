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
    @include('components.export-modal')
</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
{{-- Script buka tutup sidebar --}}
@vite(['resources/js/openCloseSidebar.js', 'resources/js/selectDataAndConfirmDelete.js'])

@if (Route::is('admin.dashboard'))
    {{-- Script untuk grafik chart pada dashboard admin --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statusAnggota = @json($statusAnggota);

        new Chart(document.getElementById('anggotaChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusAnggota),
                datasets: [{
                    data: Object.values(statusAnggota),
                    backgroundColor: [
                        '#2563EB',
                        '#3B82F6',
                        '#93C5FD',
                        '#BFDBFE'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            generateLabels(chart) {
                                const data = chart.data;

                                return data.labels.map((label, index) => ({
                                    text: `${label} (${data.datasets[0].data[index]})`,
                                    fillStyle: data.datasets[0].backgroundColor[index],
                                    strokeStyle: data.datasets[0].backgroundColor[index],
                                    lineWidth: 0,
                                    hidden: false,
                                    index
                                }));
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const statusPeminjaman = @json($statusPeminjaman);

        new Chart(document.getElementById('peminjamanChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusPeminjaman),
                datasets: [{
                    data: Object.values(statusPeminjaman),
                    backgroundColor: [
                        '#EA580C',
                        '#F97316',
                        '#FB923C',
                        '#FDBA74'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            generateLabels(chart) {
                                const data = chart.data;

                                return data.labels.map((label, index) => ({
                                    text: `${label} (${data.datasets[0].data[index]})`,
                                    fillStyle: data.datasets[0].backgroundColor[index],
                                    strokeStyle: data.datasets[0].backgroundColor[index],
                                    lineWidth: 0,
                                    hidden: false,
                                    index
                                }));
                            }
                        }
                    }
                }
            }
        });
    </script>
@endif

</html>
