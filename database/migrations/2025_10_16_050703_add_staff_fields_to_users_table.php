<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable(); // Atau gunakan ENUM jika ingin lebih ketat
            $table->date('join_date')->nullable();
            $table->string('status')->default('active'); // Atau ENUM: active, inactive, on-leave
            $table->unsignedBigInteger('salary')->nullable(); // Gunakan unsignedBigInteger untuk nilai besar
            $table->text('notes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'position', 'department', 'join_date', 'status', 'salary', 'notes']);
        });
    }
}