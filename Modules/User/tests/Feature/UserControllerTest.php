<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Application\Exceptions\UserNotFoundException;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Application\Contracts\UserServiceInterface;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

beforeEach(function () {
    $this->service = $this->mock(UserServiceInterface::class);

    $this->data = UserData::from([
        'name' => 'B',
        'email' => 'b@example.test',
        'password' => 'secret',
        'metadata' => null
    ]);
});

it('index returns paginated collection via service', function () {
    $this->service->shouldReceive('getPaginatedUsers')
        ->once()
        ->andReturn(new LengthAwarePaginator([], 0, 15));

    $controller = resolve(UserController::class, ['userService' => $this->service]);

    $res = $controller->index();
    expect($res)->toBeInstanceOf(JsonResource::class);
});

it('store calls service and returns resource', function () {
    $this->service->shouldReceive('createUser')->once()->with(Mockery::on(function ($arg) {
        return $arg instanceof UserData;
    }))->andReturn($this->data);

    $controller = resolve(UserController::class, ['userService' => $this->service]);

    $req = Request::create('/', 'POST', $this->data->toArray());

    $res = $controller->store($req);
    expect($res)->toBeInstanceOf(JsonResource::class);
});

it('update calls service and returns resource', function () {
    $this->service->shouldReceive('updateUser')->once()->with('user-id', Mockery::on(function ($arg) {
        return $arg instanceof UserData;
    }))->andReturn($this->data);

    $controller = new UserController($this->service);

    $req = Request::create('/', 'PUT', $this->data->toArray());

    $res = $controller->update($req, 'user-id');
    expect($res)->toBeInstanceOf(JsonResource::class);
});

it('destroy handles failure and success', function () {
    $this->service->shouldReceive('deleteUser')->andReturn(false, true);

    $controller = resolve(UserController::class, ['userService' => $this->service]);

    $resFail = $controller->destroy('user-id');
    expect($resFail)->toBeInstanceOf(JsonResponse::class);

    $resOk = $controller->destroy('user-id');
    expect($resOk)->toBeInstanceOf(JsonResponse::class);
});

it('currentUser returns user data or throws when not found', function () {
    $user = User::factory()->create();
    $data = UserData::from($user);

    $this->service->shouldReceive('getUserById')->with($user->id)->andReturn($data);
    $controller = resolve(UserController::class, ['userService' => $this->service]);

    $this->actingAs($user);

    $res = $controller->currentUser();
    expect($res)->toBeInstanceOf(UserData::class);

    // when null, use fresh mock and controller to avoid previous expectations
    $serviceNull = $this->mock(UserServiceInterface::class);
    $serviceNull->shouldReceive('getUserById')->with($user->id)->andReturn(null);

    $controllerNull = new UserController($serviceNull);

    expect(fn() => $controllerNull->currentUser())->toThrow(UserNotFoundException::class);
});
