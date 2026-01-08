<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::connection('gateway')->hasTable('transactions')) {
            Schema::connection('gateway')->create('transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
                $table->string('invoice_id')->unique();
                $table->decimal('amount', 15, 2);
                $table->string('status')->default('PENDING'); // PENDING, SUCCESS, FAILED, EXPIRED
                $table->string('payment_method')->default('QRIS');
                $table->timestamp('paid_at')->nullable();
                $table->string('reference_id')->unique();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
