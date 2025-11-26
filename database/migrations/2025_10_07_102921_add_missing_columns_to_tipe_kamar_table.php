<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('tipe_kamar', function (Blueprint $table) {
        $table->text('deskripsi')->nullable();
        $table->integer('kapasitas')->default(2);
        $table->text('fitur')->nullable(); // akan simpan sebagai JSON
    });
}

public function down()
{
    Schema::table('tipe_kamar', function (Blueprint $table) {
        $table->dropColumn(['deskripsi', 'kapasitas', 'fitur']);
    });
}
};
