<?php

namespace Modules\Organisation\Application\UseCases;

use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

class UpdateOrganisationUnitAction
{
    public function __construct(private OrganisationUnit $model)
    {
    }

    public function handle(string $unitId, OrganisationUnitData $data): OrganisationUnitData
    {
        $payload = $data->toArray();
        $unit = $this->model->newQuery()->findOrFail($unitId);
        $unit->update($payload);
        return OrganisationUnitData::from($unit->refresh());
    }
}
