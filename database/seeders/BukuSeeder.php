<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $buku = [
            [
                'judul' => 'Laskar Pelangi',
                'deskripsi' => 'Novel karya Andrea Hirata yang menceritakan perjuangan anak-anak Belitung dalam mendapatkan pendidikan.',
                'isbn' => '9789791227203',
                'bahasa' => 'ID',
                'cover_buku' => 'Laskar Pelangi.jpg',
            ],
            [
                'judul' => 'Bumi',
                'deskripsi' => 'Novel fantasi karya Tere Liye tentang petualangan Raib dan dunia paralel.',
                'isbn' => '9786020332950',
                'bahasa' => 'ID',
                'cover_buku' => 'Bumi.jpg',
            ],
            [
                'judul' => 'Atomic Habits',
                'deskripsi' => 'Buku pengembangan diri karya James Clear tentang membangun kebiasaan kecil yang berdampak besar.',
                'isbn' => '9780735211292',
                'bahasa' => 'EN',
                'cover_buku' => 'Atomic Habits.jpg',
            ],
            [
                'judul' => 'Filosofi Teras',
                'deskripsi' => 'Buku karya Henry Manampiring yang membahas filsafat stoikisme dalam kehidupan sehari-hari.',
                'isbn' => '9786024246949',
                'bahasa' => 'ID',
                'cover_buku' => 'Filosofi Teras.jpg',
            ],
            [
                'judul' => 'Rich Dad Poor Dad',
                'deskripsi' => 'Buku karya Robert T. Kiyosaki tentang pengelolaan keuangan dan pola pikir finansial.',
                'isbn' => '9781612681139',
                'bahasa' => 'EN',
                'cover_buku' => 'Rich Dad Poor Dad.jpg',
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'deskripsi' => 'Novel Ahmad Fuadi tentang perjuangan santri meraih impian.',
                'isbn' => '9789792266324',
                'bahasa' => 'ID',
                'cover_buku' => 'Negeri 5 Menara.jpg',
            ],
            [
                'judul' => 'Dilan 1990',
                'deskripsi' => 'Novel romantis karya Pidi Baiq yang berlatar masa SMA di Bandung.',
                'isbn' => '9786027870868',
                'bahasa' => 'ID',
                'cover_buku' => 'Dilan 1990.jpg',
            ],
            [
                'judul' => 'Ayat-Ayat Cinta',
                'deskripsi' => 'Novel religi karya Habiburrahman El Shirazy tentang kehidupan mahasiswa Indonesia di Mesir.',
                'isbn' => '9789793210791',
                'bahasa' => 'ID',
                'cover_buku' => 'Ayat-Ayat Cinta.jpg',
            ],
            [
                'judul' => "Harry Potter and the Philosopher's Stone",
                'deskripsi' => 'Novel fantasi karya J.K. Rowling tentang petualangan Harry Potter di Hogwarts.',
                'isbn' => '9780747532699',
                'bahasa' => 'EN',
                'cover_buku' => "Harry Potter and the Philosopher's Stone.jpg",
            ],
            [
                'judul' => 'A Study in Scarlet',
                'deskripsi' => 'Kumpulan kisah detektif legendaris karya Arthur Conan Doyle.',
                'isbn' => '9780486474919',
                'bahasa' => 'EN',
                'cover_buku' => 'A Study in Scarlet.jpg',
            ],
            [
                'judul' => 'Clean Code',
                'deskripsi' => 'Buku pembelajaran praktik menulis kode yang bersih.',
                'isbn' => '9780132350884',
                'bahasa' => 'EN',
                'cover_buku' => 'Clean Code.jpg',
            ],
            [
                'judul' => 'Computer Networking: A Top-Down Approach',
                'deskripsi' => 'Buku pembelajaran konsep jaringan komputer dan komunikasi data.',
                'isbn' => '9780136681557',
                'bahasa' => 'EN',
                'cover_buku' => 'Computer Networking A Top-Down Approach.jpg',
            ],
            [
                'judul' => 'Database System Concepts',
                'deskripsi' => 'Buku mengenai konsep database relasional dan implementasinya.',
                'isbn' => '9781260084504',
                'bahasa' => 'EN',
                'cover_buku' => 'Database System Concepts.jpg',
            ],
            [
                'judul' => 'Introduction to Algorithms',
                'deskripsi' => 'Buku pembelajaran algoritma dasar dan struktur data.',
                'isbn' => '9780262046305',
                'bahasa' => 'EN',
                'cover_buku' => 'Introduction to Algorithms.jpg',
            ],
            [
                'judul' => 'Discrete Mathematics and Its Applications',
                'deskripsi' => 'Materi matematika diskrit untuk mahasiswa informatika.',
                'isbn' => '9781259676512',
                'bahasa' => 'EN',
                'cover_buku' => 'Discrete Mathematics and Its Applications.jpg',
            ],
            [
                'judul' => 'Deep Work',
                'deskripsi' => 'Buku mengenai pentingnya fokus dalam bekerja.',
                'isbn' => '9781455586691',
                'bahasa' => 'EN',
                'cover_buku' => 'deepwork.jpg',
            ],
            [
                'judul' => 'Sapiens',
                'deskripsi' => 'Buku sejarah yang membahas perkembangan peradaban manusia.',
                'isbn' => '9780062316097',
                'bahasa' => 'EN',
                'cover_buku' => 'Sapiens.jpg',
            ],
            [
                'judul' => 'The Pragmatic Programmer',
                'deskripsi' => 'Panduan bagi software developer profesional.',
                'isbn' => '9780135957059',
                'bahasa' => 'EN',
                'cover_buku' => 'The Pragmatic Programmer.jpg',
            ],
            [
                'judul' => 'The Psychology of Money',
                'deskripsi' => 'Buku tentang psikologi manusia dalam mengelola keuangan.',
                'isbn' => '9780857197689',
                'bahasa' => 'EN',
                'cover_buku' => 'The Psychology of Money.jpg',
            ],
            [
                'judul' => 'Thinking, Fast and Slow',
                'deskripsi' => 'Buku karya Daniel Kahneman mengenai cara manusia berpikir.',
                'isbn' => '9780374533557',
                'bahasa' => 'EN',
                'cover_buku' => 'Thinking, Fast and Slow.jpg',
            ],
        ];

        foreach ($buku as $item) {

            $noRak = 'RAK-' . rand(1, 20);

            $suffix = strtoupper($faker->bothify('??##'));

            $coverPath = null;

            $source = public_path('coverBukuSeeder/' . $item['cover_buku']);

            if (File::exists($source)) {

                // Nama file baru agar tidak bentrok
                $fileName = Str::uuid() . '.' . File::extension($source);

                // Simpan ke storage/app/public/covers
                Storage::disk('public')->put(
                    'covers/' . $fileName,
                    File::get($source)
                );

                // Path yang disimpan ke database
                $coverPath = $fileName;
            }

            DB::table('buku')->insert([
                'id_tipe' => rand(1, 5),
                'kode_bahasa' => $item['bahasa'],
                'id_penerbit' => rand(1, 5),
                'isbn' => $item['isbn'],
                'judul_buku' => $item['judul'],
                'tanggal_terbit' => $faker->date(),
                'deskripsi' => $item['deskripsi'],
                'edisi' => 'Edisi ' . rand(1, 5),

                // Simpan path storage ke database
                'cover_buku' => $coverPath,

                'no_rak' => $noRak,
                'no_panggil' => $noRak . '-' . $suffix,
            ]);
        }
    }
}
