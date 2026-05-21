<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenulisBukuSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {

            DB::table('penulis_buku')->insert([
                'id_penulis' => rand(1, 4),
                'id_buku' => $i,
            ]);
        }
    }
}
