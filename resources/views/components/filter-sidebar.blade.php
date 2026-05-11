<div class="bg-white h-max rounded-lg border border-gray-300 shadow-md p-4">
    <form action="" class="space-y-4">
        <div class="w-full rounded-xl filter-collapse" id="tahunContainer">

            <!-- Header / Toggle -->
            <button type="button"
                class="collapse-btn flex w-full justify-between items-center p-3 bg-white hover:bg-gray-50 transition-colors">
                <span>Tahun Penerbitan</span>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="collapse-icon transition-transform duration-300" style="transform: rotate(90deg)">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <!-- Panel -->
            <div class="collapse-content overflow-hidden transition-all duration-300">
                <div class="p-4">

                    <!-- Input -->
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="flex flex-col items-center gap-1">
                            <label class="text-xs text-gray-500">Dari</label>
                            <input id="inputDari" type="number" name="dari-tahun" min="1950" max="2025"
                                value="1950" class="w-20 p-2 rounded-lg border border-gray-200 text-sm text-center">
                        </div>

                        <span class="text-gray-400 mt-4">—</span>

                        <div class="flex flex-col items-center gap-1">
                            <label class="text-xs text-gray-500">Ke</label>
                            <input id="inputKe" type="number" name="ke-tahun" min="1950" max="2025"
                                value="2025" class="w-20 p-2 rounded-lg border border-gray-200 text-sm text-center">
                        </div>
                    </div>

                    <!-- Slider -->
                    <div class="relative h-9 px-1 mb-4">
                        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 rounded-full -translate-y-1/2">
                        </div>

                        <div id="sliderFill"
                            class="absolute top-1/2 h-1 bg-blue-500 rounded-full -translate-y-1/2 pointer-events-none">
                        </div>

                        <input id="sliderDari" type="range" min="1950" max="2025" step="1"
                            value="1950"
                            class="absolute w-full top-1/2 -translate-y-1/2 ml-0 appearance-none bg-transparent slider-thumb">

                        <input id="sliderKe" type="range" min="1950" max="2025" step="1" value="2025"
                            class="absolute w-full top-1/2 -translate-y-1/2 appearance-none bg-transparent slider-thumb">
                    </div>

                    <div class="flex justify-between text-xs text-gray-400">
                        <span>1950</span>
                        <span>2025</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TIPE KOLEKSI --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span>Tipe Koleksi</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm">
                @php
                    $tipeList = [
                        'references' => 'References',
                        'textbook' => 'Textbook',
                        'fiction' => 'Fiction',
                        'tandon' => 'Tandon',
                        'restricted' => 'Restricted',
                    ];
                @endphp

                @foreach ($tipeList as $value => $label)
                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="tipe[]" value="{{ $value }}" id="{{ $value }}-tipe"
                            {{ in_array($value, request()->input('tipe', [])) ? 'checked' : '' }}>

                        <label for="{{ $value }}-tipe">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- SUBJEK --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span>Subjek</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm">
                @php
                    $subjekList = [
                        'Programming',
                        'Web Development',
                        'Mobile Development',
                        'Game Development',
                        'Artificial Intelligence',
                        'Machine Learning',
                        'Data Science',
                        'Cyber Security',
                        'Networking',
                        'Database',
                        'Cloud Computing',
                        'UI/UX Design',
                        'Graphic Design',
                        'Digital Marketing',
                        'Business',
                        'Accounting',
                        'Management',
                        'Economics',
                        'Mathematics',
                        'Physics',
                        'Chemistry',
                        'Biology',
                        'History',
                        'Psychology',
                        'Education',
                    ];
                @endphp

                @foreach ($subjekList as $item)
                    @php
                        $id = Str::slug($item);
                    @endphp

                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="subjek[]" value="{{ $item }}" id="{{ $id }}"
                            {{ in_array($item, request()->input('subjek', [])) ? 'checked' : '' }}>

                        <label for="{{ $id }}">{{ $item }}</label>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- BAHASA --}}
        <div class="w-full filter-collapse">
            <button type="button" class="collapse-btn flex justify-between items-center w-full p-3">
                <span>Bahasa</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-icon transition-transform duration-300"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <div class="collapse-content overflow-hidden transition-all duration-300 pl-6 space-y-3 text-sm">

                <div class="flex items-center gap-4">
                    <input type="radio" name="bahasa" value="ID" id="bahasa-id"
                        {{ request('bahasa', 'ID') == 'ID' ? 'checked' : '' }}>

                    <label for="bahasa-id">Indonesia</label>
                </div>

                <div class="flex items-center gap-4">
                    <input type="radio" name="bahasa" value="EN" id="bahasa-en"
                        {{ request('bahasa') == 'EN' ? 'checked' : '' }}>

                    <label for="bahasa-en">English</label>
                </div>

            </div>
        </div>
        <div>
            <button class="bg-blue-800 rounded-md p-2 text-white w-full font-bold">
                Terapkan Filter
            </button>
        </div>

    </form>
</div>


