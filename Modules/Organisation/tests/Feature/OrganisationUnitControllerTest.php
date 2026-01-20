<?php

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Modules\Organisation\Http\Controllers\OrganisationUnitController;
use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Http\Requests\AssignUserToUnitRequest;

uses(Modules\Organisation\Tests\TestCase::class);

it('index calls service and returns collection resource', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $service->shouldReceive('getPaginatedUnits')->once()->andReturn(new Illuminate\Pagination\LengthAwarePaginator([],
        0, 15));

    $controller = new OrganisationUnitController($service);

    $response = $controller->index();

    expect($response)->toBeInstanceOf(Illuminate\Http\Resources\Json\JsonResource::class);
});

it('store calls service and returns resource', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $data = OrganisationUnitData::from([
        'name' => 'A', 'code' => 'C', 'type' => 'department', 'parent_id' => null, 'metadata' => null
    ]);

    $service->shouldReceive('createUnit')->once()->with(Mockery::on(function ($arg) {
        return $arg instanceof OrganisationUnitData && $arg->name === 'A' && $arg->code === 'C';
    }))->andReturn($data);

    $controller = new OrganisationUnitController($service);
    $request = new Request($data->toArray());

    $res = $controller->store($request);

    expect($res)->toBeInstanceOf(Illuminate\Http\Resources\Json\JsonResource::class);
});

it('show calls service and returns resource', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $data = OrganisationUnitData::from([
        'name' => 'A', 'code' => 'C', 'type' => 'department', 'parent_id' => null, 'metadata' => null
    ]);
    $service->shouldReceive('getUnitById')->once()->with('unit-1')->andReturn($data);

    $controller = new OrganisationUnitController($service);
    $res = $controller->show('unit-1');

    expect($res)->toBeInstanceOf(Illuminate\Http\Resources\Json\JsonResource::class);
});

it('update calls service and returns resource', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $data = OrganisationUnitData::from([
        'name' => 'A', 'code' => 'C', 'type' => 'department', 'parent_id' => null, 'metadata' => null
    ]);
    $service->shouldReceive('updateUnit')->once()->with('unit-1', Mockery::on(function ($arg) {
        return $arg instanceof OrganisationUnitData && $arg->name === 'A';
    }))->andReturn($data);

    $controller = new OrganisationUnitController($service);
    $request = new Request($data->toArray());
    $res = $controller->update($request, 'unit-1');

    expect($res)->toBeInstanceOf(Illuminate\Http\Resources\Json\JsonResource::class);
});

it('destroy calls service and returns success', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $service->shouldReceive('deleteUnit')->once()->with('unit-1')->andReturn(true);

    $controller = new OrganisationUnitController($service);
    $res = $controller->destroy('unit-1');

    expect($res->getData(true)['code'])->toBe('SUCCESS');
});

it('assignUserToUnit calls service with correct params', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $carbonStart = CarbonImmutable::parse('2024-01-01');
    $carbonEnd = CarbonImmutable::parse('2024-12-31');

    $service->shouldReceive('assignUserToUnit')
        ->once()
        ->with('user-1', 'unit-1', 'post-1', $carbonStart, $carbonEnd)->andReturn(true);

    $controller = new OrganisationUnitController($service);

    $mockRequest = Mockery::mock(AssignUserToUnitRequest::class);
    $mockRequest->shouldReceive('input')->with('post_id')->andReturn('post-1');
    $mockRequest->shouldReceive('input')->with('start_date')->andReturn($carbonStart);
    $mockRequest->shouldReceive('input')->with('end_date')->andReturn($carbonEnd);

    $controllerReflection = new ReflectionClass($controller);
    $method = $controllerReflection->getMethod('assignUserToUnit');
    $method->setAccessible(true);

    $method->invoke($controller, 'unit-1', 'user-1', $mockRequest);
});
