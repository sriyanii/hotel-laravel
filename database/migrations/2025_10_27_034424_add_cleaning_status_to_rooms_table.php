<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCleaningStatusToRoomsTable extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'terisi', 'maintenance', 'dipesan', 'cleaning'])->default('tersedia')->change();
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'terisi', 'maintenance', 'dipesan'])->default('tersedia')->change();
        });
    }
}