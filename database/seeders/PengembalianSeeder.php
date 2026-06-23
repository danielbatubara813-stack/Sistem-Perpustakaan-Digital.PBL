<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        $peminjaman = Peminjaman::take(12)->get();

        foreach ($peminjaman as $pinjam) {

            DB::table('pengembalian')->insert([
                'kode_peminjaman' => $pinjam->kode_peminjaman,
                'total_denda' => 0,
                'tanggal_pengembalian' => Carbon::now()
                    ->subDays(rand(1, 10)),
            ]);

            $pinjam->update([
                'status' => 'Dikembalikan'
            ]);
        }
    }
}