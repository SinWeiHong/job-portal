<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add moderation and soft-delete fields
     * to the job postings table.
     */
    public function up(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            /*
             * The administrator's reason for removing
             * an inappropriate job posting.
             */
            $table->text('removal_reason')
                ->nullable()
                ->after('status');

            /*
             * The administrator who removed
             * the job posting.
             */
            $table->foreignId('removed_by')
                ->nullable()
                ->after('removal_reason')
                ->constrained('users')
                ->nullOnDelete();

            /*
             * The date and time when the posting
             * was removed by the administrator.
             */
            $table->timestamp('removed_at')
                ->nullable()
                ->after('removed_by');

            /*
             * Laravel soft-delete timestamp.
             * The posting remains in the database
             * after removal.
             */
            $table->softDeletes();
        });
    }

    /**
     * Remove the moderation and soft-delete fields.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('removed_by');

            $table->dropColumn([
                'removal_reason',
                'removed_at',
            ]);

            $table->dropSoftDeletes();
        });
    }
};