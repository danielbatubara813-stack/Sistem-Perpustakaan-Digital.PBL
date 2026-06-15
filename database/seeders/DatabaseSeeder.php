<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                // Master Data
            JenisKeanggotaanSeeder::class,
            TipeKoleksiSeeder::class,
            SubjekSeeder::class,
            PenulisSeeder::class,
            PenerbitSeeder::class,
            DokBahasaSeeder::class,

                // User
            AdminSeeder::class,
            AnggotaSeeder::class,

                // Buku
            BukuSeeder::class,
            SubjekBukuSeeder::class,
            PenulisBukuSeeder::class,
            ItemBukuSeeder::class,

                // Peminjaman
            AturanPeminjamanSeeder::class,
            PeminjamanSeeder::class,
            PengembalianSeeder::class,
            
            // Reservasi
            ReservasiSeeder::class,
            PeminjamanSeederTambahan::class,
        ]);
    }
}
