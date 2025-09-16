<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTipeKamarIdFromRoomsTable extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Menghapus kolom tipe_kamar_id
            $table->dropColumn('tipe_kamar_id');
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Menambahkan kembali kolom tipe_kamar_id jika rollback dilakukan
            $table->foreignId('tipe_kamar_id')
                ->constrained('tipe_kamars')
                ->onDelete('cascade');
        });
    }
}
