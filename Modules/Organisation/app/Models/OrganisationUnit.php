<?php

namespace Modules\Organisation\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Organisation\Database\Factories\OrganisationUnitFactory;

/**
 * @property mixed $id
 */
class OrganisationUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'organisation_units';

    protected $fillable = [
        'name',
        'code',
        'type',
        'parent_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected static function newFactory(): OrganisationUnitFactory
    {
        return OrganisationUnitFactory::new();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * The postings (assignments) that place users into posts within this unit.
     */
    public function postings(): HasMany
    {
        return $this->hasMany(Posting::class);
    }
}
