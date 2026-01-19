<?php

use Modules\User\Application\UseCases\AuthenticateUserAction;
use Modules\User\Application\UseCases\LogoutUserAction;
use Modules\User\Models\User;
use Modules\User\Models\PersonalAccessToken;
use Illuminate\Support\Str;

uses(Modules\User\Tests\TestCase::class);

it('returns false when user not found', function () {
    $result = resolve(LogoutUserAction::class)->handle(Str::uuid()->toString());

    expect($result)->toBeFalse();
});

it('deletes current access token and returns true when token exists', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    // authenticate to create a personal access token in DB
    $plainToken = resolve(AuthenticateUserAction::class)->handle($user->email, 'password');

    expect($plainToken)->not->toBeEmpty();

    // fetch the last token created for this user
    $tokenModel = PersonalAccessToken::where('tokenable_id', $user->id)
        ->where('tokenable_type', get_class($user))
        ->latest('id')
        ->first();

    expect($tokenModel)->not->toBeNull();

    // attach the token model as the user's current access token so LogoutUserAction can call delete()
    $user->withAccessToken($tokenModel);

    $result = resolve(LogoutUserAction::class)->handle($user->id);

    expect($result)->toBeTrue();

    // token should be removed from database
    expect(PersonalAccessToken::where('id', $tokenModel->id)->exists())->toBeFalse();
});
