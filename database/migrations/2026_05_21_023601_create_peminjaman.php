<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('kode_peminjaman', 8)->primary();
            $table->integer('id_anggota')->unsigned();
            $table->string('id_item', 19);
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['Dipinjam', 'Dikembalikan', "Terlambat"]);
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->foreign('id_item')->references('id_item')->on('item_buku');
        });

        Schema::create('aturan_peminjaman', function (Blueprint $table) {
            $table->increments('id_aturan');
            $table->integer('id_jenis')->unsigned()->nullable();
            $table->integer('id_tipe')->unsigned()->nullable();
            $table->unsignedTinyInteger('periode_peminjaman')->default(7);
            $table->unsignedTinyInteger('batas_peminjaman')->default(2);
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_keanggotaan');
            $table->foreign('id_tipe')->references('id_tipe')->on('tipe_koleksi');
        });

        Schema::create('pengembalian', function (Blueprint $table) {
            $table->increments('id_pengembalian');
            $table->string('kode_peminjaman', 8);
            $table->date('tanggal_pengembalian');
            $table->integer('total_denda');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('kode_peminjaman')->references('kode_peminjaman')->on('peminjaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
        Schema::dropIfExists('aturan_peminjaman');
        Schema::dropIfExists('peminjaman');
    }
};
