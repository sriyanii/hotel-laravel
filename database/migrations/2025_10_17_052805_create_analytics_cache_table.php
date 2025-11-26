<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('analytics_cache', function (Blueprint $table) {
            $table->id();
            $table->string('period'); // e.g., 'daily', 'weekly', 'monthly'
            $table->date('date');
            $table->string('room_type')->nullable();
            $table->string('channel')->nullable();
            $table->integer('bookings_count')->default(0);
            $table->bigInteger('revenue')->default(0);
            $table->decimal('occupancy_rate', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('analytics_cache');
    }
};