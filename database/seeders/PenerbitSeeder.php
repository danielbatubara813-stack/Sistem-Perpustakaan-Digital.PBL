<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerbitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penerbit')->insert([
            ['nama_penerbit' => 'Gramedia'],
            ['nama_penerbit' => 'Erlangga'],
            ['nama_penerbit' => 'Informatika'],
            ['nama_penerbit' => 'Andi Publisher'],
            ['nama_penerbit' => 'Deepublish'],
        ]);
    }
}
