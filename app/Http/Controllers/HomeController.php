<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homePage()
    {
        // data buku sementara secara dummy tanpa integrasi databasse
        $koleksi_baru = [
            [
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'cover' => 'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
            ],
            [
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
            ],
            [
                'judul' => 'The Next.js Handbook A Complete Resource for Developers',
                'penulis' => 'Brandon Kim',
                'cover' => 'https://m.media-amazon.com/images/I/518LETZYITL._AC_UF1000,1000_QL80_.jpg',
            ],
            [
                'judul' => 'Akuntansi Dasar Untuk Bisnis Teori dan Praktik',
                'penulis' => 'Ely Suhayati',
                'cover' => 'https://palcomtech.ac.id/wp-content/uploads/2023/08/lr7ddjapfkqm3e6qut3rnk.jpg',
            ],
            [
                'judul' => 'Buku Internet of Things (IoT) dan Aplikasinya',
                'penulis' => 'Adhan Efendi',
                'cover' => 'https://deepublishstore.com/wp-content/uploads/2024/06/Internet-Of-Things-IoT-dan-Aplikasinya_Adhan-Efendi-rev-1.0-depan-scaled.jpg',
            ],
            [
                'judul' => 'Blockchain: Dari Konsep hingga Implementasi',
                'penulis' => 'Achmad Fitro, S. Kom., M.Kom, dkk.',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/l0c-7t4hx1.jpg',
            ],
            [
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020333175_rich-dad-poor-dad-_edisi-revisi_.jpg',
            ],
        ];

        // Data penikmat koleksi
        $penikmat_koleksi = [
            [
                'nama' => 'Ethan Walker',
                'jenis_keanggotaan' => 'Mahasiswa',
                'total_peminjaman' => '18',
                'total_buku' => '10',
                'profile' => 'https://i.pinimg.com/736x/e1/4a/83/e14a8371f954ca9c153ba39cb4af9b87.jpg'
            ],
            [
                'nama' => 'Sophia Turner',
                'jenis_keanggotaan' => 'Mahasiswa',
                'total_peminjaman' => '14',
                'total_buku' => '11',
                'profile' => 'https://i.pinimg.com/1200x/1c/9a/f2/1c9af20e150ee3a659354c9d328d0284.jpg'
            ],
            [
                'nama' => 'Lucas Anderson',
                'jenis_keanggotaan' => 'Mahasiswa',
                'total_peminjaman' => '12',
                'total_buku' => '8',
                'profile' => 'https://i.pinimg.com/1200x/8f/57/20/8f5720a971ba30c735213e9429c7a7e2.jpg'
            ],

        ];
        return view('home', compact('koleksi_baru', 'penikmat_koleksi'));
    }
}
