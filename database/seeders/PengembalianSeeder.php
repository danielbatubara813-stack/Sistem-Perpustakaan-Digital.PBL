<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 12; $i++) {

            DB::table('pengembalian')->insert([

                'kode_peminjaman' => 'PJ' . str_pad(
                    $i,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
                'total_denda' => 0,

                'tanggal_pengembalian' => Carbon::now()
                    ->subDays(rand(1, 10)),
            ]);
        }
    }
}
