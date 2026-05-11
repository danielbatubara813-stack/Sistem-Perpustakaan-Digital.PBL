<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function ambilDataBuku()
    {
        $koleksi_baru = [
            [
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'cover' => 'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
                'isbn' => '9786024246945',
                'last_update' => '2026-04-02',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                'isbn' => '9786230010460',
                'last_update' => '2026-04-12',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'The Next.js Handbook: A Complete Resource for Developers',
                'penulis' => 'Brandon Kim',
                'cover' => 'https://m.media-amazon.com/images/I/518LETZYITL._AC_UF1000,1000_QL80_.jpg',
                'isbn' => '9781803235929',
                'last_update' => '2026-04-15',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Akuntansi Dasar Untuk Bisnis: Teori dan Praktik',
                'penulis' => 'Ely Suhayati',
                'cover' => 'https://palcomtech.ac.id/wp-content/uploads/2023/08/lr7ddjapfkqm3e6qut3rnk.jpg',
                'isbn' => '9786232287655',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Buku Internet of Things (IoT) dan Aplikasinya',
                'penulis' => 'Adhan Efendi',
                'cover' => 'https://deepublishstore.com/wp-content/uploads/2024/06/Internet-Of-Things-IoT-dan-Aplikasinya_Adhan-Efendi-rev-1.0-depan-scaled.jpg',
                'isbn' => '9786230269370',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Blockchain: Dari Konsep hingga Implementasi',
                'penulis' => 'Achmad Fitro, S. Kom., M.Kom, dkk.',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/l0c-7t4hx1.jpg',
                'isbn' => '9786230225475',
                'last_update' => '2026-04-18',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020333175_rich-dad-poor-dad-_edisi-revisi_.jpg',
                'isbn' => '9786020333175',
                'last_update' => '2026-04-11',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'cover' => 'https://m.media-amazon.com/images/I/41xShlnTZTL.jpg',
                'isbn' => '9780132350884',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'cover' => 'https://m.media-amazon.com/images/I/91bYsX41DVL.jpg',
                'isbn' => '9780735211292',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Database System Concepts',
                'penulis' => 'Abraham Silberschatz',
                'cover' => 'https://m.media-amazon.com/images/I/51mFoFmu0EL.jpg',
                'isbn' => '9780078022159',
                'last_update' => '2026-04-09',
                'jumlah_copy' => 2,
            ],
        ];

        return $koleksi_baru;
    }
    public function listBuku()
    {
        $books = $this->ambilDataBuku();

        return view('admin.buku.buku', compact('books'));
    }

    public function create()
    {
        return view('admin.buku.form-buku');
    }
}
