<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan opsi 'NIDN' ke enum jenis_nomor_identitas
        DB::statement("ALTER TABLE anggota MODIFY jenis_nomor_identitas ENUM('NIM','NIBN','NIDN') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan seperti semula (tanpa NIDN)
        DB::statement("ALTER TABLE anggota MODIFY jenis_nomor_identitas ENUM('NIM','NIBN') NOT NULL");
    }
};
