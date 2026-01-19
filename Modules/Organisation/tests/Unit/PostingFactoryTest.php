<?php

use Modules\Organisation\Models\Posting;

uses(Modules\Organisation\Tests\TestCase::class);

it('creates a posting via factory', function () {
    $posting = Posting::factory()->make();

    expect($posting)->toBeInstanceOf(Posting::class);
    expect($posting->user_id)->not->toBeNull();
    expect($posting->post_id)->not->toBeNull();
    expect($posting->organisation_unit_id)->not->toBeNull();
});
