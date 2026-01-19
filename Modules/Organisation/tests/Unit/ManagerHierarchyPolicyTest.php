<?php

use Modules\Organisation\Database\Seeders\PostsSeeder;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Policies\ManagerHierarchyPolicy;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\Organisation\Models\Posting;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;
use Modules\Organisation\Http\Enums\PostType;

uses(Modules\Organisation\Tests\TestCase::class);

@beforeEach(function () {
    $this->seed(PostsSeeder::class);
});

it('returns immediate manager for a user within same unit', function () {
    /** @var OrganisationUnit $unit */
    $unit = OrganisationUnitData::from(OrganisationUnit::factory()->create());
    $posts = Post::all()->keyBy('code');

    // create users and postings: assign one user to section officer, and a manager to deputy
    $employee = UserData::from(User::factory()->create());
    $manager = UserData::from(User::factory()->create());

    Posting::factory()->create([
        'user_id' => $employee->id,
        'post_id' => $posts[PostType::SECTION_OFFICER->name]->id,
        'organisation_unit_id' => $unit->id,
        'posting_type' => 'permanent',
        'start_date' => now()->toDateString(),
        'end_date' => null,
    ]);

    Posting::factory()->create([
        'user_id' => $manager->id,
        'post_id' => $posts[PostType::DEPUTY_SECRETARY->name]->id,
        'organisation_unit_id' => $unit->id,
        'posting_type' => 'permanent',
        'start_date' => now()->toDateString(),
        'end_date' => null,
    ]);

    $immediate = resolve(ManagerHierarchyPolicy::class)->immediateManagers($employee);

    expect($immediate)->toBeInstanceOf(Illuminate\Support\Collection::class);
    expect($immediate->first()->id)->toBe($manager->id);
});

it('returns full manager chain in order', function () {
    $unit = OrganisationUnitData::from(OrganisationUnit::factory()->create());

    $posts = Post::all()->keyBy('code');

    // create users and postings: assign one user to section officer, and a manager to deputy
    $employee = UserData::from(User::factory()->create(['name' => 'Employee User']));
    $managers = User::factory(3)->create(['name' => 'Manager'])->map(fn (User $user) => UserData::from($user));

    Posting::factory()->create([
        'user_id' => $employee->id,
        'post_id' => $posts[PostType::SECTION_OFFICER->name]->id,
        'organisation_unit_id' => $unit->id,
        'posting_type' => 'permanent',
        'start_date' => now()->toDateString(),
        'end_date' => null,
    ]);

    Posting::factory()->create([
        'user_id' => $managers[0]->id,
        'post_id' => $posts[PostType::DEPUTY_SECRETARY->name]->id,
        'organisation_unit_id' => $unit->id,
        'posting_type' => 'permanent',
        'start_date' => now()->toDateString(),
        'end_date' => null,
    ]);

    Posting::factory()->create([
        'user_id' => $managers[1]->id,
        'post_id' => $posts[PostType::JOINT_SECRETARY->name]->id,
        'organisation_unit_id' => $unit->id,
        'posting_type' => 'permanent',
        'start_date' => now()->toDateString(),
        'end_date' => null,
    ]);

    Posting::factory()->create([
        'user_id' => $managers[2]->id,
        'post_id' => $posts[PostType::ADDITIONAL_SECRETARY->name]->id,
        'organisation_unit_id' => $unit->id,
        'posting_type' => 'permanent',
        'start_date' => now()->toDateString(),
        'end_date' => null,
    ]);

    $all = resolve(ManagerHierarchyPolicy::class)->allManagers($employee);

    expect($all->pluck('id')->toArray())->toBe([
        $managers[0]->id,
        $managers[1]->id,
        $managers[2]->id,
    ]);
});
