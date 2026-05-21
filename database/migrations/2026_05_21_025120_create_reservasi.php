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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->increments('id_reservasi');
            $table->integer('id_anggota')->unsigned();
            $table->integer('id_buku')->unsigned();
            $table->date('tanggal_diajukan')->nullable();
            $table->date('tanggal_reservasi')->nullable();
            $table->date('tanggal_dikonfirmasi')->nullable();
            $table->enum('status', ['Menunggu', 'Ditolak', 'Diterima'])->nullable();
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
