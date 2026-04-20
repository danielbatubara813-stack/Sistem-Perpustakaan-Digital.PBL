{{-- Isi content halaman beranda --}}
@extends('layout.main-app')

@section('content')
    <div class="py-12 px-4 sm:px-6 md:px-12 lg:px-24 grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <div class="bg-white h-max rounded-lg border border-gray-300 shadow-md p-4">
            <form action="" class="space-y-4">
                <div class="w-full max-w-sm rounded-xl filter-collapse" id="tahunContainer">

                    <!-- Header / Toggle -->
                    <button type="button"
                        class="collapse-btn flex justify-between items-center w-full p-3 bg-white hover:bg-gray-50 transition-colors">
                        <span>Tahun Penerbitan</span>

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="collapse-icon transition-transform duration-300"
                            style="transform: rotate(90deg)">
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
                                        value="1950"
                                        class="w-20 p-2 rounded-lg border border-gray-200 text-sm text-center">
                                </div>

                                <span class="text-gray-400 mt-4">—</span>

                                <div class="flex flex-col items-center gap-1">
                                    <label class="text-xs text-gray-500">Ke</label>
                                    <input id="inputKe" type="number" name="ke-tahun" min="1950" max="2025"
                                        value="2025"
                                        class="w-20 p-2 rounded-lg border border-gray-200 text-sm text-center">
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

                                <input id="sliderKe" type="range" min="1950" max="2025" step="1"
                                    value="2025"
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
                                <input type="checkbox" name="tipe[]" value="{{ $value }}"
                                    id="{{ $value }}-tipe"
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
                    <button class="bg-blue-800 rounded-md p-2 text-white w-full font-bold">Terapkan Filter</button>
                </div>
            </form>
        </div>
        <div class="lg:col-span-3 bg-white rounded-lg border border-gray-300 shadow-md p-4">
            <div class="w-full flex flex-col gap-4">
                @foreach ($koleksi_baru as $item)
                    <a href="{{ route('detail-buku-page', $item['id']) }}">
                        <div
                            class="border border-gray-300 p-4 rounded-md transition-all duration-300 ease-in-out hover:shadow-md">
                            <div class="w-full grid grid-cols-1 lg:grid-cols-6 space-y-4 lg:space-y-0 gap-0 lg:gap-2">
                                <img src="{{ $item['cover'] }}"
                                    class="aspect-[1/1.6] w-64 lg:w-36 rounded-md object-fit border shadow-md border-gray-300"
                                    alt="">
                                <div class="col-span-4 space-y-4">
                                    <h4 class="font-bold text-xl">{{ $item['judul'] }}</h4>
                                    <button class="text-sm flex gap-2 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-send-icon lucide-send">
                                            <path
                                                d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                            <path d="m21.854 2.147-10.94 10.939" />
                                        </svg>
                                        Bagikan
                                    </button>
                                    <div class="border border-gray-300 rounded-full px-6 py-1 w-max text-sm">
                                        <p>{{ $item['penulis'] }}</p>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">Edisi</h4>
                                            <p class="col-span-4">{{ $item['edisi'] }}</p>
                                        </div>
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">ISBN/ISSN</h4>
                                            <p class="col-span-4">{{ $item['isbn'] }}</p>
                                        </div>
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">No
                                                Panggil</h4>
                                            <p class="col-span-4">{{ $item['no_panggil'] }}</p>
                                        </div>
                                        <div class="grid grid-cols-5 gap-2">
                                            <h4 class="font-bold text-black">Deskripsi</h4>
                                            <p class="col-span-4">{{ $item['deskripsi'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="w-36 lg:w-full aspect-square border border-gray-2 rounded-lg text-center flex items-center justify-center flex-col gap-4">
                                    <h4 class="text-sm">Ketersediaan</h4>
                                    <h1 class="text-4xl font-bold">2</h1>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="flex items-center justify-center gap-2">
                    <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">1</button>
                    <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">2</button>
                    <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">3</button>
                    <button class="p-2 rounded-md border border-gray-300 text-center aspect-square w-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-right-icon lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
