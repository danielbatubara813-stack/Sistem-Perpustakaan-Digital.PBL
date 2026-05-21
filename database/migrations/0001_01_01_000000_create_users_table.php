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
        Schema::create('jenis_keanggotaan', function (Blueprint $table) {
            $table->increments('id_jenis');
            $table->string('nama_jenis');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('anggota', function (Blueprint $table) {
            $table->increments('id_anggota');
            $table->integer('id_jenis')->unsigned();
            $table->string('nomor_identitas')->length(10)->unique();
            $table->enum('jenis_nomor_identitas', ['NIM', 'NIBN']);
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('no_hp')->length(15)->unique();
            $table->enum('status_anggota', ["Aktif", "Tidak Aktif"]);
            $table->enum('jenis_kelamin', ["Laki-Laki", "Perempuan"]);
            $table->date('tanggal_lahir');
            $table->binary('profile')->nullable();
            $table->enum('verifikasi_admin', ['Menunggu', "Terverifikasi", "Ditolak"]);
            $table->binary('foto_ktp')->nullable();
            $table->string('password');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_keanggotaan');
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('username')->length(15)->unique();
            $table->string('password');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->uuid('id_token')->primary();
            $table->integer('id_anggota')->unsigned();
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();

            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_anggota');
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
