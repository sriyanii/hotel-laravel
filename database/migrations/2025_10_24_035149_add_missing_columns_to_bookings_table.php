<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN INI

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'booking_code')) {
                $table->string('booking_code')->nullable()->after('guest_id');
            }

            // Tambah kolom lain yang dibutuhkan dari UI
            if (!Schema::hasColumn('bookings', 'check_in_time')) {
                $table->time('check_in_time')->nullable()->after('check_in');
            }
            if (!Schema::hasColumn('bookings', 'check_out_time')) {
                $table->time('check_out_time')->nullable()->after('check_out');
            }
            if (!Schema::hasColumn('bookings', 'deposit')) {
                $table->decimal('deposit', 10, 2)->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('deposit');
            }
            if (!Schema::hasColumn('bookings', 'early_checkin')) {
                $table->boolean('early_checkin')->default(false)->after('payment_method');
            }
            if (!Schema::hasColumn('bookings', 'breakfast_included')) {
                $table->boolean('breakfast_included')->default(false)->after('early_checkin');
            }
            if (!Schema::hasColumn('bookings', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0)->after('breakfast_included');
            }
        });

        // Isi booking_code untuk data yang belum punya
        DB::table('bookings')
            ->whereNull('booking_code')
            ->orWhere('booking_code', '')
            ->update([
                'booking_code' => DB::raw("CONCAT('BK-', LPAD(id, 6, '0'))")
            ]);

        // Tambahkan unique constraint setelah data diisi
        Schema::table('bookings', function (Blueprint $table) {
            $table->unique('booking_code');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus unique dulu
            $table->dropUnique(['booking_code']);

            $table->dropColumn([
                'booking_code',
                'check_in_time',
                'check_out_time',
                'deposit',
                'payment_method',
                'early_checkin',
                'breakfast_included',
                'total_amount'
            ]);
        });
    }
};