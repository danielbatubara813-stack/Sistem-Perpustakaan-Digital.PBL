<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('aturan_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['id_jenis']);
        });

        Schema::table('aturan_peminjaman', function (Blueprint $table) {
            $table->integer('id_jenis')->unsigned()->nullable()->change();
            $table->unsignedTinyInteger('batas_peminjaman')->default(2)->change();
        });

        Schema::table('aturan_peminjaman', function (Blueprint $table) {
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_keanggotaan');
        });
    }

    public function down(): void
    {
        DB::table('aturan_peminjaman')->whereNull('id_jenis')->delete();

        Schema::table('aturan_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['id_jenis']);
        });

        Schema::table('aturan_peminjaman', function (Blueprint $table) {
            $table->integer('id_jenis')->unsigned()->nullable(false)->change();
            $table->unsignedTinyInteger('batas_peminjaman')->default(5)->change();
        });

        Schema::table('aturan_peminjaman', function (Blueprint $table) {
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_keanggotaan');
        });
    }
};
