<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add account deactivation information to users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')
                ->default(true)
                ->after('role');

            $table->timestamp('deactivated_at')
                ->nullable()
                ->after('is_active');

            $table->foreignId('deactivated_by')
                ->nullable()
                ->after('deactivated_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Remove account deactivation information.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId(
                'deactivated_by'
            );

            $table->dropColumn([
                'is_active',
                'deactivated_at',
            ]);
        });
    }
};