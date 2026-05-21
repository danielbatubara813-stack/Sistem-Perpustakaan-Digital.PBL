<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenulisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penulis')->insert([
            [
                'nama_penulis' => 'Tere Liye',
                'tipe_penulis' => 'Nama Orang',
            ],
            [
                'nama_penulis' => 'Andrea Hirata',
                'tipe_penulis' => 'Nama Orang',
            ],
            [
                'nama_penulis' => 'Informatics Publisher',
                'tipe_penulis' => 'Badan Organisasi',
            ],
            [
                'nama_penulis' => 'Seminar Nasional Teknologi 2025',
                'tipe_penulis' => 'Konferensi',
            ],
        ]);
    }
}
