@extends('layout.app-admin')

@section('title', 'Kelola Buku')
@php
    $title = 'Daftar Buku';
    $description = 'Kelola koleksi buku dan lihat informasi ringkas setiap judul.';
@endphp
@section('content')
    <div class="bg-white rounded-3xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">

            {{-- Filter Group --}}
            <form method="GET" action="{{ route('admin.buku') }}"
                class="bg-slate-100 rounded-md p-2 flex flex-wrap items-center gap-2 w-full md:w-max">

                <input id="search" name="search" value="{{ request('search') }}" type="text"
                    placeholder="Cari judul / ISBN..."
                    data-auto-submit-search
                    class="w-full sm:w-auto sm:flex-1 sm:max-w-56 rounded-md border border-slate-300
                       px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200" />

                <select id="filter-type" name="bahasa" onchange="this.form.submit()"
                    class="flex-1 sm:flex-none rounded-md border border-slate-300 px-3 py-2 text-sm
                       outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Bahasa</option>
                    @foreach ($bahasaOptions as $bahasa)
                        <option value="{{ $bahasa->kode_bahasa }}"
                            {{ request('bahasa') === $bahasa->kode_bahasa ? 'selected' : '' }}>
                            {{ $bahasa->nama_bahasa }}
                        </option>
                    @endforeach
                </select>

                <select id="filter-status" name="subjek" onchange="this.form.submit()"
                    class="flex-1 sm:flex-none rounded-md border border-slate-300 px-3 py-2 text-sm
                       outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Subjek</option>
                    @foreach ($subjekOptions as $subjek)
                        <option value="{{ $subjek->id_subjek }}"
                            {{ (string) request('subjek') === (string) $subjek->id_subjek ? 'selected' : '' }}>
                            {{ $subjek->nama_subjek }}
                        </option>
                    @endforeach
                </select>

                <select id="filter-sort" name="sort" onchange="this.form.submit()"
                    class="flex-1 sm:flex-none rounded-md border border-slate-300 px-3 py-2 text-sm
                       outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                    <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>
                    <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>
                        Terlama
                    </option>
                </select>

                <button type="submit"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-white
                           border border-slate-300 text-slate-700 hover:bg-slate-50 transition shrink-0"
                    aria-label="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>
            </form>

            {{-- Tambah Buku --}}
            <a href="{{ route('admin.buku.create') }}"
                class="w-full md:w-max flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
                   text-white rounded-md px-3 py-2 text-sm shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>
                Tambah Buku
            </a>

        </div>
    </div>
    <div class="bg-white rounded-3xl shadow-lg p-6 mt-4">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold tracking-wide">{{ $books->total() }} Daftar buku</h2>
            </div>
            <div class="grid grid-cols-2 lg:flex lg:items-center lg:justify-end gap-3">
                <button id="selectAllTopBtn" type="button"
                    class="inline-flex items-center gap-2 rounded-md bg-slate-400 px-3 py-2 text-sm font-medium text-white hover:bg-slate-500 transition">
                    <!-- unchecked icon -->
                    <svg class="icon-unchecked" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                    </svg>
                    <!-- checked icon (hidden by default) -->
                    <svg class="icon-checked hidden" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                    Seleksi Semua Data
                </button>
                <button id="deleteSelected"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash2-icon lucide-trash-2">
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                    Hapus Data Diseleksi
                </button>
            </div>
        </div>
        <div class="overflow-x-auto mt-6">
            <form action="{{ route('admin.buku.destroyMultiple') }}" id="multi-delete-form" data-delete-name="id_buku" method="POST">
                @method('DELETE')
                @csrf
                <table class="min-w-full text-left text-sm text-slate-600 text-nowrap">
                <thead class="text-xs text-gray-600 uppercase bg-gray-300">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-4">Pilih</th>
                        <th class="px-4 py-4">Judul</th>
                        <th class="px-4 py-4">ISBN/ISSN</th>
                        <th class="px-4 py-4 min-w-60">Perubahan Terakhir</th>
                        <th class="px-4 py-4 text-nowrap">Jumlah Item</th>
                        <th class="px-4 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">

    @forelse ($books as $book)
        <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-50 transition-all duration-150">

            <td class="px-3 py-3 align-center text-center">
                <input type="checkbox" name="id_buku[]" value="{{ $book->id_buku }}"
                    class="row-checkbox h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" />
            </td>

            <td class="px-3 py-3">
                <div class="flex items-start gap-3">

                    @php
                        $coverSrc = 'https://placehold.co/80x120';
                        if ($book->cover_buku) {
                            $value = $book->cover_buku;
                            // external URL
                            if (preg_match('/^https?:\/\//i', $value)) {
                                $coverSrc = $value;
                            } else {
                                try {
                                    $disk = \Illuminate\Support\Facades\Storage::disk('public');
                                    if ($disk->exists('covers/' . $value)) {
                                        // if public symlink exists, serve via asset; otherwise read file and return data URI
                                        if (file_exists(public_path('storage/covers/' . $value))) {
                                            $coverSrc = asset('storage/covers/' . $value);
                                        } else {
                                            try {
                                                $contents = $disk->get('covers/' . $value);
                                                $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                                                $mime = 'image/jpeg';
                                                if (in_array($ext, ['png'])) $mime = 'image/png';
                                                elseif (in_array($ext, ['gif'])) $mime = 'image/gif';
                                                elseif (in_array($ext, ['webp'])) $mime = 'image/webp';
                                                elseif (in_array($ext, ['jpg','jpeg'])) $mime = 'image/jpeg';
                                                $coverSrc = 'data:' . $mime . ';base64,' . base64_encode($contents);
                                            } catch (\Exception $e) {
                                                $coverSrc = 'https://placehold.co/80x120';
                                            }
                                        }
                                    } else {
                                        // detect binary blob: contains non-printable chars or unusually long
                                        if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', $value) || strlen($value) > 255) {
                                            $mime = 'image/jpeg';
                                            $coverSrc = 'data:' . $mime . ';base64,' . base64_encode($value);
                                        } else {
                                            $coverSrc = 'https://placehold.co/80x120';
                                        }
                                    }
                                } catch (\Exception $e) {
                                    $coverSrc = 'https://placehold.co/80x120';
                                }
                            }
                        }
                    @endphp

                    <img src="{{ $coverSrc }}" class="w-12 h-16 object-cover rounded shadow-sm" />

                    <div class="min-w-0">
                        <p class="font-semibold text-slate-900 line-clamp-1">
                            {{ $book->judul_buku }}
                        </p>

                        <p class="text-xs text-slate-500 mt-1 truncate">
                            {{ $book->edisi }}
                        </p>
                    </div>

                </div>
            </td>

            <td class="px-3 py-3 text-slate-700">
                {{ $book->isbn }}
            </td>

            <td class="px-3 py-3 text-slate-700 whitespace-nowrap">
                {{ $book->tanggal_diubah ? \Carbon\Carbon::parse($book->tanggal_diubah)->setTimezone(config('app.timezone'))->format('d-m-Y H:i:s') : '-' }}
            </td>

            <td class="px-3 py-3 text-slate-700 text-center">
                {{ $book->items_count }}
            </td>

            <td class="px-3 py-3 text-right">
                <div class="inline-flex items-center gap-2 justify-end">

                    <a href="{{ route('admin.buku.edit', $book->id_buku) }}"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-yellow-300 text-black hover:bg-yellow-400 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <path d="m17 3 4 4L7 21H3v-4L17 3z" />

                        </svg>

                    </a>

                </div>
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-6 py-6 text-center text-slate-500">
                Tidak ada data buku.
            </td>
        </tr>
    @endforelse

