<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Hanya hapus kolom jika ada — abaikan foreign key karena mungkin belum ada
            if (Schema::hasColumn('rooms', 'tipe_kamar_id')) {
                // Coba hapus foreign key, tapi jika gagal karena tidak ada → skip
                try {
                    $table->dropForeign(['tipe_kamar_id']);
                } catch (Exception $e) {
                    // Abaikan jika foreign key tidak ada
                }

                // Baru hapus kolom
                $table->dropColumn('tipe_kamar_id');
            }
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('tipe_kamar_id')->after('id');
            $table->foreign('tipe_kamar_id')
                  ->references('id')
                  ->on('tipe_kamar')
                  ->onDelete('cascade');
        });
    }
};