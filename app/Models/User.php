<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'is_active',
    'deactivated_at',
    'deactivated_by',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Default values for new user accounts.
     *
     * All newly created users are active unless
     * explicitly deactivated by an administrator.
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Get all job applications submitted by this user.
     */
    public function jobApplications(): HasMany
    {
        return $this->hasMany(
            JobApplication::class,
            'job_seeker_id'
        );
    }

    /**
     * Get the administrator who deactivated this account.
     */
    public function deactivatedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'deactivated_by'
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'deactivated_at' => 'datetime',
        ];
    }
}