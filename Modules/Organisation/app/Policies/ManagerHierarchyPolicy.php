<?php

namespace Modules\Organisation\Policies;

use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;
use Modules\Organisation\Models\Posting;
use Illuminate\Support\Collection;

final readonly class ManagerHierarchyPolicy
{
    public function __construct(
        private Posting $posting,
        private User $user,
    ) {
    }

    /**
     * Return immediate manager users for the given user (users who hold the post that the user's post reports to, within the same organisation unit and active postings).
     * @param  UserData  $userData
     * @return Collection<UserData>
     */
    public function immediateManagers(UserData $userData): Collection
    {
        $posting = $this->getActivePosting($userData);

        if (!$posting || !$posting->post || !$posting->post->reports_to_post_id) {
            return collect();
        }

        return $this->getActivePostingsForPostInUnit($posting->post->reports_to_post_id, $posting->organisation_unit_id)
            ->pluck('user')
            ->filter()
            ->values()
            ->map(fn(User $user) => UserData::from($user));
    }

    /**
     * Return all managers up the reporting chain for the given user.
     * Returns a collection of users in order from nearest manager to top.
     * @param  UserData  $user
     * @return Collection<UserData>
     */
    public function allManagers(UserData $user): Collection
    {
        $managers = collect();

        $posting = $this->getActivePosting($user);

        if (!$posting || !$posting->post) {
            return $managers;
        }

        $currentPost = $posting->post;
        $organisationUnitId = $posting->organisation_unit_id;

        while ($currentPost && $currentPost->reports_to_post_id) {
            $parentPost = $this->posting->newQuery()
                ->where('post_id', $currentPost->reports_to_post_id)
                ->first()?->post;

            if (!$parentPost) {
                break;
            }

            $users = $this->getActivePostingsForPostInUnit($parentPost->id, $organisationUnitId)
                ->pluck('user')
                ->filter()
                ->values();

            if ($users->isNotEmpty()) {
                $users->map(fn(User $user) => $managers->push(UserData::from($user)));
            }

            $currentPost = $parentPost;
        }

        return $managers->values();
    }

    /**
     * Get the user's active posting (latest start_date, end_date null or in future).
     */
    private function getActivePosting(UserData $userData): ?Posting
    {
        $user = $this->user->findOrFail($userData->id);

        return $user->postings()->active()->latest('start_date')->first();
    }

    /**
     * Return active postings for given post id within a specific organisation unit.
     * @param  string  $postId
     * @param  string  $organisationUnitId
     * @return Collection<Posting>
     */
    private function getActivePostingsForPostInUnit(string $postId, string $organisationUnitId): Collection
    {
        return $this->posting->newQuery()
            ->where('post_id', $postId)
            ->where('organisation_unit_id', $organisationUnitId)
            ->active()
            ->with('user')
            ->get();
    }
}
