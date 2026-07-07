    <div id="export-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                <!-- Modal header -->
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <h3 class="text-lg font-medium text-heading">
                        Export Laporan
                    </h3>
                    <button type="button"
                        class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="export-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="space-y-4 md:space-y-6 pt-4 md:pt-6">
                    <form id="form-export" action="{{ route('admin.export.laporan') }}" method="POST"
                        class="space-y-4">
                        @method('POST')
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Jenis Laporan -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Jenis Laporan
                                </label>

                                <select name="jenis_laporan" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-600">
                                    <option value="transaksi">Laporan Transaksi</option>
                                    <option value="reservasi">Laporan Reservasi</option>
                                    <option value="anggota">Laporan Anggota</option>
                                    <option value="buku">Laporan Koleksi Buku</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Rentang Data
                                </label>

                                <select id="jenis-filter" name="jenis_filter" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                                    <option value="semua">Seluruh Data</option>
                                    <option value="periode">Berdasarkan Periode</option>
                                </select>
                            </div>
                            <div id="filter-tanggal" class="hidden col-span-2">
                                <div class="grid md:grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">
                                            Tanggal Awal
                                        </label>

                                        <input type="date" id="tanggal_awal" name="tanggal_awal"
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2">

                                        <p id="error-tanggal-awal" class="hidden text-sm text-red-600 mt-1"></p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">
                                            Tanggal Akhir
                                        </label>

                                        <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2">

                                        <p id="error-tanggal-akhir" class="hidden text-sm text-red-600 mt-1"></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border-t border-default space-x-4 pt-4 md:pt-5">
                            <button type="submit"
                                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Export
                                Laporan</button>
                            <button data-modal-hide="export-modal" type="button"
                                class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Batalkan</button>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        const form = document.getElementById('form-export');

                        const filter = document.getElementById('jenis-filter');
                        const tanggal = document.getElementById('filter-tanggal');

                        const tanggalAwal = document.getElementById('tanggal_awal');
                        const tanggalAkhir = document.getElementById('tanggal_akhir');

                        const errorAwal = document.getElementById('error-tanggal-awal');
                        const errorAkhir = document.getElementById('error-tanggal-akhir');

                        function clearError() {
                            errorAwal.textContent = '';
                            errorAkhir.textContent = '';

                            errorAwal.classList.add('hidden');
                            errorAkhir.classList.add('hidden');

                            tanggalAwal.classList.remove('border-red-500');
                            tanggalAkhir.classList.remove('border-red-500');
                        }

                        function toggleTanggal() {
                            if (filter.value === 'periode') {
                                tanggal.classList.remove('hidden');
                            } else {
                                tanggal.classList.add('hidden');

                                tanggalAwal.value = '';
                                tanggalAkhir.value = '';

                                clearError();
                            }
                        }

                        toggleTanggal();

                        filter.addEventListener('change', toggleTanggal);

                        form.addEventListener('submit', function(e) {

                            clearError();

                            let valid = true;

                            if (filter.value === 'periode') {

                                if (!tanggalAwal.value) {
                                    errorAwal.textContent = 'Tanggal awal wajib diisi.';
                                    errorAwal.classList.remove('hidden');
                                    tanggalAwal.classList.add('border-red-500');
                                    valid = false;
                                }

                                if (!tanggalAkhir.value) {
                                    errorAkhir.textContent = 'Tanggal akhir wajib diisi.';
                                    errorAkhir.classList.remove('hidden');
                                    tanggalAkhir.classList.add('border-red-500');
                                    valid = false;
                                }

                                if (
                                    tanggalAwal.value &&
                                    tanggalAkhir.value &&
                                    tanggalAwal.value > tanggalAkhir.value
                                ) {
                                    errorAkhir.textContent = 'Tanggal akhir harus sama atau setelah tanggal awal.';
                                    errorAkhir.classList.remove('hidden');
                                    tanggalAkhir.classList.add('border-red-500');
                                    valid = false;
                                }
                            }

                            if (!valid) {
                                e.preventDefault();
                            }

                        });

                    });
                </script>
            </div>
        </div>
    </div>
