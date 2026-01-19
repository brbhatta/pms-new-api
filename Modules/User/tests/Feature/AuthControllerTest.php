<?php

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Application\Contracts\AuthServiceInterface;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

it('login returns access token json', function () {
    $email = 'test-login@example.test';
    $password = 'secret123';

    $mock = $this->mock(AuthServiceInterface::class, function ($mock) use ($email, $password) {
        $mock->shouldReceive('login')->once()->with($email, $password)->andReturn('jwt-token');
    });

    $controller = resolve(AuthController::class, ['authService' => $mock]);

    $request = Request::create('/', 'POST', ['email' => $email, 'password' => $password]);

    $response = $controller->login($request);

    expect($response)->toBeInstanceOf(Illuminate\Http\JsonResponse::class);

    $payload = json_decode($response->getContent(), true);
    expect($payload['accessToken'])->toBe('jwt-token');
    expect($payload['tokenType'])->toBe('Bearer');
});

it('logout calls service and returns success json', function () {
    $user = User::factory()->create();

    $mock = $this->mock(AuthServiceInterface::class, function ($mock) use ($user) {
        $mock->shouldReceive('logout')->once()->with((string) $user->id)->andReturn(true);
    });

    $this->actingAs($user);

    $controller = resolve(AuthController::class, ['authService' => $mock]);

    $response = $controller->logout();

    expect($response)->toBeInstanceOf(Illuminate\Http\JsonResponse::class);
    $payload = json_decode($response->getContent(), true);
    expect($payload['message'])->toBe('Successfully logged out.');
});
