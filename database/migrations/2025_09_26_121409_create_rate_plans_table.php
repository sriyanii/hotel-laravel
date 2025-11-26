<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rate_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Summer Special"
            $table->enum('type', ['seasonal', 'event']); // seasonal atau event
            $table->string('room_types'); // simpan sebagai string: "Deluxe, Suite" atau "All Rooms"
            $table->date('start_date');
            $table->date('end_date');
            $table->string('rate_adjustment'); // e.g., "+15%", "-10%"
            $table->enum('status', ['active', 'upcoming', 'expired']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rate_plans');
    }
};