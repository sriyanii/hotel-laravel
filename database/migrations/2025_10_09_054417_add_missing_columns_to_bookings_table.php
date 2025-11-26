<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_source')->nullable()->after('room_id');
            $table->integer('adults')->default(1)->after('booking_source');
            $table->integer('children')->default(0)->after('adults');
            $table->text('special_requests')->nullable()->after('children');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_source', 'adults', 'children', 'special_requests']);
        });
    }
};