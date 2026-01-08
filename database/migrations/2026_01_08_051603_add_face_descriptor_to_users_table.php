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
        // Only add column if it doesn't exist
        if (!Schema::connection('merchant')->hasColumn('users', 'face_descriptor')) {
            Schema::connection('merchant')->table('users', function (Blueprint $table) {
                $table->text('face_descriptor')->nullable()->after('biometric_token');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('merchant')->hasColumn('users', 'face_descriptor')) {
            Schema::connection('merchant')->table('users', function (Blueprint $table) {
                $table->dropColumn('face_descriptor');
            });
        }
    }
};
