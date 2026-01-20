<?php

namespace Modules\Organisation\Application\UseCases;

use Carbon\CarbonImmutable;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Http\Data\PostData;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\Posting;

final readonly class AssignUserToUnitAction
{
    public function __construct(
        private Posting $postingModel
    ) {
    }

    /**
     * Create a Posting (assignment of a user to a post within a unit).
     *
     * @param  UserData  $user
     * @param  OrganisationUnitData  $unit
     * @param  PostData  $post
     * @param  CarbonImmutable|null  $startDate
     * @param  CarbonImmutable|null  $endDate
     * @return bool
     */
    public function handle(
        UserData $user,
        OrganisationUnitData $unit,
        PostData $post,
        ?CarbonImmutable $startDate = null,
        ?CarbonImmutable $endDate = null
    ): bool {
        $posting = $this->postingModel->newQuery()->create([
            'user_id' => $user->id,
            'post_id' => $post?->id,
            'organisation_unit_id' => $unit->id,
            'posting_type' => "permanent",
            'start_date' => $startDate?->toDateString() ?? now()->toDateString(),
            'end_date' => $endDate?->toDateString(),
        ]);

        return (bool) $posting;
    }
}
