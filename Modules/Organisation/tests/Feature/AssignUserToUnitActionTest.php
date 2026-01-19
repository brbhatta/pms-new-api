<?php

use Modules\Organisation\Application\UseCases\AssignUserToUnitAction;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\Posting;
use Modules\User\Models\User;

uses(Modules\Organisation\Tests\TestCase::class);

it('creates a posting for a user to a post within a unit', function () {
    $unit = OrganisationUnit::factory()->create();
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'name' => 'Section Officer',
        'code' => 'SEC_OFF',
        'level' => 1,
    ]);

    $result = resolve(AssignUserToUnitAction::class)->handle($user->id, $unit->id, $post);

    expect($result)->toBeTrue();

    $posting = Posting::query()->where('user_id', $user->id)->where('post_id', $post->id)->first();
    expect($posting)->not->toBeNull();
    expect($posting->organisation_unit_id)->toBe($unit->id);
    expect($posting->posting_type)->toBe('permanent');
});
