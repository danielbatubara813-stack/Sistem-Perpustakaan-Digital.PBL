<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanSeederTambahan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = DB::table('item_buku')
            ->pluck('id_item')
            ->toArray();

        for ($i = 1; $i <= 20; $i++) {

            $tanggalPinjam = Carbon::now()
                ->subDays(rand(1, 30));

            $idItem = $items[array_rand($items)];

            DB::table('peminjaman')->insert([
                'kode_peminjaman' => 'PJ' . strtoupper(Str::random(6)),

                'id_anggota' => rand(1, 20),

                'id_item' => $idItem,

                'tanggal_peminjaman' => $tanggalPinjam,

                'tanggal_jatuh_tempo' => $tanggalPinjam
                    ->copy()
                    ->addDays(7),

                'status' => 'Dipinjam',
            ]);

            DB::table('item_buku')
                ->where('id_item', $idItem)
                ->update([
                    'status_item' => 'Sedang Dipinjam'
                ]);
        }
    }
}
