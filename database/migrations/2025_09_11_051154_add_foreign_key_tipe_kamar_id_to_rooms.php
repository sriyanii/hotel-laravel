<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Tambahkan foreign key — hanya jika belum ada
        $constraintExists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'rooms'
              AND COLUMN_NAME = 'tipe_kamar_id'
              AND REFERENCED_TABLE_NAME = 'tipe_kamar'
        ");

        if (empty($constraintExists)) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->foreign('tipe_kamar_id')
                      ->references('id')
                      ->on('tipe_kamar')
                      ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Hapus foreign key jika ada
            $table->dropForeign(['tipe_kamar_id']);
        });
    }
};