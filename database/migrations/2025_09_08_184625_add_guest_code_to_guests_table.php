<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
    $table->string('guest_code')->nullable()->after('id'); // hilangkan ->unique()
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('guests', function (Blueprint $table) {
        $table->dropColumn('guest_code'); // ✅ ini benar
    });
}

};
