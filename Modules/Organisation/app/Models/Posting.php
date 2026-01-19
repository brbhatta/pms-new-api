<?php

namespace Modules\Organisation\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Organisation\Database\Factories\PostingFactory;
use Modules\User\Models\User;

/**
 * @property mixed $post
 * @property mixed $organisation_unit_id
 */
class Posting extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'postings';

    protected $fillable = [
        'user_id',
        'post_id',
        'organisation_unit_id',
        'posting_type',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    #[Scope]
    public function active(Builder $query)
    {
        return $query->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>', now());
            });
    }

    protected static function newFactory(): PostingFactory
    {
        return PostingFactory::new();
    }

    /**
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Post>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo<OrganisationUnit>
     */
    public function organisationUnit(): BelongsTo
    {
        return $this->belongsTo(OrganisationUnit::class);
    }
}
