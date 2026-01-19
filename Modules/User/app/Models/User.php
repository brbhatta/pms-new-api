<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Modules\Organisation\Models\Posting;
use Modules\User\Database\Factories\UserFactory;

/**
 * @method static findOrFail($userId)
 * @method static create(array $data)
 * @method departments()
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $full_name
 * @property string $address
 * @property string $profile_picture
 * @property string $employee_identifier
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    /**
     * Convenience helper: returns organisation_unit_ids this user is posted to via Postings.
     */
    public function organisationUnitIds(): array
    {
        return $this->postings()->pluck('organisation_unit_id')->unique()->all();
    }

    /**
     * @return HasMany<Posting>
     */
    public function postings(): HasMany
    {
        return $this->hasMany(Posting::class);
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
