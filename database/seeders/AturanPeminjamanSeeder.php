<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AturanPeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('aturan_peminjaman')->insert([

            [
                'id_jenis' => null,
                'id_tipe' => null,
                'periode_peminjaman' => 7,
                'batas_peminjaman' => 2,
            ],
            [
                'id_jenis' => 1,
                'id_tipe' => 1,
                'periode_peminjaman' => 7,
                'batas_peminjaman' => 5,
            ],

            [
                'id_jenis' => 1,
                'id_tipe' => 2,
                'periode_peminjaman' => 5,
                'batas_peminjaman' => 3,
            ],

            [
                'id_jenis' => 2,
                'id_tipe' => 1,
                'periode_peminjaman' => 14,
                'batas_peminjaman' => 10,
            ],

            [
                'id_jenis' => 2,
                'id_tipe' => 3,
                'periode_peminjaman' => 10,
                'batas_peminjaman' => 5,
            ],

            [
                'id_jenis' => 3,
                'id_tipe' => 1,
                'periode_peminjaman' => 5,
                'batas_peminjaman' => 2,
            ],
        ]);
    }
}
