<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 20; $i++) {

            $jenisIdentitas = $faker->randomElement([
                'NIM',
                'NIBN',
            ]);

            $verifikasiAdmin = $faker->randomElement([
                'Menunggu',
                'Terverifikasi',
                'Ditolak',
            ]);

            DB::table('anggota')->insert([
                'id_jenis' => rand(1, 3),

                'nomor_identitas' => str_pad(
                    $i,
                    10,
                    '0',
                    STR_PAD_LEFT
                ),

                'jenis_nomor_identitas' => $jenisIdentitas,

                'email' => $faker->unique()->safeEmail(),

                'nama' => $faker->name(),

                'no_hp' => '08'.$faker->numerify('##########'),

                'status_anggota' => $verifikasiAdmin === 'Terverifikasi'
                    ? 'Aktif'
                    : 'Tidak Aktif',

                'jenis_kelamin' => $faker->randomElement([
                    'Laki-Laki',
                    'Perempuan',
                ]),

                'tanggal_lahir' => $faker->date(),

                'profile' => null,

                'verifikasi_admin' => $verifikasiAdmin,

                'foto_ktp' => null,

                'password' => Hash::make('password'),
            ]);
        }
    }
}
