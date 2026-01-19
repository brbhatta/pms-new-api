<?php

use Modules\Organisation\Models\Post;

uses(Modules\Organisation\Tests\TestCase::class);

it('creates a post via factory with expected attributes', function () {
    $post = Post::factory()->make([
        'name' => 'Test PostType',
        'code' => 'TEST_POST',
        'level' => 2,
    ]);

    expect($post)->toBeInstanceOf(Post::class);
    expect($post->name)->toBe('Test PostType');
    expect($post->code)->toBe('TEST_POST');
    expect($post->level)->toBe(2);
});
