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

            $table->string('nomor_reservasi')->primary();
            // siapa yang melakukan reservasi
            $table->integer('id_anggota')->unsigned();
            // reservasi berdasarkan judul buku
            $table->integer('id_buku')->unsigned();
            // copy buku yang dialokasikan ketika tersedia
            $table->string('id_item', 19)->nullable();

            $table->enum('status', [
                'Draft',
                'Menunggu Konfirmasi',
                'Menunggu Antrian',
                'Siap Diambil',
                'Selesai',
                'Ditolak',
                'Kadaluarsa',
                'Dibatalkan'
            ])->default('Draft');
            $table->timestamp('tanggal_ditambahkan')->useCurrent();
            // waktu user meminta reservasi
            $table->dateTime('tanggal_diajukan');
            // ketika sistem memberikan copy buku
            $table->dateTime('tanggal_diterima')->nullable();
            // ketika admin menkonfirmasi reservasi buku
            $table->dateTime('tanggal_konfirmasi')->nullable();
            // batas waktu pengambilan buku
            $table->dateTime('tanggal_expired')->nullable();
            // kapan reservasi berubah menjadi peminjaman
            $table->dateTime('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
            $table->foreign('id_item')->references('id_item')->on('item_buku');

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
