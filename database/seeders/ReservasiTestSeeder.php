<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservasiTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            // Sudah expired
            [
                'nomor_reservasi' => 'RSV0001',
                'id_anggota' => 1,
                'id_buku' => 1,
                'id_item' => null,
                'status' => 'Siap Diambil',
                'tanggal_ditambahkan' => Carbon::parse('2026-07-15 08:00:00'),
                'tanggal_diajukan' => Carbon::parse('2026-07-15 08:00:00'),
                'tanggal_diterima' => Carbon::parse('2026-07-16 09:00:00'),
                'tanggal_konfirmasi' => Carbon::parse('2026-07-16 09:15:00'),
                'tanggal_expired' => Carbon::parse('2026-07-19 23:59:59'),
                'tanggal_selesai' => null,
                'tanggal_dibuat' => Carbon::parse('2026-07-15 08:00:00'),
                'tanggal_diubah' => Carbon::parse('2026-07-16 09:15:00'),
            ],

            // Expired hari ini
            [
                'nomor_reservasi' => 'RSV0002',
                'id_anggota' => 2,
                'id_buku' => 2,
                'id_item' => null,
                'status' => 'Siap Diambil',
                'tanggal_ditambahkan' => Carbon::parse('2026-07-18 09:00:00'),
                'tanggal_diajukan' => Carbon::parse('2026-07-18 09:00:00'),
                'tanggal_diterima' => Carbon::parse('2026-07-19 10:00:00'),
                'tanggal_konfirmasi' => Carbon::parse('2026-07-19 10:15:00'),
                'tanggal_expired' => Carbon::parse('2026-07-20 23:59:59'),
                'tanggal_selesai' => null,
                'tanggal_dibuat' => Carbon::parse('2026-07-18 09:00:00'),
                'tanggal_diubah' => Carbon::parse('2026-07-19 10:15:00'),
            ],

            // Belum expired
            [
                'nomor_reservasi' => 'RSV0003',
                'id_anggota' => 3,
                'id_buku' => 3,
                'id_item' => null,
                'status' => 'Siap Diambil',
                'tanggal_ditambahkan' => Carbon::parse('2026-07-19 13:00:00'),
                'tanggal_diajukan' => Carbon::parse('2026-07-19 13:00:00'),
                'tanggal_diterima' => Carbon::parse('2026-07-20 08:00:00'),
                'tanggal_konfirmasi' => Carbon::parse('2026-07-20 08:15:00'),
                'tanggal_expired' => Carbon::parse('2026-07-22 23:59:59'),
                'tanggal_selesai' => null,
                'tanggal_dibuat' => Carbon::parse('2026-07-19 13:00:00'),
                'tanggal_diubah' => Carbon::parse('2026-07-20 08:15:00'),
            ],

        ];

        foreach ($data as $reservasi) {
            DB::table('reservasi')->updateOrInsert(
                [
                    'nomor_reservasi' => $reservasi['nomor_reservasi'],
                ],
                $reservasi
            );
        }

        $this->command->info('Reservasi test berhasil diinsert/update.');
    }
}
