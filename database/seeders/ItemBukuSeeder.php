<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemBukuSeeder extends Seeder
{
    public function run(): void
    {
        $counter = 1;

        for ($buku = 1; $buku <= 20; $buku++) {

            for ($i = 1; $i <= 2; $i++) {

                DB::table('item_buku')->insert([

                    'id_item' => $this->generateItemCode($counter),

                    'id_buku' => $buku,

                    'status_item' => collect([
                        'Tersedia',
                        'Sedang Dipinjam',
                        'Dipesan',
                        'Tidak Aktif'
                    ])->random(),
                ]);

                $counter++;
            }
        }
    }

    private function generateItemCode($number)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $randomPart = function () use ($characters) {

            return collect(range(1, 4))
                ->map(
                    fn() =>
                    $characters[rand(0, strlen($characters) - 1)]
                )
                ->implode('');
        };

        return sprintf(
            '%s-%s-%s-%04d',
            $randomPart(),
            $randomPart(),
            $randomPart(),
            $number
        );
    }
}
