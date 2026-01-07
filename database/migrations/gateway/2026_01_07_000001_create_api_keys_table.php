<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('gateway')->create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->string('api_key')->unique();
            $table->string('api_secret');
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('gateway')->dropIfExists('api_keys');
    }
};
