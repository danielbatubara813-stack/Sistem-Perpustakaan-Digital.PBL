<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE item_buku MODIFY status_item ENUM('Tersedia', 'Sedang Dipinjam', 'Dipinjam', 'Dipesan', 'Tidak Aktif', 'Tidak Tersedia') NOT NULL");
        }

        DB::table('item_buku')
            ->where('status_item', 'Sedang Dipinjam')
            ->update(['status_item' => 'Dipinjam']);

        DB::table('item_buku')
            ->where('status_item', 'Tidak Aktif')
            ->update(['status_item' => 'Tidak Tersedia']);

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE item_buku MODIFY status_item ENUM('Tersedia', 'Dipinjam', 'Dipesan', 'Tidak Tersedia') NOT NULL");
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE item_buku MODIFY status_item ENUM('Tersedia', 'Sedang Dipinjam', 'Dipinjam', 'Dipesan', 'Tidak Aktif', 'Tidak Tersedia') NOT NULL");
        }

        DB::table('item_buku')
            ->where('status_item', 'Dipinjam')
            ->update(['status_item' => 'Sedang Dipinjam']);

        DB::table('item_buku')
            ->where('status_item', 'Tidak Tersedia')
            ->update(['status_item' => 'Tidak Aktif']);

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE item_buku MODIFY status_item ENUM('Tersedia', 'Sedang Dipinjam', 'Dipesan', 'Tidak Aktif') NOT NULL");
        }
    }
};
