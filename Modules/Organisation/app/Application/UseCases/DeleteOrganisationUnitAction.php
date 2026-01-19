<?php

namespace Modules\Organisation\Application\UseCases;

use Modules\Organisation\Models\OrganisationUnit;

final readonly class DeleteOrganisationUnitAction
{
    public function __construct(private OrganisationUnit $model)
    {
    }

    public function handle(string $unitId): bool
    {
        $unit = $this->model->newQuery()->findOrFail($unitId);
        return (bool) $unit->delete();
    }
}
