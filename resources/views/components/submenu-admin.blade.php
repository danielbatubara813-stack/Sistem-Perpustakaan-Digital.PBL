@if (Route::is('admin.data-terkendali.*'))
    <div class="w-full lg:w-max overflow-x-auto scrollbar-hide">
        <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2 w-max min-w-full">
            <a id="daftarTab" href="{{ route('admin.data-terkendali.tipe-koleksi.index') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.tipe-koleksi.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Tipe Koleksi
                <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span>
            </a>

            <a href="{{ route('admin.data-terkendali.subjek.index') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.subjek.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Subjek
            </a>

            <a href="{{ route('admin.data-terkendali.dok-bahasa.index') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.dok-bahasa.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Dok Bahasa
            </a>

            <a href="{{ route('admin.data-terkendali.penulis.index') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.penulis.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Penulis
            </a>

            <a href="{{ route('admin.data-terkendali.penerbit.index') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.penerbit.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Penerbit
            </a>
        </div>
    </div>
@endif

@if (Route::is(['admin.peminjaman', 'admin.peminjaman.*']))
    <div class="w-full lg:w-max overflow-x-auto scrollbar-hide">
        <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2 w-max min-w-full">
            <a href="{{ route('admin.peminjaman') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs(['admin.peminjaman.catat-peminjaman', 'admin.peminjaman']) ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">
                Daftar Peminjaman
            </a>

            <a href="{{ route('admin.peminjaman.aturan') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs(['admin.peminjaman.aturan', 'admin.peminjaman.aturan.*']) ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">
                Aturan Peminjaman
            </a>

            <a href="{{ route('admin.peminjaman.reservasi') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.peminjaman.reservasi') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">
                Daftar Reservasi
            </a>
        </div>
    </div>
@endif

@if (Route::is(['admin.pengembalian', 'admin.pengembalian.*']))
    <div class="w-full lg:w-max overflow-x-auto scrollbar-hide">
        <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2 w-max min-w-full">
            <a href="{{ route('admin.pengembalian.index') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.pengembalian.index') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">
                Daftar Pengembalian
            </a>

            <a href="{{ route('admin.pengembalian.buku') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.pengembalian.buku') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">
                Pengembalian Buku
            </a>

            <a href="{{ route('admin.pengembalian.cepat') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.pengembalian.cepat') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">
                Pengembalian Cepat
            </a>
        </div>
    </div>
@endif

@if (Route::is(['admin.anggota', 'admin.anggota.*', 'admin.anggota.jenis', 'admin.anggota.jenis.*']))
    <div class="w-full lg:w-max overflow-x-auto scrollbar-hide">
        <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2 w-max min-w-full">
            <a id="daftarTab" href="{{ route('admin.anggota.daftar') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.daftar') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Daftar Anggota
                <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span>
            </a>

            <a href="{{ route('admin.anggota.jenis') }}"
                class="text-nowrap px-4 py-2 text-sm {{ request()->routeIs('admin.anggota.jenis*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">
                Jenis Keanggotaan
            </a>
        </div>
    </div>
@endif
