<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Tambah type (Standard, Deluxe, dll)
            if (!Schema::hasColumn('rooms', 'type')) {
                $table->string('type')->nullable()->after('number');
            }

            // Tambah view (Sea, City, Garden)
            if (!Schema::hasColumn('rooms', 'view')) {
                $table->string('view')->nullable()->after('type');
            }

            // Tambah jumlah beds (integer)
            if (!Schema::hasColumn('rooms', 'beds')) {
                $table->integer('beds')->default(1)->after('max_occupancy');
            }
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['type', 'view', 'beds']);
        });
    }
};