<?php

namespace Modules\Organisation\Application\UseCases;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

class GetPaginatedOrganisationUnits
{
    public function __construct(private OrganisationUnit $model)
    {
    }

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->paginate($perPage)
            ->through(fn (OrganisationUnit $unit) => OrganisationUnitData::from($unit));
    }
}
