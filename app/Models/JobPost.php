<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    'removal_reason',
    'removed_by',
    'removed_at',
])]
class JobPost extends Model
{
    use HasFactory, SoftDeletes;

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
     * Get the administrator who removed the job posting.
     */
    public function removedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'removed_by'
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
            'removed_at' => 'datetime',
        ];
    }
}