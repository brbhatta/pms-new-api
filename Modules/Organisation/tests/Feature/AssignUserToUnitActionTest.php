<?php

use Carbon\CarbonImmutable;
use Modules\Organisation\Application\UseCases\AssignUserToUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Http\Data\PostData;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\Posting;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

uses(Modules\Organisation\Tests\TestCase::class);

it('creates a posting for a user to a post within a unit', function () {
    $unit = OrganisationUnitData::from(OrganisationUnit::factory()->create());
    $user = UserData::from(User::factory()->create());

    $post = PostData::from(Post::factory()->create([
        'name' => 'Section Officer',
        'code' => 'SEC_OFF',
        'level' => 1,
    ]));

    $startDate = CarbonImmutable::now();
    $endDate = CarbonImmutable::now()->addYear();

    $result = resolve(AssignUserToUnitAction::class)->handle($user, $unit, $post, $startDate, $endDate);

    expect($result)->toBeTrue();

    $posting = Posting::query()->where('user_id', $user->id)->where('post_id', $post->id)->first();
    expect($posting)->not->toBeNull();
    expect($posting->organisation_unit_id)->toBe($unit->id);
    expect($posting->posting_type)->toBe('permanent');
});
