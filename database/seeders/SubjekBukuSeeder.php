<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjekBukuSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {

            DB::table('subjek_buku')->insert([
                'id_subjek' => rand(1, 6),
                'id_buku' => $i,
            ]);
        }
    }
}
