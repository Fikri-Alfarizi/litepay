<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::connection('merchant')->hasTable('order_payments')) {
            Schema::connection('merchant')->create('order_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
                $table->string('invoice_id')->unique();
                $table->string('gateway_transaction_id')->nullable();
                $table->string('payment_status')->default('PENDING'); // PENDING, PAID, FAILED
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('merchant')->dropIfExists('order_payments');
    }
};
