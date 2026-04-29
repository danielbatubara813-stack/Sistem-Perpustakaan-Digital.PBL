@if (Route::is('admin.data-terkendali.*'))
    <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
        <a id="daftarTab" href="{{ route('admin.data-terkendali.tipe-koleksi.index') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.tipe-koleksi.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Tipe
            Koleksi <span id="daftarTypeLabel" class="ml-2 text-sm text-slate-500"></span></a>
        <a href="{{ route('admin.data-terkendali.subjek.index') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.subjek.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Subjek</a>
        <a href="{{ route('admin.data-terkendali.dok-bahasa.index') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.dok-bahasa.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Dok
            Bahasa</a>
        <a href="{{ route('admin.data-terkendali.penulis.index') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.penulis.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Penulis</a>
        <a href="{{ route('admin.data-terkendali.penerbit.index') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.data-terkendali.penerbit.*') ? 'bg-blue-600 text-white shadow rounded' : 'text-slate-600' }}">Penerbit</a>
    </div>
@endif
@if (Route::is(['admin.peminjaman', 'admin.peminjaman.*']))
    <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
        <a href="{{ route('admin.peminjaman') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.peminjaman') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">Daftar
            Peminjaman</a>
        <a href="{{ route('admin.peminjaman.aturan') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.peminjaman.aturan') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">Aturan
            Peminjaman</a>
        <a href="{{ route('admin.peminjaman.aturan') }}"
            class="px-4 py-2 text-sm {{ request()->routeIs('admin.peminjaman.aturan') ? 'text-white bg-blue-600 shadow rounded' : 'text-slate-600' }}">Daftar
            Reservasi</a>
    </div>
@endif
