{{-- isi content dari halaman dashboard --}}
@extends('layout.app-admin')

@section('content')
    <div class="p-6 poppins">
        <div class="mb-4 flex items-center justify-between bg-white rounded-lg p-4">
            <h1 class="font-bold text-3xl">Dashboard</h1>
            <div class="font-medium text-gray-900 flex items-center gap-4">
                <img class="rounded-full w-8 h-8"
                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg" alt="">
                <span>Admin</span>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-lg p-6 flex items-start justify-between">
                    <div class=" space-y-4">
                        <h4 class="text-sm font-semibold">Jumlah Buku</h4>
                        <h1 class="font-bold text-5xl">160</h1>
                        <p class="text-xs text-gray-400">sejak bulan lalu</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-book-text-icon lucide-book-text">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        <path d="M8 11h8" />
                        <path d="M8 7h6" />
                    </svg>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 flex items-start justify-between">
                    <div class=" space-y-4">
                        <h4 class="text-sm font-semibold">Jumlah Buku Dipinjam</h4>
                        <h1 class="font-bold text-5xl">70</h1>
                        <p class="text-xs text-gray-400">sejak bulan lalu</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-book-text-icon lucide-book-text">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        <path d="M8 11h8" />
                        <path d="M8 7h6" />
                    </svg>
                </div>
                <div class="col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <h4 class="text-sm font-bold">Buku Dipinjam</h4>
                    <div class="flex mt-4 gap-2 overflow-scroll scrollbar-hide py-2">
                        @for ($i = 0; $i < 5; $i++)
                            <img class="w-28 shadow rounded-md"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjo6WFkfgUbfKWtLBzyEqbbtt7hJBQTMC2qjGCw0vpl1fc4COz4KWdDbos3pUu5L5Upl2uPm714L2eQas1eNQh516WgJrxyeVqLri4dJ0&s=10"
                                alt="">
                        @endfor
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold">Anggota</h4>
                        <div>
                            <h1 class="font-bold text-5xl">260</h1>
                            <p class="text-xs text-gray-400">sejak bulan lalu</p>
                        </div>
                    </div>
                    <canvas class="mt-6" id="anggotaChart"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 ">
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold">Peminjaman</h4>
                        <div>
                            <h1 class="font-bold text-5xl">570</h1>
                            <p class="text-xs text-gray-400">sejak bulan lalu</p>
                        </div>
                    </div>
                    <canvas class="mt-6" id="peminjamanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg mt-4 shadow-lg-lg">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-lg uppercase">Data Peminjaman Terbaru</h2>
                <button onclick="window.location.reload()"
                    class="bg-gray-300 text-gray-500 hover:bg-blue-600 rounded-full hover:text-white p-2 transition-all duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-refresh-ccw-icon lucide-refresh-ccw">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                        <path d="M16 16h5v5" />
                    </svg>
                </button>
            </div>
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                        <tr>
                            <th class="px-6 py-3">Anggota</th>
                            <th class="px-6 py-3">Nomor Anggota</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Jenis Keanggotaan</th>
                            <th class="px-6 py-3">Jumlah Buku</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                <img class="rounded-full w-8 h-8"
                                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg"
                                    alt="">
                                <span>John Doe</span>
                            </td>
                            <td class="px-6 py-4">08123456789</td>
                            <td class="px-6 py-4">johndoe08@gmail.com</td>
                            <td class="px-6 py-4">Mahasiswa</td>
                            <td class="px-6 py-4">2</td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-xs bg-green-600/10 text-green-600 pl-2 pr-4 py-2 rounded-full flex items-center gap-2 w-max">
                                    <span
                                        class="bg-green-600 rounded-full text-white w-6 h-6 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check-icon lucide-check">
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>
                                    </span>
                                    Sudah Dikembalikan
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                <img class="rounded-full w-8 h-8"
                                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg"
                                    alt="">
                                <span>Will Smith</span>
                            </td>
                            <td class="px-6 py-4">083124112343</td>
                            <td class="px-6 py-4">willsmith808@gmail.com</td>
                            <td class="px-6 py-4">Mahasiswa</td>
                            <td class="px-6 py-4">2</td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-xs bg-blue-600/10 text-blue-600 pl-2 pr-4 py-2 rounded-full flex items-center gap-2 w-max">
                                    <span
                                        class="bg-blue-600 rounded-full text-white w-6 h-6 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check-icon lucide-check">
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>
                                    </span>
                                    Masa Peminjaman
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                <img class="rounded-full w-8 h-8"
                                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg"
                                    alt="">
                                <span>Sarah Milestone</span>
                            </td>
                            <td class="px-6 py-4">08983741234</td>
                            <td class="px-6 py-4">sarahmilestone28@gmail.com</td>
                            <td class="px-6 py-4">Dosen</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-xs bg-yellow-600/10 text-yellow-600 pl-2 pr-4 py-2 rounded-full flex items-center gap-2 w-max">
                                    <span
                                        class="bg-yellow-600 rounded-full text-white w-6 h-6 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-octagon-alert-icon lucide-octagon-alert">
                                            <path d="M12 16h.01" />
                                            <path d="M12 8v4" />
                                            <path
                                                d="M15.312 2a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586l-4.688-4.688A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2z" />
                                        </svg>
                                    </span>
                                    Terlambat
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-4">
                                <img class="rounded-full w-8 h-8"
                                    src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg"
                                    alt="">
                                <span>Keichi Yamato</span>
                            </td>
                            <td class="px-6 py-4">085123141232</td>
                            <td class="px-6 py-4">yamatokeichi1108@gmail.com</td>
                            <td class="px-6 py-4">Mahasiswa</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-xs bg-red-600/10 text-red-600 pl-2 pr-4 py-2 rounded-full flex items-center gap-2 w-max">
                                    <span
                                        class="bg-red-600 rounded-full text-white w-6 h-6 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-x-icon lucide-x">
                                            <path d="M18 6 6 18" />
                                            <path d="m6 6 12 12" />
                                        </svg>
                                    </span>
                                    Terlambat
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
