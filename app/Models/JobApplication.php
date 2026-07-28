<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'job_post_id',
    'job_seeker_id',
    'cover_letter',
    'status',
])]
class JobApplication extends Model
{
    use HasFactory;

    /**
     * Get the related job posting.
     */
    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(
            JobPost::class,
            'job_post_id'
        );
    }

    /**
     * Get the job seeker who submitted the application.
     */
    public function jobSeeker(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'job_seeker_id'
        );
    }
}