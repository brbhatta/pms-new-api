<?php

namespace Modules\Organisation\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Organisation\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'posts';

    protected $fillable = [
        'name',
        'code',
        'level',
        'reports_to_post_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    public function reportsTo(): BelongsTo
    {
        return $this->belongsTo(self::class, 'reports_to_post_id');
    }

    public function postings(): HasMany
    {
        return $this->hasMany(Posting::class);
    }
}
