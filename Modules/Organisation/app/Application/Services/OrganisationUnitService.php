<?php

namespace Modules\Organisation\Application\Services;

use Carbon\CarbonImmutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;
use Modules\Organisation\Application\Contracts\PostServiceInterface;
use Modules\Organisation\Application\Exceptions\UnitNotFoundException;
use Modules\Organisation\Application\UseCases\AssignUserToUnitAction;
use Modules\Organisation\Application\UseCases\CreateOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\GetPaginatedOrganisationUnits;
use Modules\Organisation\Application\UseCases\GetOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\UpdateOrganisationUnitAction;
use Modules\Organisation\Application\UseCases\DeleteOrganisationUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Http\Data\PostData;
use Modules\User\Application\Contracts\UserServiceInterface;

final readonly class OrganisationUnitService implements OrganisationUnitServiceInterface
{
    public function __construct(
        private UserServiceInterface $userService,
        private CreateOrganisationUnitAction $createUnit,
        private GetPaginatedOrganisationUnits $getPaginated,
        private GetOrganisationUnitAction $getUnit,
        private UpdateOrganisationUnitAction $updateUnit,
        private DeleteOrganisationUnitAction $deleteUnit,
        private AssignUserToUnitAction $assignUser,
        private PostServiceInterface $postService,
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

    public function assignUserToUnit(
        string $userId,
        string $unitId,
        string $postId,
        CarbonImmutable $startDate,
        ?CarbonImmutable $endDate = null
    ): bool {
        $userData = $this->userService->findByUserId($userId);
        $organisationUnit = $this->getUnit->handle($unitId);
        $postData = $this->postService->findPost($postId);

        if (!$organisationUnit) {
            throw new UnitNotFoundException($userId);
        }

        return $this->assignUser->handle($userData, $organisationUnit, $postData, $startDate, $endDate);
    }
}
