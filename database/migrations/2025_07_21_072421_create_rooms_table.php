<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('type');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['tersedia', 'terisi', 'maintenance', 'dipesan'])->default('tersedia');
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->integer('capacity')->default(1);
            $table->integer('floor')->nullable();
            $table->json('facilities')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};