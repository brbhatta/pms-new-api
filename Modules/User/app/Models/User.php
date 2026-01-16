<?php

namespace Modules\User\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static findOrFail($userId)
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'address',
        'profile_picture',
        'employee_identifier',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'array',
        'profile_picture' => 'string',
        'employee_identifier' => 'string',
        'full_name' => 'string',
    ];

    public function tokens(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }
}

