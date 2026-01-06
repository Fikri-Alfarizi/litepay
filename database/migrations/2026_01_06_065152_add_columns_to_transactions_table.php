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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('product_name')->nullable()->after('invoice_id');
            $table->decimal('fee', 10, 2)->default(0)->after('amount');
            $table->decimal('tax', 10, 2)->default(0)->after('fee');
            $table->decimal('total_amount', 15, 2)->default(0)->after('tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'fee', 'tax', 'total_amount']);
        });
    }
};
