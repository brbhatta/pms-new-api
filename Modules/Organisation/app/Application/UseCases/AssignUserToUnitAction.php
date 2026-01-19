<?php

namespace Modules\Organisation\Application\UseCases;

use Carbon\CarbonImmutable;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\User\Models\User;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\Posting;

final readonly class AssignUserToUnitAction
{
    public function __construct(
        private OrganisationUnit $unitModel,
        private User $userModel,
        private Post $postModel,
        private Posting $postingModel
    ) {
    }

    /**
     * Create a Posting (assignment of a user to a post within a unit).
     *
     * @param  string  $userId
     * @param  string  $unitId
     * @param  Post|null  $post
     * @param  string  $postingType
     * @param  CarbonImmutable|null  $startDate
     * @param  CarbonImmutable|null  $endDate
     * @return bool
     */
    public function handle(
        string $userId,
        string $unitId,
        ?Post $post,
        string $postingType = 'permanent',
        ?CarbonImmutable $startDate = null,
        ?CarbonImmutable $endDate = null
    ): bool {
        $unit = $this->unitModel->newQuery()->findOrFail($unitId);
        $user = $this->userModel->newQuery()->findOrFail($userId);

        if ($post) {
            $post = $this->postModel->newQuery()->find($post->id) ?? $post;
        }

        $posting = $this->postingModel->newQuery()->create([
            'user_id' => $user->id,
            'post_id' => $post?->id,
            'organisation_unit_id' => $unit->id,
            'posting_type' => $postingType,
            'start_date' => $startDate?->toDateString() ?? now()->toDateString(),
            'end_date' => $endDate?->toDateString(),
        ]);

        return (bool) $posting;
    }
}
