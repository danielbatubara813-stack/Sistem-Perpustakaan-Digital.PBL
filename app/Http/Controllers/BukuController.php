<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function ambilDataBuku()
    {
        $koleksi_baru = [
            [
                'id' => 1,
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'cover' => 'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
                'edisi' => 'Cet. 1',
                'isbn' => '9786024246945',
                'no_panggil' => '813 LEI l',
                'tahun' => 2017,
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'bahasa' => 'Indonesia',
                'halaman' => 379,
                'subject' => ['Fiksi', 'Sejarah', 'Sosial Politik', 'Novel Indonesia'],
                'deskripsi' => 'Novel yang mengangkat kisah aktivis mahasiswa pada masa Orde Baru, tentang perjuangan, kehilangan, dan keluarga yang mencari keadilan.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (813)',
                        'nomor_panggil' => '813 LEI l',
                        'nomor_item' => 'BK001245',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                    [
                        'lokasi' => '#Perpustakaan Polibatam (813)',
                        'nomor_panggil' => '813 LEI l',
                        'nomor_item' => 'BK001246',
                        'status' => 'Sedang Dipinjam',
                        'tanggal_pinjam' => '02-04-2026',
                    ],
                ],
            ],

            [
                'id' => 2,
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230010460',
                'no_panggil' => '005.262 YUN s',
                'tahun' => 2022,
                'penerbit' => 'Elex Media',
                'bahasa' => 'Indonesia',
                'halaman' => 320,
                'subject' => ['Programming', 'Laravel', 'PHP', 'Web Development'],
                'deskripsi' => 'Panduan dasar framework Laravel untuk pemula, membahas routing, controller, model, database, CRUD, dan pembuatan aplikasi web modern.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.262 YUN s',
                        'nomor_item' => 'BK001300',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.262 YUN s',
                        'nomor_item' => 'BK001301',
                        'status' => 'Sedang Dipinjam',
                        'tanggal_pinjam' => '12-04-2026',
                    ],
                ],
            ],

            [
                'id' => 3,
                'judul' => 'The Next.js Handbook: A Complete Resource for Developers',
                'penulis' => 'Brandon Kim',
                'cover' => 'https://m.media-amazon.com/images/I/518LETZYITL._AC_UF1000,1000_QL80_.jpg',
                'edisi' => '1st Edition',
                'isbn' => '9781803235929',
                'no_panggil' => '005.276 BRA t',
                'tahun' => 2023,
                'penerbit' => 'Packt Publishing',
                'bahasa' => 'English',
                'halaman' => 410,
                'subject' => ['Programming', 'Next.js', 'React', 'Technology', 'Frontend'],
                'deskripsi' => 'Buku pengembangan web modern menggunakan Next.js, mencakup SSR, SSG, routing, API routes, deployment, dan best practice React ecosystem.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.276 BRA t',
                        'nomor_item' => 'BK001350',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.276 BRA t',
                        'nomor_item' => 'BK001351',
                        'status' => 'Sedang Dipinjam',
                        'tanggal_pinjam' => '15-04-2026',
                    ],
                ],
            ],

            [
                'id' => 4,
                'judul' => 'Akuntansi Dasar Untuk Bisnis: Teori dan Praktik',
                'penulis' => 'Ely Suhayati',
                'cover' => 'https://palcomtech.ac.id/wp-content/uploads/2023/08/lr7ddjapfkqm3e6qut3rnk.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786232287655',
                'no_panggil' => '657 ELY a',
                'tahun' => 2021,
                'penerbit' => 'Deepublish',
                'bahasa' => 'Indonesia',
                'halaman' => 290,
                'subject' => ['Akuntansi', 'Bisnis', 'Keuangan', 'Ekonomi'],
                'deskripsi' => 'Membahas konsep dasar akuntansi, pencatatan transaksi, jurnal umum, buku besar, laporan keuangan, dan penerapannya dalam bisnis.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (657)',
                        'nomor_panggil' => '657 ELY a',
                        'nomor_item' => 'BK001400',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                ],
            ],

            [
                'id' => 5,
                'judul' => 'Buku Internet of Things (IoT) dan Aplikasinya',
                'penulis' => 'Adhan Efendi',
                'cover' => 'https://deepublishstore.com/wp-content/uploads/2024/06/Internet-Of-Things-IoT-dan-Aplikasinya_Adhan-Efendi-rev-1.0-depan-scaled.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230269370',
                'no_panggil' => '004.678 ADH i',
                'tahun' => 2024,
                'penerbit' => 'Deepublish',
                'bahasa' => 'Indonesia',
                'halaman' => 275,
                'subject' => ['IoT', 'Teknologi', 'Embedded System', 'Networking'],
                'deskripsi' => 'Mengenalkan konsep Internet of Things, sensor, mikrokontroler, komunikasi data, cloud integration, dan implementasi IoT di berbagai bidang.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (004)',
                        'nomor_panggil' => '004.678 ADH i',
                        'nomor_item' => 'BK001450',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                ],
            ],
            [
                'id' => 6,
                'judul' => 'Blockchain: Dari Konsep hingga Implementasi',
                'penulis' => 'Achmad Fitro, S. Kom., M.Kom, dkk.',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/l0c-7t4hx1.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230225475',
                'no_panggil' => '005.824 ACH b',
                'tahun' => 2023,
                'penerbit' => 'Gramedia',
                'bahasa' => 'Indonesia',
                'halaman' => 310,
                'subject' => ['Blockchain', 'Teknologi', 'Cryptocurrency', 'Keamanan Sistem'],
                'deskripsi' => 'Menjelaskan teknologi blockchain dari dasar, mekanisme distributed ledger, smart contract, cryptocurrency, hingga implementasi di industri.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.824 ACH b',
                        'nomor_item' => 'BK001500',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.824 ACH b',
                        'nomor_item' => 'BK001501',
                        'status' => 'Sedang Dipinjam',
                        'tanggal_pinjam' => '18-04-2026',
                    ],
                ],
            ],

            [
                'id' => 7,
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020333175_rich-dad-poor-dad-_edisi-revisi_.jpg',
                'edisi' => 'Edisi Revisi',
                'isbn' => '9786020333175',
                'no_panggil' => '332.024 KIY r',
                'tahun' => 2018,
                'penerbit' => 'Gramedia Pustaka Utama',
                'bahasa' => 'Indonesia',
                'halaman' => 244,
                'subject' => ['Keuangan', 'Investasi', 'Bisnis', 'Pengembangan Diri'],
                'deskripsi' => 'Buku finansial populer tentang perbedaan pola pikir antara bekerja demi uang dan membuat uang bekerja untuk kita melalui investasi dan aset.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (332)',
                        'nomor_panggil' => '332.024 KIY r',
                        'nomor_item' => 'BK001550',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                    [
                        'lokasi' => '#Perpustakaan Polibatam (332)',
                        'nomor_panggil' => '332.024 KIY r',
                        'nomor_item' => 'BK001551',
                        'status' => 'Sedang Dipinjam',
                        'tanggal_pinjam' => '11-04-2026',
                    ],
                ],
            ],

            [
                'id' => 8,
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'cover' => 'https://m.media-amazon.com/images/I/41xShlnTZTL.jpg',
                'edisi' => '1st Edition',
                'isbn' => '9780132350884',
                'no_panggil' => '005.1 MAR c',
                'tahun' => 2008,
                'penerbit' => 'Prentice Hall',
                'bahasa' => 'English',
                'halaman' => 464,
                'subject' => ['Programming', 'Software Engineering', 'Best Practice', 'Clean Code'],
                'deskripsi' => 'Panduan menulis kode yang bersih, mudah dibaca, mudah dirawat, dan profesional untuk software developer.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.1 MAR c',
                        'nomor_item' => 'BK001600',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                ],
            ],

            [
                'id' => 9,
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'cover' => 'https://m.media-amazon.com/images/I/91bYsX41DVL.jpg',
                'edisi' => '1st Edition',
                'isbn' => '9780735211292',
                'no_panggil' => '158.1 CLE a',
                'tahun' => 2018,
                'penerbit' => 'Avery',
                'bahasa' => 'English',
                'halaman' => 320,
                'subject' => ['Self Improvement', 'Produktivitas', 'Psikologi', 'Motivasi'],
                'deskripsi' => 'Membahas bagaimana kebiasaan kecil yang dilakukan konsisten dapat menghasilkan perubahan besar dalam hidup.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (158)',
                        'nomor_panggil' => '158.1 CLE a',
                        'nomor_item' => 'BK001650',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                ],
            ],

            [
                'id' => 10,
                'judul' => 'Database System Concepts',
                'penulis' => 'Abraham Silberschatz',
                'cover' => 'https://m.media-amazon.com/images/I/51mFoFmu0EL.jpg',
                'edisi' => '7th Edition',
                'isbn' => '9780078022159',
                'no_panggil' => '005.74 SIL d',
                'tahun' => 2019,
                'penerbit' => 'McGraw-Hill',
                'bahasa' => 'English',
                'halaman' => 1376,
                'subject' => ['Database', 'SQL', 'Data Modeling', 'Computer Science'],
                'deskripsi' => 'Referensi lengkap mengenai konsep basis data, SQL, transaction, concurrency control, indexing, dan distributed database.',
                'copy' => [
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.74 SIL d',
                        'nomor_item' => 'BK001700',
                        'status' => 'Tersedia',
                        'tanggal_pinjam' => null,
                    ],
                    [
                        'lokasi' => '#Perpustakaan Polibatam (005)',
                        'nomor_panggil' => '005.74 SIL d',
                        'nomor_item' => 'BK001701',
                        'status' => 'Sedang Dipinjam',
                        'tanggal_pinjam' => '09-04-2026',
                    ],
                ],
            ],
        ];

        return $koleksi_baru;
    }
    public function cariBukuPage()
    {
        $koleksi_baru = $this->ambilDataBuku();
        return view('caribuku', compact('koleksi_baru'));
    }

    public function detailBukuPage($id_buku)
    {

        $koleksi_baru = $this->ambilDataBuku();

        $buku = collect($koleksi_baru)->firstWhere('id', $id_buku);
        return view('detail-buku', compact('buku'));
    }
}
