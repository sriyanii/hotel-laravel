<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::statement("ALTER TABLE bookings 
                  MODIFY COLUMN status 
                  ENUM('booked', 'checked_in', 'checked_out', 'canceled', 'paid') 
                  NOT NULL DEFAULT 'booked'");
}

public function down()
{
    DB::statement("ALTER TABLE bookings 
                  MODIFY COLUMN status 
                  ENUM('booked', 'checked_in', 'checked_out', 'canceled') 
                  NOT NULL DEFAULT 'booked'");
}
};
