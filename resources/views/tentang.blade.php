@extends('layout.main-app')

@section('title', 'Tentang Kami')

@section('content')

{{-- HERO --}}
<div class="relative h-96">
    <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-10"></div>
    <img class="absolute top-0 left-0 w-full h-full object-cover z-0" src="{{ asset('static/backgroundHero.jpg') }}"
            alt="">

    {{-- text --}}
    <div class="absolute z-20 h-full flex flex-col justify-center px-6 md:px-16 text-white">
        <p class="text-blue-300 font-semibold tracking-widest mb-2">TENTANG KAMI</p>

        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight uppercase">
            PERPUSTAKAAN <br>
            POLITEKNIK NEGERI BATAM
        </h1>
    </div>
</div>

{{-- CONTENT --}}
<div class="bg-white px-6 md:px-16 py-16 space-y-16">

    {{-- TENTANG --}}
    <div class="grid md:grid-cols-2 gap-10 items-center">
        
        {{-- image --}}
        <div class="bg-gray-300 h-72 rounded-lg flex items-center justify-center shadow">
            <span class="text-gray-500">
                <img src="https://deepublishstore.com/wp-content/uploads/2021/10/prospek-kerja-jurusan-ilmu-perpustakaan.jpg" alt="Perpustakaan" class="w-full h-full object-cover">
            </span>
        </div>

        {{-- text --}}
        <div>
            <h2 class="font-bold text-lg mb-3">TENTANG KAMI</h2>

            <p class="text-gray-700 leading-relaxed mb-3">
                Perpustakaan kami hadir sebagai pusat informasi dan sumber belajar yang menyediakan koleksi buku yang beragam, mulai dari buku pelajaran, referensi, novel, hingga koleksi umum lainnya.Dengan dukungan sistem digital, pengguna dapat mencari koleksi buku dengan mudah, mengetahui ketersediaan buku secara real-time, serta melakukan peminjaman dan pengembalian dengan lebih cepat dan praktis.
            </p>

            <p class="text-gray-700 leading-relaxed">
                Kami berkomitmen memberikan layanan yang nyaman, efisien, dan mudah diakses, didukung oleh pengelolaan data yang teratur serta informasi yang selalu diperbarui. Selain itu, perpustakaan kami menjadi tempat yang mendukung kegiatan belajar, menambah wawasan, dan meningkatkan minat baca bagi seluruh pengguna.
            </p>
        </div>
    </div>

    {{-- VISI MISI --}}
    <div class="text-center">
        <h2 class="font-bold mb-8">VISI MISI TUJUAN</h2>

        <div class="grid md:grid-cols-2 gap-6 text-left">

            {{-- VISI --}}
            <div class="border border-gray-300 rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <h3 class="font-bold mb-2">VISI</h3>
                <p class="text-sm">
                    Visi dari Polibatam adalah menjadi politeknik generasi baru yang bermutu, adaptif, inovatif, dan bermitra erat dengan industri dan masyarakat untuk mendukung Indonesia Maju dan Sejahtera 2045.
                </p>
            </div>

            {{-- MISI --}}
            <div class="border border-gray-300 rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <h3 class="font-bold mb-2">MISI</h3>
                <p class="text-sm">
                    Misi dari Polibatam adalah aktif dalam proses kreasi, penyebaran dan penerapan sains dan teknologi melalui layanan pendidikan tinggi vokasi dan penelitian terapan yang bermutu.
                </p>
            </div>
        </div>

        {{-- TUJUAN --}}
        <div class="border border-gray-300 p-6 rounded-lg shadow mt-6 text-left hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <h3 class="font-bold mb-2">TUJUAN</h3>
            <ul class="list-disc pl-5 text-sm space-y-1">
                <li>Terwujudnya layanan pembelajaran bermutu</li>
                <li>Meningkatnya organisasi yang transparan dan akuntabel</li>
                <li>Meningkatkan mutu akses layanan pendidikan</li>
                <li>Meningkatkan kualitas penelitian dan inovasi</li>
                <li>Meningkatkan tata kelola organisasi</li>
            </ul>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="text-center">
        <h2 class="font-bold mb-8">STATISTIK KOLEKSI PERPUSTAKAAN</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            
            <div class="border border-gray-300 p-6 rounded-lg shadow text-left hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-xl font-bold">21,615</h3>
                <p class="text-sm">Total Koleksi</p>
            </div>

            <div class="border border-gray-300 p-6 rounded-lg shadow text-left hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-xl font-bold">9,188</h3>
                <p class="text-sm">Total Judul</p>
            </div>

            <div class="border border-gray-300 p-6 rounded-lg shadow text-left hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-xl font-bold">21,324</h3>
                <p class="text-sm">Buku Tersedia</p>
            </div>

            <div class="border border-gray-300 p-6 rounded-lg shadow text-left hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-xl font-bold">532</h3>
                <p class="text-sm">Total Anggota</p>
            </div>
        </div>
    </div>
<div class="w-full rounded-xl overflow-hidden shadow-lg">
    <div class="relative w-full" style="padding-top: 56.25%;">
        <iframe 
            class="absolute top-0 left-0 w-full h-full border-0"
            src="https://www.canva.com/design/DAGmEzTaCgE/_DK133J6ci1ouki3rEwKNw/view?embed"
            allowfullscreen="allowfullscreen"
            allow="fullscreen">
        </iframe>
    </div>
</div>
</div>

@endsection