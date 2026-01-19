<?php

use Modules\User\Application\UseCases\GetUserAction;
use Modules\User\Application\Exceptions\UserNotFoundException;
use Modules\User\Models\User;
use Modules\User\Http\Data\UserData;
use Illuminate\Support\Str;

uses(Modules\User\Tests\TestCase::class);

it('returns UserData for an existing user', function () {
    $user = User::factory()->create();

    $useCase = new GetUserAction(new User());

    $result = $useCase->handle($user->id);

    expect($result)->toBeInstanceOf(UserData::class);
    expect($result->id)->toBe($user->id);
});

it('throws UserNotFoundException for non-existing user', function () {
    $useCase = new GetUserAction(new User());

    expect(fn () => $useCase->handle(Str::uuid()->toString()))->toThrow(UserNotFoundException::class);
});
