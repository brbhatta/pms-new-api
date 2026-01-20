<?php

namespace Modules\Organisation\Policies;

use Modules\Organisation\Http\Enums\PostType;
use Modules\Organisation\Models\Posting;
use Modules\User\Http\Data\UserData;

final readonly class PositionHierarchyPolicy
{
    public function __construct(
        private Posting $posting
    ) {
    }

    /**
     * Can $actor assign to $target user based on hierarchy?
     * Actor can assign a if actor's highest post level >= jobPosting->level
     * Actor must have at least one posting (level > 0).
     */
    public function canAssign(UserData $actor, PostType $post): bool
    {
        // Determine actor's highest post level from postings
        $actorMaxLevel = $this->posting->newQuery()->where('user_id', $actor->id)
            ->with('post')
            ->get()
            ->map(function ($posting) {
                return $posting->post?->level ?? 0;
            })->max();

        $actorMaxLevel = $actorMaxLevel ?? 0;

        // actor must have at least one posting with level > 0 to be allowed to assign
        if ($actorMaxLevel <= 0) {
            return false;
        }

        return $actorMaxLevel >= $post->level();
    }
}
