<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFacilitiesTable extends Migration
{
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            if (!Schema::hasColumn('facilities', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('facilities', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('facilities', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn(['description', 'image', 'status']);
        });
    }
}
