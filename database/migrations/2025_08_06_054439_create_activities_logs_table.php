<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('activity_type'); // create, update, delete, login, logout
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('role'); // admin, resepsionis
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->timestamps();
            
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};