<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPost extends Model
{
    use HasFactory;

    /**
     * Fields that may be stored through mass assignment.
     */
    protected $fillable = [
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
    ];

    /**
     * Convert selected database values into suitable data types.
     */
    protected function casts(): array
    {
        return [
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'application_deadline' => 'date',
        ];
    }

    /**
     * A job posting belongs to one employer.
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}