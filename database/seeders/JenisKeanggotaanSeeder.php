<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKeanggotaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_keanggotaan')->insert([
            [
                'nama_jenis' => 'Mahasiswa',
            ],
            [
                'nama_jenis' => 'Dosen Tetap',
            ],
            [
                'nama_jenis' => 'Dosen Tidak Tetap',
            ],
        ]);
    }
}
