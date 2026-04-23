@extends('layout.main-app')

@section('title', 'Hubungi Kami')

@section('content')
    <div class="relative h-96">
        <div class="absolute top-0 left-0 bg-linear-to-l from-black/75 via-black/50 to-black/75 w-full h-full z-10">
        </div>
        <img class="absolute top-0 left-0 w-full h-full object-cover z-0" src="{{ asset('static/backgroundHero.jpg') }}"
            alt="">
        <div class="absolute top-0 left-0 w-full h-full z-10 flex flex-col items-center justify-center text-white space-y-4">
            <h1 class="font-bold text-4xl uppercase">Hubungi Kami</h1>
            <p class="w-full lg:w-1/2 text-center">Kami siap membantu Anda. Jika ada pertanyaan, saran, atau kendala terkait
                sistem perpustakaan, silakan kontak kami.</p>
        </div>
    </div>
    <div class="relative">
        <div class="px-4 sm:px-6 md:px-12 lg:px-24 py-12 w-full">
            <div class="p-8 rounded-md border border-gray-300 shadow-md bg-white">
                <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-16">
                    <div class="space-y-4">
                        <h1 class="font-bold text-xl">Kirim Pesan Anda</h1>
                        <p class="w-96">Punya Pertanyaan? Punya masalah? atau butuh bantuan silahkan hubungi kami</p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-2 rounded-md">
                                <div class="p-2 rounded-md border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-phone-icon lucide-phone">
                                        <path
                                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold">No. Telepon</h4>
                                    <p>+62-778-469858</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-2 rounded-md">
                                <div class="p-2 rounded-md border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-mail-icon lucide-mail">
                                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold">Alamat Email</h4>
                                    <p>perpus@polibatam.ac.id </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-2 rounded-md">
                                <div class="p-2 rounded-md border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-map-pin-icon lucide-map-pin">
                                        <path
                                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold">Lokasi</h4>
                                    <p>Jl. Ahmad Yani, Batam Kota, Kota Batam, Kep. Riau. Indonesia </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <iframe class="border border-gray-400 rounded-lg w-full"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d997.2644827729761!2d104.04850971886985!3d1.1186286865586696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d989aa75af33bd%3A0xe426a7c17236e2de!2sPerpustakaan%20Polibatam!5e0!3m2!1sid!2sid!4v1775569662493!5m2!1sid!2sid"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <ul class="flex items-center gap-4 text-white">
                            <li class="bg-red-600 w-10 aspect-square p-2 rounded-lg">
                                <a href="" class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-brand-youtube">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M18 3a5 5 0 0 1 5 5v8a5 5 0 0 1 -5 5h-12a5 5 0 0 1 -5 -5v-8a5 5 0 0 1 5 -5zm-9 6v6a1 1 0 0 0 1.514 .857l5 -3a1 1 0 0 0 0 -1.714l-5 -3a1 1 0 0 0 -1.514 .857z" />
                                    </svg>
                                </a>
                            </li>
                            <li class="bg-pink-600 w-10 aspect-square p-2 rounded-lg">
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4l0 -8" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                        <path d="M16.5 7.5v.01" />
                                    </svg>
                                </a>
                            </li>
                            <li class="bg-blue-900 w-10 aspect-square p-2 rounded-lg">
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-brand-facebook">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M18 2a1 1 0 0 1 .993 .883l.007 .117v4a1 1 0 0 1 -.883 .993l-.117 .007h-3v1h3a1 1 0 0 1 .991 1.131l-.02 .112l-1 4a1 1 0 0 1 -.858 .75l-.113 .007h-2v6a1 1 0 0 1 -.883 .993l-.117 .007h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-6h-2a1 1 0 0 1 -.993 -.883l-.007 -.117v-4a1 1 0 0 1 .883 -.993l.117 -.007h2v-1a6 6 0 0 1 5.775 -5.996l.225 -.004h3z" />
                                    </svg>
                                </a>
                            </li>
                            <li class="bg-cyan-600 w-10 aspect-square p-2 rounded-lg">
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h1 class="font-bold text-xl">Form Kirim Pesan</h1>
                        <form id="contactForm" action="{{ route('kirim-pesan') }}" class="space-y-5" method="POST">
                            @csrf
                            @method("POST")
                            <div class="flex flex-col">
                                <label for="nama-input">Nama</label>
                                <input type="text" id="nama-input" name="nama"
                                    class="p-2 rounded-md shadow-md w-full border border-gray-300">
                            </div>
                            <div class="flex flex-col">
                                <label for="email-input">Email</label>
                                <input type="text" id="email-input" name="email"
                                    class="p-2 rounded-md shadow-md w-full border border-gray-300">
                            </div>
                            <div class="flex flex-col">
                                <label for="judul-input">Judul</label>
                                <input type="text" id="judul-input" name="judul"
                                    class="p-2 rounded-md shadow-md w-full border border-gray-300">
                            </div>
                            <div class="flex flex-col">
                                <label for="pesan-input">Pesan</label>
                                <textarea id="pesan-input" name="pesan" class="p-2 rounded-md shadow-md w-full border border-gray-300 h-40"></textarea>
                            </div>
                            <div>
                                <button type="submit" class="bg-blue-800 rounded-md text-white font-bold px-6 py-2">
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');

            btn.disabled = true;
            btn.innerText = 'Mengirim...';
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        });
    </script>
@endsection
