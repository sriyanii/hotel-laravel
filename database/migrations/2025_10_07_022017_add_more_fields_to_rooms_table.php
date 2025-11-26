<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMoreFieldsToRoomsTable extends Migration
{
    public function up()
    {
        // Pertama, update nilai NULL di floor menjadi 1
        DB::table('rooms')->whereNull('floor')->update(['floor' => 1]);

        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('floor')->default(1)->change();
            $table->decimal('room_size', 8, 2)->nullable()->after('floor');
            $table->string('bed_type')->nullable()->after('room_size');
            $table->integer('max_occupancy')->default(2)->after('capacity');
            $table->json('features')->nullable()->after('facilities');
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['room_size', 'bed_type', 'max_occupancy', 'features']);
            // Kembalikan floor ke nullable
            $table->integer('floor')->nullable()->change();
        });
    }
}