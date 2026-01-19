<?php

namespace Modules\Organisation\Policies;

use Modules\Organisation\Http\Enums\PostType;
use Modules\User\Models\User;

final readonly class PositionHierarchyPolicy
{
    /**
     * Can $actor assign to $target user based on hierarchy?
     * Actor can assign a if actor's highest post level >= jobPosting->level
     * Actor must have at least one posting (level > 0).
     */
    public function canAssign(User $actor, PostType $post): bool
    {
        // Determine actor's highest post level from postings
        $actorMaxLevel = $actor->postings()
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
