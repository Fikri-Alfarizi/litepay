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
        Schema::create('fraud_alerts', function (Blueprint $table) {
            $table->id();
            // nullable because sometimes fraud checks happen before transaction persistence, 
            // but for this UI it's usually tied to one.
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('risk_score');
            $table->string('reason');
            $table->string('ip_address')->nullable();
            $table->string('country_code')->nullable();
            $table->enum('status', ['pending', 'blocked', 'ignored'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraud_alerts');
    }
};
