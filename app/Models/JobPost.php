<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'employer_id',
    'title',
    'description',
    'requirements',
    'location',
    'employment_type',
    'salary_min',
    'salary_max',
    'application_deadline',
    'status',
])]
class JobPost extends Model
{
    use HasFactory;

    /**
     * Get the employer who created the job posting.
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'employer_id'
        );
    }

    /**
     * Get all applications submitted for this job posting.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(
            JobApplication::class,
            'job_post_id'
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'application_deadline' => 'date',
        ];
    }
}