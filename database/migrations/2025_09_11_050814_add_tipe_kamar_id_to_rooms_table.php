<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeKamarIdToRoomsTable extends Migration
{
public function up()
{
    Schema::table('rooms', function (Blueprint $table) {
        // Memeriksa apakah kolom tipe_kamar_id sudah ada
        if (!Schema::hasColumn('rooms', 'tipe_kamar_id')) {
            $table->foreignId('tipe_kamar_id')
                ->constrained('tipe_kamars')
                ->onDelete('cascade');
        }
    });
}


    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Menghapus foreign key dan kolom tipe_kamar_id
            $table->dropForeign(['tipe_kamar_id']);
            $table->dropColumn('tipe_kamar_id');
        });
    }
}
