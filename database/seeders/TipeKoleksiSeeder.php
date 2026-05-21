<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeKoleksiSeeder extends Seeder
{
    public function run(): void
    {
        DB  ::table('tipe_koleksi')->insert([
            ['nama_tipe' => 'Buku'],
            ['nama_tipe' => 'Jurnal'],
            ['nama_tipe' => 'Majalah'],
            ['nama_tipe' => 'Skripsi'],
            ['nama_tipe' => 'E-Book'],
        ]);
    }
}
