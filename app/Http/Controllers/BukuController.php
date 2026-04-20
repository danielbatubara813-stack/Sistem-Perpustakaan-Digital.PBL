<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function cariBukuPage()
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
                'deskripsi' => 'Novel yang mengangkat kisah aktivis mahasiswa pada masa Orde Baru, tentang perjuangan, kehilangan, dan keluarga yang mencari keadilan.',
            ],
            [
                'id' => 2,
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230010460',
                'no_panggil' => '005.262 YUN s',
                'deskripsi' => 'Panduan dasar framework Laravel untuk pemula, membahas routing, controller, model, database, CRUD, dan pembuatan aplikasi web modern.',
            ],
            [
                'id' => 3,
                'judul' => 'The Next.js Handbook: A Complete Resource for Developers',
                'penulis' => 'Brandon Kim',
                'cover' => 'https://m.media-amazon.com/images/I/518LETZYITL._AC_UF1000,1000_QL80_.jpg',
                'edisi' => '1st Edition',
                'isbn' => '9781803235929',
                'no_panggil' => '005.276 BRA t',
                'deskripsi' => 'Buku pengembangan web modern menggunakan Next.js, mencakup SSR, SSG, routing, API routes, deployment, dan best practice React ecosystem.',
            ],
            [
                'id' => 4,
                'judul' => 'Akuntansi Dasar Untuk Bisnis: Teori dan Praktik',
                'penulis' => 'Ely Suhayati',
                'cover' => 'https://palcomtech.ac.id/wp-content/uploads/2023/08/lr7ddjapfkqm3e6qut3rnk.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786232287655',
                'no_panggil' => '657 ELY a',
                'deskripsi' => 'Membahas konsep dasar akuntansi, pencatatan transaksi, jurnal umum, buku besar, laporan keuangan, dan penerapannya dalam bisnis.',
            ],
            [
                'id' => 5,
                'judul' => 'Buku Internet of Things (IoT) dan Aplikasinya',
                'penulis' => 'Adhan Efendi',
                'cover' => 'https://deepublishstore.com/wp-content/uploads/2024/06/Internet-Of-Things-IoT-dan-Aplikasinya_Adhan-Efendi-rev-1.0-depan-scaled.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230269370',
                'no_panggil' => '004.678 ADH i',
                'deskripsi' => 'Mengenalkan konsep Internet of Things, sensor, mikrokontroler, komunikasi data, cloud integration, dan implementasi IoT di berbagai bidang.',
            ],
            [
                'id' => 6,
                'judul' => 'Blockchain: Dari Konsep hingga Implementasi',
                'penulis' => 'Achmad Fitro, S. Kom., M.Kom, dkk.',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/l0c-7t4hx1.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230225475',
                'no_panggil' => '005.824 ACH b',
                'deskripsi' => 'Menjelaskan teknologi blockchain dari dasar, mekanisme distributed ledger, smart contract, cryptocurrency, hingga implementasi di industri.',
            ],
            [
                'id' => 7,
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020333175_rich-dad-poor-dad-_edisi-revisi_.jpg',
                'edisi' => 'Edisi Revisi',
                'isbn' => '9786020333175',
                'no_panggil' => '332.024 KIY r',
                'deskripsi' => 'Buku finansial populer tentang perbedaan pola pikir antara bekerja demi uang dan membuat uang bekerja untuk kita melalui investasi dan aset.',
            ],
        ];
        return view('caribuku', compact('koleksi_baru'));
    }

    public function detailBukuPage($id_buku)
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
                'deskripsi' => 'Novel yang mengangkat kisah aktivis mahasiswa pada masa Orde Baru, tentang perjuangan, kehilangan, dan keluarga yang mencari keadilan.',
            ],
            [
                'id' => 2,
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230010460',
                'no_panggil' => '005.262 YUN s',
                'deskripsi' => 'Panduan dasar framework Laravel untuk pemula, membahas routing, controller, model, database, CRUD, dan pembuatan aplikasi web modern.',
            ],
            [
                'id' => 3,
                'judul' => 'The Next.js Handbook: A Complete Resource for Developers',
                'penulis' => 'Brandon Kim',
                'cover' => 'https://m.media-amazon.com/images/I/518LETZYITL._AC_UF1000,1000_QL80_.jpg',
                'edisi' => '1st Edition',
                'isbn' => '9781803235929',
                'no_panggil' => '005.276 BRA t',
                'deskripsi' => 'Buku pengembangan web modern menggunakan Next.js, mencakup SSR, SSG, routing, API routes, deployment, dan best practice React ecosystem.',
            ],
            [
                'id' => 4,
                'judul' => 'Akuntansi Dasar Untuk Bisnis: Teori dan Praktik',
                'penulis' => 'Ely Suhayati',
                'cover' => 'https://palcomtech.ac.id/wp-content/uploads/2023/08/lr7ddjapfkqm3e6qut3rnk.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786232287655',
                'no_panggil' => '657 ELY a',
                'deskripsi' => 'Membahas konsep dasar akuntansi, pencatatan transaksi, jurnal umum, buku besar, laporan keuangan, dan penerapannya dalam bisnis.',
            ],
            [
                'id' => 5,
                'judul' => 'Buku Internet of Things (IoT) dan Aplikasinya',
                'penulis' => 'Adhan Efendi',
                'cover' => 'https://deepublishstore.com/wp-content/uploads/2024/06/Internet-Of-Things-IoT-dan-Aplikasinya_Adhan-Efendi-rev-1.0-depan-scaled.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230269370',
                'no_panggil' => '004.678 ADH i',
                'deskripsi' => 'Mengenalkan konsep Internet of Things, sensor, mikrokontroler, komunikasi data, cloud integration, dan implementasi IoT di berbagai bidang.',
            ],
            [
                'id' => 6,
                'judul' => 'Blockchain: Dari Konsep hingga Implementasi',
                'penulis' => 'Achmad Fitro, S. Kom., M.Kom, dkk.',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/l0c-7t4hx1.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230225475',
                'no_panggil' => '005.824 ACH b',
                'deskripsi' => 'Menjelaskan teknologi blockchain dari dasar, mekanisme distributed ledger, smart contract, cryptocurrency, hingga implementasi di industri.',
            ],
            [
                'id' => 7,
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020333175_rich-dad-poor-dad-_edisi-revisi_.jpg',
                'edisi' => 'Edisi Revisi',
                'isbn' => '9786020333175',
                'no_panggil' => '332.024 KIY r',
                'deskripsi' => 'Buku finansial populer tentang perbedaan pola pikir antara bekerja demi uang dan membuat uang bekerja untuk kita melalui investasi dan aset.',
            ],
        ];

        $buku = collect($koleksi_baru)->firstWhere('id', $id_buku);
        return view('detail-buku', compact('buku'));
    }
}
