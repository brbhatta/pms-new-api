<?php

use Modules\User\Application\UseCases\CreateUserAction;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

it('creates a user', function () {

    $data = UserData::from(User::factory()->make());

    $result = resolve(CreateUserAction::class)->handle($data);

    expect($result)->toBeInstanceOf(UserData::class);
    expect($result->email)->toBe($data->email);
});

