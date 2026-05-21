<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReservasiSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {

            $tanggalDiajukan = Carbon::now()
                ->subDays(rand(1, 30));

            $status = collect([
                'Menunggu',
                'Ditolak',
                'Diterima'
            ])->random();

            DB::table('reservasi')->insert([

                'id_anggota' => rand(1, 20),

                'id_buku' => rand(1, 20),

                'tanggal_diajukan' => $tanggalDiajukan,

                'tanggal_reservasi' => $status == 'Menunggu'
                    ? null
                    : $tanggalDiajukan->copy()->addDays(rand(1, 3)),

                'tanggal_dikonfirmasi' => $status == 'Menunggu'
                    ? null
                    : $tanggalDiajukan->copy()->addDays(rand(1, 2)),

                'status' => $status,
            ]);
        }
    }
}
