@extends('layout.app-admin')

@section('content')
    <div class="p-6 poppins">
        <div class="mb-4 flex items-center justify-between bg-white rounded-lg p-4">
            <h1 class="font-bold text-3xl">Anggota</h1>
            <div class="font-medium text-gray-900 flex items-center gap-4">
                <img class="rounded-full w-8 h-8" src="https://i.pinimg.com/736x/1d/ec/e2/1dece2c8357bdd7cee3b15036344faf5.jpg" alt="">
                <span>Admin</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
            <div class="mb-4 flex items-center justify-between">
                <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                    <a id="daftarTab" href="{{ route('admin.anggota') }}" class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Daftar Anggota <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span></a>
                    <a href="{{ route('admin.anggota.jenis') }}" class="px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.jenis*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Jenis Keanggotaan</a>
                </div>
                <div>
                    <a href="{{ route('admin.anggota.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Tambah Anggota
                    </a>
                </div>
            </div>

            <div class="grid gap-3 grid-cols-1 items-end mb-6">
                <div class="xl:col-span-3">
                    <div class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2">
                        <input id="search" type="text" placeholder="Cari anggota..." class="flex-1 min-w-[160px] rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />
                        <select id="filter-type" class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option>Tipe Keanggotaan</option>
                            <option>Mahasiswa</option>
                            <option>Dosen</option>
                        </select>
                        <select id="filter-status" class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option>Status</option>
                            <option>Aktif</option>
                            <option>Tidak Aktif</option>
                        </select>
                        <select id="filter-sort" class="rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                            <option>Terbaru</option>
                            <option>Terpopuler</option>
                            <option>Terlama</option>
                        </select>
                        <button class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition" aria-label="Cari">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button id="selectAllTopBtn" type="button" class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                        <!-- unchecked icon -->
                        <svg class="icon-unchecked" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                        </svg>
                        <!-- checked icon (hidden by default) -->
                        <svg class="icon-checked hidden" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                        Seleksi Semua Data
                    </button>
                    <button id="deleteSelected" class="inline-flex items-center justify-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M8 6v14" />
                            <path d="M16 6v14" />
                            <path d="M5 6 6 4h12l1 2" />
                        </svg>
                        Hapus Data Diseleksi
                    </button>
                </div>
            </div>

            @php
                $members = $members ?? [
                    ['identity' => '3312501025', 'name' => 'Daniel Anju Adinov Batubara', 'type' => 'Mahasiswa', 'status' => 'Menunggu', 'updated' => '08-04-2026 10:02:22'],
                    ['identity' => '12345', 'name' => 'Cynthia Lasmini', 'type' => 'Dosen Tetap', 'status' => 'Aktif', 'updated' => '08-04-2026 10:02:22'],
                    ['identity' => '67890', 'name' => 'Rudi Hartono', 'type' => 'Dosen Magang', 'status' => 'Aktif', 'updated' => '08-04-2026 10:02:22'],
                ];
            @endphp

            <div class="overflow-x-auto mt-6">
                <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                            <tr>
                                <th class="px-6 py-3 w-12">Pilih</th>
                                <th class="px-6 py-3">NO.Identitas</th>
                                <th class="px-6 py-3">Nama Anggota</th>
                                <th class="px-6 py-3 hidden lg:table-cell">Tipe Keanggotaan</th>
                                <th class="px-6 py-3 hidden lg:table-cell">Status</th>
                                <th class="px-6 py-3 hidden lg:table-cell">Terakhir Diubah</th>
                                <th class="px-6 py-3 text-right w-12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr class="hover:bg-gray-100 transition-all duration-150 ease-in-out odd:bg-white even:bg-slate-100">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="row-checkbox h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" />
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $member['identity'] }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $member['name'] }}</td>
                                    <td class="px-6 py-4 hidden lg:table-cell">{{ $member['type'] }}</td>
                                    <td class="px-6 py-4 hidden lg:table-cell">{{ $member['status'] }}</td>
                                    <td class="px-6 py-4 hidden lg:table-cell">{{ $member['updated'] }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.anggota.edit', $member['id'] ?? $loop->index) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-transparent text-slate-700 hover:bg-slate-100 transition" aria-label="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit-2">
                                                <path d="m17 3 4 4L7 21H3v-4L17 3z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">Menampilkan 1 hingga 10 dari 12 data</p>
                <div class="inline-flex items-center rounded-2xl bg-slate-100 p-1">
                    <button class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">&lt;</button>
                    <button class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-medium text-white">1</button>
                    <button class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">2</button>
                    <button class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">3</button>
                    <button class="rounded-2xl px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">&gt;</button>
                </div>
            </div>
        </div>
    </div>

            <script>
        (function(){
            const selectAllBtn = document.getElementById('selectAllTopBtn');
            const deleteBtn = document.getElementById('deleteSelected');
            const rowCheckboxes = () => Array.from(document.querySelectorAll('input.row-checkbox'));
            let active = false;

            const setSelectAllVisual = (el, state) => {
                if (!el) return;
                const iconChecked = el.querySelector('.icon-checked');
                const iconUnchecked = el.querySelector('.icon-unchecked');
                if (iconChecked) iconChecked.classList.toggle('hidden', !state);
                if (iconUnchecked) iconUnchecked.classList.toggle('hidden', state);
                el.classList.toggle('bg-blue-700', state);
            };

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function(){
                    active = !active;
                    rowCheckboxes().forEach(cb => cb.checked = active);
                    setSelectAllVisual(this, active);
                });
            }

            // keep selectAll button state in sync when rows change
            rowCheckboxes().forEach(cb => cb.addEventListener('change', function(){
                if (!selectAllBtn) return;
                const all = rowCheckboxes();
                const allChecked = all.length && all.every(c => c.checked);
                active = !!allChecked;
                setSelectAllVisual(selectAllBtn, active);
            }));

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(){
                    const checked = rowCheckboxes().filter(c => c.checked);
                    if (!checked.length) return alert('Pilih minimal satu data.');
                    if (confirm(`Hapus ${checked.length} item yang dipilih?`)) {
                        alert('Fungsi hapus belum diimplementasikan.');
                    }
                });
            }

            // update daftar label based on selected type
            const daftarLabel = document.getElementById('daftarTypeLabel');
            const filterType = document.getElementById('filter-type');
            function updateDaftarLabel() {
                if (!daftarLabel) return;
                if (!filterType) { daftarLabel.textContent = ''; return; }
                const txt = filterType.options[filterType.selectedIndex].text || '';
                daftarLabel.textContent = (txt && txt !== 'Tipe Keanggotaan') ? `(${txt})` : '';
            }
            if (filterType) {
                filterType.addEventListener('change', updateDaftarLabel);
                updateDaftarLabel();
            }
        })();
    </script>
@endsection
