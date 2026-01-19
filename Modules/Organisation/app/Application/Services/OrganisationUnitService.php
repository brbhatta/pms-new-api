<?php

namespace Modules\Organisation\Application\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;
use Modules\Organisation\Application\UseCases\CreateOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\GetPaginatedOrganisationUnits;
use Modules\Organisation\Application\UseCases\GetOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\UpdateOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\DeleteOrganisationUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;

final readonly class OrganisationUnitService implements OrganisationUnitServiceInterface
{
    public function __construct(
        private CreateOrganisationUnitAction $createUnit,
        private GetPaginatedOrganisationUnits $getPaginated,
        private GetOrganisationUnitAction $getUnit,
        private UpdateOrganisationUnitAction $updateUnit,
        private DeleteOrganisationUnitAction $deleteUnit,
    ) {
    }

    public function createUnit(OrganisationUnitData $data): OrganisationUnitData
    {
        return $this->createUnit->handle($data);
    }

    public function updateUnit(string $unitId, OrganisationUnitData $data): OrganisationUnitData
    {
        return $this->updateUnit->handle($unitId, $data);
    }

    public function deleteUnit(string $unitId): bool
    {
        return $this->deleteUnit->handle($unitId);
    }

    public function getPaginatedUnits(int $perPage = 15): LengthAwarePaginator
    {
        return $this->getPaginated->handle($perPage);
    }

    public function getUnitById(string $unitId): ?OrganisationUnitData
    {
        return $this->getUnit->handle($unitId);
    }
}
