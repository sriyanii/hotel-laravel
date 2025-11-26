<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rate_plans', function (Blueprint $table) {
            // Ubah kolom `type` dari ENUM ke VARCHAR agar bisa terima 'promo'
            $table->string('type')->change();

            // Hapus kolom lama yang akan diganti
            $table->dropColumn(['rate_adjustment', 'status']);

            // Tambahkan kolom baru
            $table->string('rate_adjustment_sign', 1)->default('+');
            $table->decimal('rate_adjustment_value', 10, 2);
            $table->string('rate_adjustment_type')->default('percentage'); // 'percentage' atau 'fixed'

            $table->integer('min_stay')->nullable();
            $table->integer('release_days')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down()
    {
        Schema::table('rate_plans', function (Blueprint $table) {
            // Kembalikan ke struktur lama
            $table->enum('type', ['seasonal', 'event'])->change();

            // Tambahkan kembali kolom lama
            $table->string('rate_adjustment');
            $table->enum('status', ['active', 'upcoming', 'expired']);

            // Hapus kolom baru
            $table->dropColumn([
                'rate_adjustment_sign',
                'rate_adjustment_value',
                'rate_adjustment_type',
                'min_stay',
                'release_days',
                'description',
                'is_active'
            ]);
        });
    }
};