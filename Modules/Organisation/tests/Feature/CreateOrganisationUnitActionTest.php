<?php

use Modules\Organisation\Application\UseCases\CreateOrganisationUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

uses(Modules\Organisation\Tests\TestCase::class);

it('can create organisation unit', function () {
    $organisationData = OrganisationUnitData::from(
        OrganisationUnit::factory()->make()
    );

    $result = resolve(CreateOrganisationUnitAction::class)->handle($organisationData);

    expect($result)->toBeInstanceOf(OrganisationUnitData::class);
    expect($result->except('id')->toArray())->toBe($organisationData->except('id')->toArray());
});
