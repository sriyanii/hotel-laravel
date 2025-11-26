<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('guest_code');
            $table->string('last_name')->nullable()->after('first_name');
        });

        // Opsional: isi first_name & last_name dari name yang sudah ada
        DB::statement("
            UPDATE guests 
            SET 
                first_name = SUBSTRING_INDEX(name, ' ', 1),
                last_name = TRIM(SUBSTRING(name, LOCATE(' ', name) + 1))
            WHERE name IS NOT NULL
        ");

        // Hapus kolom `name` nanti setelah yakin data sudah dipindah
    }

    public function down()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};