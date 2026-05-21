<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'username' => 'petugas',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
