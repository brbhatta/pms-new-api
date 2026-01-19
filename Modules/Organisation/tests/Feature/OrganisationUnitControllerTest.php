<?php

use Illuminate\Http\Request;
use Modules\Organisation\Http\Controllers\OrganisationUnitController;
use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;
use Modules\Organisation\Http\Data\OrganisationUnitData;

uses(Modules\Organisation\Tests\TestCase::class);

it('index calls service and returns collection resource', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $service->shouldReceive('getPaginatedUnits')->once()->andReturn(new Illuminate\Pagination\LengthAwarePaginator([],0,15));

    $controller = new OrganisationUnitController($service);

    $response = $controller->index();

    expect($response)->toBeInstanceOf(Illuminate\Http\Resources\Json\JsonResource::class);
});

it('store calls service and returns resource', function () {
    $service = $this->mock(OrganisationUnitServiceInterface::class);
    $data = OrganisationUnitData::from(['name'=>'A','code'=>'C','type'=>'department','parent_id'=>null,'metadata'=>null]);

    $service->shouldReceive('createUnit')->once()->with(Mockery::on(function ($arg) {
        return $arg instanceof OrganisationUnitData && $arg->name === 'A' && $arg->code === 'C';
    }))->andReturn($data);

    $controller = new OrganisationUnitController($service);
    $request = new Request($data->toArray());

    $res = $controller->store($request);
    expect($res)->toBeInstanceOf(Illuminate\Http\Resources\Json\JsonResource::class);
});
