<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjekSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subjek')->insert([
            ['nama_subjek' => 'Teknologi'],
            ['nama_subjek' => 'Pemrograman'],
            ['nama_subjek' => 'Jaringan Komputer'],
            ['nama_subjek' => 'Basis Data'],
            ['nama_subjek' => 'Kecerdasan Buatan'],
            ['nama_subjek' => 'Desain UI/UX'],
        ]);
    }
}
