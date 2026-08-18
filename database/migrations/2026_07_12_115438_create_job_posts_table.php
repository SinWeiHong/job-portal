<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title', 150);
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location', 150);
            $table->string('employment_type', 50);

            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();

            $table->date('application_deadline');
            $table->string('status', 20)->default('open');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};