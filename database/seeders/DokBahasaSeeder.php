<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokBahasaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dok_bahasa')->insert([
            ['kode_bahasa' => 'ID', 'nama_bahasa' => 'Indonesia'],
            ['kode_bahasa' => 'EN','nama_bahasa' => 'Inggris'],
        ]);
    }
}
