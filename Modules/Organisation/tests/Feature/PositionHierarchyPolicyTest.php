<?php

use Modules\Organisation\Database\Seeders\PostsSeeder;
use Modules\Organisation\Policies\PositionHierarchyPolicy;
use Modules\Organisation\Http\Enums\PostType;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\Organisation\Models\Post as PostModel;
use Modules\Organisation\Models\Posting;
use Modules\User\Models\User;

uses(Modules\Organisation\Tests\TestCase::class);

it('allows actor with higher or equal job posting level to assign job posting', function () {
    $this->seed(PostsSeeder::class);
    $policy = new PositionHierarchyPolicy();
    $postModel = new PostModel();

    $actor = User::factory()->create();
    $unit = OrganisationUnit::factory()->create();

    $joint = $postModel->newQuery()->where('code', PostType::JOINT_SECRETARY->name)->first();

    // Attach actor as Joint Secretary (posting)
    Posting::factory()->create(['user_id' => $actor->id, 'post_id' => $joint->id, 'organisation_unit_id' => $unit->id]);

    $actor->load('postings.post');

    // Actor (level 3) should be allowed to assign Deputy Secretary (level 2) and Section Officer (1), but not Secretary (5)
    expect($policy->canAssign($actor, PostType::DEPUTY_SECRETARY))->toBeTrue();
    expect($policy->canAssign($actor, PostType::SECTION_OFFICER))->toBeTrue();
    expect($policy->canAssign($actor, PostType::SECRETARY))->toBeFalse();
});

it('denies assigning when actor has no postings (treats null max as 0)', function () {
    $policy = new PositionHierarchyPolicy();

    $actor = User::factory()->create();

    // no postings attached
    $actor->load('postings.post');

    expect($policy->canAssign($actor, PostType::SECTION_OFFICER))->toBeFalse();
});
