<?php

namespace Modules\Organisation\Application\Contracts;

use Carbon\CarbonImmutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Http\Data\OrganisationUnitData;

interface OrganisationUnitServiceInterface
{
    /**
     * @param  OrganisationUnitData  $data
     * @return OrganisationUnitData
     */
    public function createUnit(OrganisationUnitData $data): OrganisationUnitData;

    /**
     * @param  string  $unitId
     * @param  OrganisationUnitData  $data
     * @return OrganisationUnitData
     */
    public function updateUnit(string $unitId, OrganisationUnitData $data): OrganisationUnitData;

    /**
     * @param  string  $unitId
     * @return bool
     */
    public function deleteUnit(string $unitId): bool;

    /**
     * @param  int  $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUnits(int $perPage = 15): LengthAwarePaginator;

    /**
     * @param  string  $unitId
     * @return OrganisationUnitData|null
     */
    public function getUnitById(string $unitId): ?OrganisationUnitData;

    /**
     * @param  string  $userId
     * @param  string  $unitId
     * @param  string  $postId
     * @param  CarbonImmutable  $startDate
     * @param  CarbonImmutable|null  $endDate
     * @return bool
     */
    public function assignUserToUnit(string $userId, string $unitId, string $postId, CarbonImmutable $startDate, ?CarbonImmutable $endDate = null): bool;
}
