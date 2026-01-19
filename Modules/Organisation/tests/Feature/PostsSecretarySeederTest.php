<?php

use Modules\Organisation\Database\Seeders\PostsSeeder;
use Modules\Organisation\Http\Enums\PostType;
use Modules\Organisation\Models\Post;

uses(Modules\Organisation\Tests\TestCase::class);

it('seeds the secretary posts into posts table', function () {
    $this->seed(PostsSeeder::class);

    $post = new Post();

    expect($post->newQuery()->where('code', PostType::SECRETARY->name)->exists())->toBeTrue();
    expect($post->newQuery()->where('code', PostType::ADDITIONAL_SECRETARY->name)->exists())->toBeTrue();
    expect($post->newQuery()->where('code', PostType::JOINT_SECRETARY->name)->exists())->toBeTrue();
    expect($post->newQuery()->where('code', PostType::DEPUTY_SECRETARY->name)->exists())->toBeTrue();
    expect($post->newQuery()->where('code', PostType::SECTION_OFFICER->name)->exists())->toBeTrue();
});
