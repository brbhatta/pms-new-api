<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Organisation\Application\UseCases\GetPaginatedOrganisationUnits;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

uses(Modules\Organisation\Tests\TestCase::class);

it('returns paginated organisation units mapped to OrganisationUnitData', function () {
    OrganisationUnit::factory()->count(30)->create();

    $paginator = resolve(GetPaginatedOrganisationUnits::class)->handle();

    expect($paginator)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($paginator->count())->toBeLessThanOrEqual(15);

    $first = $paginator->first();
    expect($first)->toBeInstanceOf(OrganisationUnitData::class);
});
