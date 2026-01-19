<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Application\Services\OrganisationUnitService;
use Modules\Organisation\Application\UseCases\CreateOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\GetPaginatedOrganisationUnits;
use Modules\Organisation\Application\UseCases\GetOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\UpdateOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\DeleteOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\AssignUserToUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;

uses(Modules\Organisation\Tests\TestCase::class);

beforeEach(function () {
    $this->createUseCase = $this->mock(CreateOrganisationUnitAction::class);
    $this->getPaginatedUseCase = $this->mock(GetPaginatedOrganisationUnits::class);
    $this->getUseCase = $this->mock(GetOrganisationUnitAction::class);
    $this->updateUseCase = $this->mock(UpdateOrganisationUnitAction::class);
    $this->deleteUseCase = $this->mock(DeleteOrganisationUnitAction::class);
    $this->assignUseCase = $this->mock(AssignUserToUnitAction::class);

    $this->service = new OrganisationUnitService(
        $this->createUseCase,
        $this->getPaginatedUseCase,
        $this->getUseCase,
        $this->updateUseCase,
        $this->deleteUseCase,
        $this->assignUseCase
    );
});

afterEach(function () {
    Mockery::close();
});

it('delegates create to CreateOrganisationUnitAction', function () {
    $input = OrganisationUnitData::from([
        'name' => 'A',
        'code' => 'C',
        'type' => 'department',
        'parent_id' => null,
        'metadata' => null,
    ]);

    $this->createUseCase->shouldReceive('handle')->once()->with($input)->andReturn($input);

    $result = $this->service->createUnit($input);

    expect($result)->toBe($input);
});

it('delegates update to UpdateOrganisationUnitAction', function () {
    $input = OrganisationUnitData::from([
        'name' => 'B',
        'code' => 'C',
        'type' => 'department',
        'parent_id' => null,
        'metadata' => null,
    ]);

    $this->updateUseCase->shouldReceive('handle')->once()->with('id123', $input)->andReturn($input);

    $result = $this->service->updateUnit('id123', $input);

    expect($result)->toBe($input);
});

it('delegates delete to DeleteOrganisationUnitAction', function () {
    $this->deleteUseCase->shouldReceive('handle')->once()->with('id123')->andReturn(true);

    $result = $this->service->deleteUnit('id123');

    expect($result)->toBeTrue();
});

it('delegates getPaginated to GetPaginatedOrganisationUnits', function () {
    $paginator = new LengthAwarePaginator([], 0, 15);

    $this->getPaginatedUseCase->shouldReceive('handle')->once()->with(15)->andReturn($paginator);

    $result = $this->service->getPaginatedUnits(15);

    expect($result)->toBe($paginator);
});

it('delegates getUnitById to GetOrganisationUnitAction', function () {
    $data = OrganisationUnitData::from([
        'id' => 'id1',
        'name' => 'N',
        'code' => 'C',
        'type' => 'department',
        'parent_id' => null,
        'metadata' => null,
    ]);

    $this->getUseCase->shouldReceive('handle')->once()->with('id1')->andReturn($data);

    $result = $this->service->getUnitById('id1');

    expect($result)->toBe($data);
});
