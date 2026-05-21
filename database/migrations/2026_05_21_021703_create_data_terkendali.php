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
        Schema::create('tipe_koleksi', function (Blueprint $table) {
            $table->increments('id_tipe');
            $table->string('nama_tipe');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('subjek', function (Blueprint $table) {
            $table->increments('id_subjek');
            $table->string('nama_subjek');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('penulis', function (Blueprint $table) {
            $table->increments('id_penulis');
            $table->string('nama_penulis');
            $table->enum('tipe_penulis', ['Nama Orang', 'Badan Organisasi', 'Konferensi']);
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('penerbit', function (Blueprint $table) {
            $table->increments('id_penerbit');
            $table->string('nama_penerbit');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('dok_bahasa', function (Blueprint $table) {
            $table->increments('kode_bahasa');
            $table->string('nama_bahasa');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_koleksi');
        Schema::dropIfExists('subjek');
        Schema::dropIfExists('penulis');
        Schema::dropIfExists('penerbit');
        Schema::dropIfExists('dok_bahasa');
    }
};
