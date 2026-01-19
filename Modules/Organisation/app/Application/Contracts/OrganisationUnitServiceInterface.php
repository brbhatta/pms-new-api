<?php

namespace Modules\Organisation\Application\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Http\Data\OrganisationUnitData;

interface OrganisationUnitServiceInterface
{
    public function createUnit(OrganisationUnitData $data): OrganisationUnitData;

    public function updateUnit(string $unitId, OrganisationUnitData $data): OrganisationUnitData;

    public function deleteUnit(string $unitId): bool;

    public function getPaginatedUnits(int $perPage = 15): LengthAwarePaginator;

    public function getUnitById(string $unitId): ?OrganisationUnitData;
}
