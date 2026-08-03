<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the job applications table.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_post_id')
                ->constrained('job_posts')
                ->cascadeOnDelete();

            $table->foreignId('job_seeker_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('cover_letter')->nullable();

            $table->string('status', 20)
                ->default('pending');

            $table->timestamps();

            /*
             * Prevent the same job seeker from applying
             * for the same job more than once.
             */
            $table->unique(
                ['job_post_id', 'job_seeker_id'],
                'unique_job_application'
            );
        });
    }

    /**
     * Remove the job applications table.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};