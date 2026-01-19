<?php

use Modules\User\Application\UseCases\DeleteUserAction;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

it('deletes a user', function () {
    $data = UserData::from(User::factory()->create());

    $result = resolve(DeleteUserAction::class)->handle($data);

    expect($result)->toBeTrue();
});

