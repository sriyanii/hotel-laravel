<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('description');
            $table->string('category');
            $table->enum('type', ['income', 'expense']);
            $table->bigInteger('amount');
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('client');
            $table->date('issue_date');
            $table->date('due_date');
            $table->bigInteger('amount');
            $table->enum('status', ['paid', 'pending', 'overdue'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('finances');
        Schema::dropIfExists('invoices');
    }
};
