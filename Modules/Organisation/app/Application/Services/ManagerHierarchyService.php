<?php

namespace Modules\Organisation\Application\Services;

use Illuminate\Support\Collection;
use Modules\Organisation\Application\Contracts\ManagerHierarchyServiceInterface;
use Modules\Organisation\Http\Data\PostData;
use Modules\Organisation\Http\Data\PostingData;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\Posting;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

final readonly class ManagerHierarchyService implements ManagerHierarchyServiceInterface
{
    public function __construct(
        private Posting $posting,
        private Post $post
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

        if (!$posting || !$posting->post->reportsToPostId) {
            return collect();
        }

        return $this->getActivePostingsForPostInUnit($posting->post->reportsToPostId, $posting->organisationUnitId)
            ->pluck('user')
            ->filter()
            ->values()
            ->map(fn(User $user) => UserData::from($user));
    }

    /**
     * Return all managers up the reporting chain for the given user.
     * Returns a collection of users in order from nearest manager to top.
     * @param  UserData  $userData
     * @return Collection<UserData>
     */
    public function allManagers(UserData $userData): Collection
    {
        $managers = collect();

        $posting = $this->getActivePosting($userData);

        if (!$posting) {
            return $managers;
        }

        $currentPost = $posting->post;
        $organisationUnitId = $posting->organisationUnitId;

        while ($currentPost && $currentPost->reportsToPostId) {
            $parentPost = $this->post->newQuery()->find($currentPost->reportsToPostId);

            if (!$parentPost) {
                break;
            }

            $parentPost = PostData::from($parentPost);

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
    public function getActivePosting(UserData $userData): ?PostingData
    {
        $posting = $this->posting->newQuery()
            ->where('user_id', $userData->id)
            ->active()
            ->latest('start_date')
            ->first();

        if ($posting) {
            $posting->load('post');
        }

        return $posting ? PostingData::from($posting) : null;
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
