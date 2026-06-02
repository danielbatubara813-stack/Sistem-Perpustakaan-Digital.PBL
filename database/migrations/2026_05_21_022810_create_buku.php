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
        Schema::create('buku', function (Blueprint $table) {
            $table->increments('id_buku');
            $table->integer('id_tipe')->unsigned();
            $table->string('kode_bahasa', 2);
            $table->integer('id_penerbit')->unsigned();
            $table->string('isbn', 13)->unique();
            $table->string('judul_buku');
            $table->date('tanggal_terbit');
            $table->text('deskripsi');
            $table->string('edisi');
            $table->binary('cover_buku')->nullable();
            $table->string('no_panggil');
            $table->string('no_rak');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_tipe')->references('id_tipe')->on('tipe_koleksi');
            $table->foreign('kode_bahasa')->references('kode_bahasa')->on('dok_bahasa');
            $table->foreign('id_penerbit')->references('id_penerbit')->on('penerbit');
        });

        Schema::create('subjek_buku', function (Blueprint $table) {
            $table->integer('id_subjek')->unsigned();
            $table->integer('id_buku')->unsigned();

            $table->foreign('id_subjek')->references('id_subjek')->on('subjek');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
        });

        Schema::create('penulis_buku', function (Blueprint $table) {
            $table->integer('id_penulis')->unsigned();
            $table->integer('id_buku')->unsigned();

            $table->foreign('id_penulis')->references('id_penulis')->on('penulis');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
        });

        Schema::create('item_buku', function (Blueprint $table) {
            $table->string('id_item', 19)->primary();
            $table->integer('id_buku')->unsigned();
            $table->enum('status_item', ['Tersedia', 'Sedang Dipinjam', 'Dipesan', 'Tidak Aktif']);
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_buku')->references('id_buku')->on('buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_buku');
        Schema::dropIfExists('penulis_buku');
        Schema::dropIfExists('subjek_buku');
        Schema::dropIfExists('buku');
    }
};
