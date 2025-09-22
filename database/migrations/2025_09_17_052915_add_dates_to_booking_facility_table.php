<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('booking_facility', function (Blueprint $table) {
        $table->date('start_date')->nullable()->after('price');
        $table->date('end_date')->nullable()->after('start_date');
    });
}

public function down()
{
    Schema::table('booking_facility', function (Blueprint $table) {
        $table->dropColumn(['start_date', 'end_date']);
    });
}

};