</tbody>
                </table>
            </form>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $books->firstItem() ?? 0 }} hingga {{ $books->lastItem() ?? 0 }}
                dari {{ $books->total() }} data
            </p>

            @if ($books->lastPage() > 1)
                <div class="inline-flex items-center gap-2">
                    <div class="px-4 py-2 rounded-md text-sm text-slate-700">
                        Halaman <span class="font-semibold">{{ $books->currentPage() }}</span>
                        dari <span class="font-semibold">{{ $books->lastPage() }}</span>
                    </div>

                    <div class="flex items-center justify-center rounded-md gap-2 bg-slate-100 p-1">
                        @if ($books->onFirstPage())
                            <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $books->previousPageUrl() }}"
                                class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </a>
                        @endif

                        @php
                            $currentPage = $books->currentPage();
                            $lastPage = $books->lastPage();
                            $start = max($currentPage - 1, 1);
                            $end = min($currentPage + 1, $lastPage);
                            if ($currentPage === 1) {
                                $end = min(3, $lastPage);
                            }
                            if ($currentPage === $lastPage) {
                                $start = max($lastPage - 2, 1);
                            }
                        @endphp

                        @foreach ($books->getUrlRange($start, $end) as $page => $url)
                            @if ($page === $books->currentPage())
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}"
                                class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </a>
                        @else
                            <span class="p-2 bg-slate-200 text-slate-400 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>


    <script>
        document.querySelectorAll('[data-auto-submit-search]').forEach((input) => {
            let timeoutId;

            input.addEventListener('input', () => {
                clearTimeout(timeoutId);

                timeoutId = setTimeout(() => {
                    input.form?.requestSubmit();
                }, 350);
            });
        });
    </script>
@endsection
