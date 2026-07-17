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
            $table->string('nomor_identitas', 10)->unique();
            $table->enum('jenis_nomor_identitas', ['NIM', 'NIBN']);
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('no_hp', 15)->unique();
            $table->enum('status_anggota', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('profile')->nullable();
            $table->enum('verifikasi_admin', ['Menunggu', 'Terverifikasi', 'Ditolak'])->default('Menunggu');
            $table->string('foto_ktp')->nullable();
            $table->string('password');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_keanggotaan');
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('username', 15)->unique();
            $table->string('password');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diubah')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('jenis_keanggotaan');
    }
};
