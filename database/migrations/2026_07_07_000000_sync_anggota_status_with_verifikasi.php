<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('anggota')
            ->whereIn('verifikasi_admin', ['Menunggu', 'Ditolak'])
            ->update(['status_anggota' => 'Tidak Aktif']);

        DB::table('anggota')
            ->where('verifikasi_admin', 'Terverifikasi')
            ->update(['status_anggota' => 'Aktif']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
