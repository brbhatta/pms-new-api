<?php

namespace Modules\Organisation\Application\UseCases;

use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

class GetOrganisationUnitAction
{
    public function __construct(private OrganisationUnit $model)
    {
    }

    public function handle(string $unitId): ?OrganisationUnitData
    {
        $unit = $this->model->newQuery()->find($unitId);
        return $unit ? OrganisationUnitData::from($unit) : null;
    }
}
