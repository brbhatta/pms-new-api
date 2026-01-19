<?php

namespace Modules\Organisation\Application\UseCases;

use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

final readonly class CreateOrganisationUnitAction
{
    public function __construct(private OrganisationUnit $model)
    {
    }

    public function handle(OrganisationUnitData $data): OrganisationUnitData
    {
        $payload = $data->toArray();
        $unit = $this->model->newQuery()->create($payload);

        return OrganisationUnitData::from($unit);
    }
}
