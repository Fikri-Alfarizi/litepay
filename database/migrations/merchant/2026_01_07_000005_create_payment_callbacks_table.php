<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('merchant')->create('payment_callbacks', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('status');
            $table->text('payload')->nullable();
            $table->timestamp('received_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::connection('merchant')->dropIfExists('payment_callbacks');
    }
};
