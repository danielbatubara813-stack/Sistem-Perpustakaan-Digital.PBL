<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $buku = [

            [
                'judul' => 'Laskar Pelangi',
                'deskripsi' => 'Novel karya Andrea Hirata yang menceritakan perjuangan anak-anak Belitung dalam mendapatkan pendidikan.',
            ],

            [
                'judul' => 'Bumi',
                'deskripsi' => 'Novel fantasi karya Tere Liye tentang petualangan Raib dan dunia paralel.',
            ],

            [
                'judul' => 'Atomic Habits',
                'deskripsi' => 'Buku pengembangan diri karya James Clear tentang membangun kebiasaan kecil yang berdampak besar.',
            ],

            [
                'judul' => 'Filosofi Teras',
                'deskripsi' => 'Buku karya Henry Manampiring yang membahas filsafat stoikisme dalam kehidupan sehari-hari.',
            ],

            [
                'judul' => 'Rich Dad Poor Dad',
                'deskripsi' => 'Buku karya Robert T. Kiyosaki tentang pengelolaan keuangan dan pola pikir finansial.',
            ],

            [
                'judul' => 'Negeri 5 Menara',
                'deskripsi' => 'Novel Ahmad Fuadi tentang perjuangan santri meraih impian.',
            ],

            [
                'judul' => 'Dilan 1990',
                'deskripsi' => 'Novel romantis karya Pidi Baiq yang berlatar masa SMA di Bandung.',
            ],

            [
                'judul' => 'Ayat-Ayat Cinta',
                'deskripsi' => 'Novel religi karya Habiburrahman El Shirazy tentang kehidupan mahasiswa Indonesia di Mesir.',
            ],

            [
                'judul' => 'Harry Potter dan Batu Bertuah',
                'deskripsi' => 'Novel fantasi karya J.K. Rowling tentang petualangan Harry Potter di Hogwarts.',
            ],

            [
                'judul' => 'Sherlock Holmes',
                'deskripsi' => 'Kumpulan kisah detektif legendaris karya Arthur Conan Doyle.',
            ],

            [
                'judul' => 'Dasar Pemrograman Python',
                'deskripsi' => 'Buku pembelajaran dasar bahasa Python untuk pemula.',
            ],

            [
                'judul' => 'Jaringan Komputer',
                'deskripsi' => 'Buku pembelajaran konsep jaringan komputer dan komunikasi data.',
            ],

            [
                'judul' => 'Basis Data Modern',
                'deskripsi' => 'Buku mengenai konsep database relasional dan implementasinya.',
            ],

            [
                'judul' => 'Algoritma dan Struktur Data',
                'deskripsi' => 'Buku pembelajaran algoritma dasar dan struktur data.',
            ],

            [
                'judul' => 'Matematika Diskrit',
                'deskripsi' => 'Materi matematika diskrit untuk mahasiswa informatika.',
            ],

            [
                'judul' => 'Fisika Dasar',
                'deskripsi' => 'Buku pembelajaran konsep dasar fisika dan penerapannya.',
            ],

            [
                'judul' => 'Kimia Dasar',
                'deskripsi' => 'Buku pengantar ilmu kimia untuk pelajar dan mahasiswa.',
            ],

            [
                'judul' => 'Biologi Modern',
                'deskripsi' => 'Buku yang membahas konsep dasar biologi modern.',
            ],

            [
                'judul' => 'Sejarah Dunia',
                'deskripsi' => 'Buku sejarah yang membahas perkembangan peradaban dunia.',
            ],

            [
                'judul' => 'Seni Berpikir Kritis',
                'deskripsi' => 'Buku pengembangan kemampuan berpikir logis dan analitis.',
            ],
        ];

        foreach ($buku as $item) {

            $noRak = 'RAK-' . rand(1, 20);

            $suffix = strtoupper(
                $faker->bothify('??##')
            );

            DB::table('buku')->insert([

                'id_tipe' => rand(1, 5),

                'kode_bahasa' => ['ID', 'EN'][array_rand(['ID', 'EN'])],

                'id_penerbit' => rand(1, 5),

                'isbn' => $faker->unique()
                    ->numerify('#############'),

                'judul_buku' => $item['judul'],

                'tanggal_terbit' => $faker->date(),

                'deskripsi' => $item['deskripsi'],

                'edisi' => 'Edisi ' . rand(1, 5),

                'cover_buku' => null,

                'no_rak' => $noRak,

                'no_panggil' => $noRak . '-' . $suffix,
            ]);
        }
    }
}
