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
            ['nama_bahasa' => 'Indonesia'],
            ['nama_bahasa' => 'Inggris'],
        ]);
    }
}
