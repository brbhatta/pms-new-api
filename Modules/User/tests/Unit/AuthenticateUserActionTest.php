<?php

use Modules\User\Application\UseCases\AuthenticateUserAction;
use Modules\User\Application\Exceptions\InvalidCredentialsException;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

it('returns a token string on successful authentication', function () {
    $password = 'secret-password';

    $user = User::factory()->create([
        'password' => bcrypt($password),
    ]);

    $token = resolve(AuthenticateUserAction::class)->handle($user->email, $password);

    expect($token)->not->toBeEmpty();
    expect(strlen($token))->toBeGreaterThan(0);
});

it('throws InvalidCredentialsException when email does not exist', function () {
    $action = resolve(AuthenticateUserAction::class);

    expect(fn() => $action->handle('no-such@example.test', 'whatever'))->toThrow(InvalidCredentialsException::class);
});

it('throws InvalidCredentialsException when password is incorrect', function () {
    $user = User::factory()->create([
        'password' => bcrypt('right-password'),
    ]);

    $action = resolve(AuthenticateUserAction::class);

    expect(fn() => $action->handle($user->email, 'wrong-password'))->toThrow(InvalidCredentialsException::class);
});
