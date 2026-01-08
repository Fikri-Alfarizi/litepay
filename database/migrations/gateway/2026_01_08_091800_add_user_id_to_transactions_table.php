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
        Schema::connection('gateway')->table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('merchant_id');
            $table->string('product_name')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('gateway')->table('transactions', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'product_name']);
        });
    }
};
