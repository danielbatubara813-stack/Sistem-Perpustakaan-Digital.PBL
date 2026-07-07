@php
    $filterId = 'filter-' . uniqid();
    $tahunMin = $tahunRange['min'] ?? 1950;
    $tahunMax = $tahunRange['max'] ?? date('Y');
@endphp

<div class="bg-white h-max rounded-lg border border-gray-300 shadow-md p-4" data-filter-sidebar="{{ $filterId }}">
    <form action="{{ route('cari-buku-page') }}" method="GET" class="space-y-4">
        <input type="hidden" name="scroll" value="daftar-buku">

        {{-- TAHUN PENERBITAN --}}
        <div class="w-full rounded-xl filter-collapse">
            <button type="button" class="collapse-btn flex w-full justify-between items-center p-3 bg-white hover:bg-gray-50 transition-colors">
                <span class="font-semibold">Tahun Penerbitan</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="collapse-icon transition-transform duration-300" style="transform: rotate(90deg)">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300">
                <div class="p-4">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="flex flex-col items-center gap-1">
                            <label class="text-xs text-gray-500">Dari</label>
                            <input id="{{ $filterId }}-inputDari" type="number" name="dari-tahun" min="{{ $tahunMin }}" max="{{ $tahunMax }}"
                                value="{{ $selectedFilters['dari_tahun'] }}" class="w-20 p-2 rounded-lg border border-gray-200 text-sm text-center">
                        </div>
                        <span class="text-gray-400 mt-4">-</span>
                        <div class="flex flex-col items-center gap-1">
                            <label class="text-xs text-gray-500">Ke</label>
                            <input id="{{ $filterId }}-inputKe" type="number" name="ke-tahun" min="{{ $tahunMin }}" max="{{ $tahunMax }}"
                                value="{{ $selectedFilters['ke_tahun'] }}" class="w-20 p-2 rounded-lg border border-gray-200 text-sm text-center">
                        </div>
                    </div>

                    <div class="relative h-9 px-1 mb-4">
                        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 rounded-full -translate-y-1/2"></div>
                        <div id="{{ $filterId }}-sliderFill" class="absolute top-1/2 h-1 bg-blue-500 rounded-full -translate-y-1/2 pointer-events-none"></div>
                        <input id="{{ $filterId }}-sliderDari" type="range" min="{{ $tahunMin }}" max="{{ $tahunMax }}" step="1"
                            value="{{ $selectedFilters['dari_tahun'] }}"
                            class="absolute w-full top-1/2 -translate-y-1/2 ml-0 appearance-none bg-transparent slider-thumb">
                        <input id="{{ $filterId }}-sliderKe" type="range" min="{{ $tahunMin }}" max="{{ $tahunMax }}" step="1"
                            value="{{ $selectedFilters['ke_tahun'] }}"
                            class="absolute w-full top-1/2 -translate-y-1/2 appearance-none bg-transparent slider-thumb">
                    </div>

                    <div class="flex justify-between text-xs text-gray-400">
                        <span>{{ $tahunMin }}</span>
                        <span>{{ $tahunMax }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TIPE KOLEKSI --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span class="font-semibold">Tipe Koleksi</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm">
                @forelse ($tipeList ?? [] as $tipe)
                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="tipe[]" value="{{ $tipe->id_tipe }}" id="tipe-{{ $tipe->id_tipe }}"
                            {{ in_array($tipe->id_tipe, $selectedFilters['tipe'] ?? []) ? 'checked' : '' }}>
                        <label for="tipe-{{ $tipe->id_tipe }}">{{ $tipe->nama_tipe ?? '-' }}</label>
                    </div>
                @empty
                    <p class="text-gray-500 text-xs">Tidak ada tipe koleksi</p>
                @endforelse
            </div>
        </div>

        {{-- SUBJEK --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span class="font-semibold">Subjek</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm max-h-64 overflow-y-auto">
                @forelse ($subjekList ?? [] as $subjek)
                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="subjek[]" value="{{ $subjek->id_subjek }}" id="subjek-{{ $subjek->id_subjek }}"
                            {{ in_array($subjek->id_subjek, $selectedFilters['subjek'] ?? []) ? 'checked' : '' }}>
                        <label for="subjek-{{ $subjek->id_subjek }}" class="cursor-pointer">{{ $subjek->nama_subjek ?? '-' }}</label>
                    </div>
                @empty
                    <p class="text-gray-500 text-xs">Tidak ada subjek</p>
                @endforelse
            </div>
        </div>

        {{-- PENERBIT --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span class="font-semibold">Penerbit</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm max-h-64 overflow-y-auto">
                @forelse ($penerbitList ?? [] as $penerbit)
                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="penerbit[]" value="{{ $penerbit->id_penerbit }}" id="penerbit-{{ $penerbit->id_penerbit }}"
                            {{ in_array($penerbit->id_penerbit, $selectedFilters['penerbit'] ?? []) ? 'checked' : '' }}>
                        <label for="penerbit-{{ $penerbit->id_penerbit }}" class="cursor-pointer">{{ $penerbit->nama_penerbit ?? '-' }}</label>
                    </div>
                @empty
                    <p class="text-gray-500 text-xs">Tidak ada penerbit</p>
                @endforelse
            </div>
        </div>

        {{-- BAHASA --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span class="font-semibold">Bahasa</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm">
                @forelse ($bahasaList ?? [] as $bahasa)
                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="bahasa[]" value="{{ $bahasa->kode_bahasa }}" id="bahasa-{{ $bahasa->kode_bahasa }}"
                            {{ in_array($bahasa->kode_bahasa, $selectedFilters['bahasa'] ?? []) ? 'checked' : '' }}>
                        <label for="bahasa-{{ $bahasa->kode_bahasa }}" class="cursor-pointer">{{ $bahasa->nama_bahasa ?? '-' }}</label>
                    </div>
                @empty
                    <p class="text-gray-500 text-xs">Tidak ada bahasa</p>
                @endforelse
            </div>
        </div>

        {{-- KETERSEDIAAN --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span class="font-semibold">Ketersediaan</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm">
                <div class="flex items-center gap-4">
                    <input type="radio" name="ketersediaan" value="tersedia" id="ketersediaan-tersedia"
                        {{ $selectedFilters['ketersediaan'] === 'tersedia' ? 'checked' : '' }}>
                    <label for="ketersediaan-tersedia" class="cursor-pointer">Tersedia</label>
                </div>
                <div class="flex items-center gap-4">
                    <input type="radio" name="ketersediaan" value="tidak-tersedia" id="ketersediaan-tidak"
                        {{ $selectedFilters['ketersediaan'] === 'tidak-tersedia' ? 'checked' : '' }}>
                    <label for="ketersediaan-tidak" class="cursor-pointer">Tidak Tersedia</label>
                </div>
                <div class="flex items-center gap-4">
                    <input type="radio" name="ketersediaan" value="" id="ketersediaan-semua"
                        {{ $selectedFilters['ketersediaan'] === '' ? 'checked' : '' }}>
                    <label for="ketersediaan-semua" class="cursor-pointer">Semua</label>
                </div>
            </div>
        </div>

        {{-- SEARCH --}}
        @if (request()->route()->getName() === 'cari-buku-page')
            <div class="w-full">
                <input type="text" name="search" value="{{ $selectedFilters['search'] }}"
                    placeholder="Cari judul, penulis, atau ISBN"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        @endif

        {{-- BUTTONS --}}
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-blue-800 hover:bg-blue-700 rounded-md p-3 text-white font-bold transition">
                Terapkan Filter
            </button>
            <a href="{{ route('cari-buku-page') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 rounded-md p-3 text-center text-gray-800 font-bold transition">
                Reset
            </a>
        </div>
    </form>
</div>

<script>
    (function () {
        var filterRoot = document.querySelector('[data-filter-sidebar="{{ $filterId }}"]');
        if (!filterRoot) return;

        // ── Collapse ────────────────────────────────────────────────
        filterRoot.querySelectorAll('.filter-collapse').forEach(function (section) {
            var btn     = section.querySelector('.collapse-btn');
            var content = section.querySelector('.collapse-content');
            var icon    = section.querySelector('.collapse-icon');
            if (!btn || !content) return;

            // default: buka
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.overflow  = 'hidden';
            if (icon) icon.style.transform = 'rotate(90deg)';

            btn.addEventListener('click', function () {
                var isOpen = content.style.maxHeight !== '0px';
                content.style.maxHeight = isOpen ? '0px' : content.scrollHeight + 'px';
                if (icon) icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
            });
        });

        // ── Dual range slider ───────────────────────────────────────
        var sliderDari = document.getElementById('{{ $filterId }}-sliderDari');
        var sliderKe   = document.getElementById('{{ $filterId }}-sliderKe');
        var inputDari  = document.getElementById('{{ $filterId }}-inputDari');
        var inputKe    = document.getElementById('{{ $filterId }}-inputKe');
        var fill       = document.getElementById('{{ $filterId }}-sliderFill');
        if (!sliderDari || !sliderKe || !inputDari || !inputKe || !fill) return;

        function updateUI() {
            var rangeMin = parseInt(sliderDari.min);
            var rangeMax = parseInt(sliderDari.max);
            var a = Math.min(parseInt(sliderDari.value), parseInt(sliderKe.value));
            var b = Math.max(parseInt(sliderDari.value), parseInt(sliderKe.value));
            var denom = rangeMax - rangeMin || 1;

            fill.style.left  = ((a - rangeMin) / denom * 100) + '%';
            fill.style.right = ((rangeMax - b) / denom * 100) + '%';

            inputDari.value = a;
            inputKe.value   = b;
        }

        sliderDari.addEventListener('input', updateUI);
        sliderKe.addEventListener('input', updateUI);

        inputDari.addEventListener('change', function () {
            sliderDari.value = this.value;
            updateUI();
        });
        inputKe.addEventListener('change', function () {
            sliderKe.value = this.value;
            updateUI();
        });

        updateUI();
    })();
</script>

<style>
    .slider-thumb {
        pointer-events: none;  /* elemen input-nya tidak menangkap klik */
    }

    .slider-thumb::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        border: 2px solid #3b82f6;
        pointer-events: all;   /* hanya thumb-nya yang bisa diklik */
    }

    .slider-thumb::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        border: 2px solid #3b82f6;
        pointer-events: all;
    }
</style>
