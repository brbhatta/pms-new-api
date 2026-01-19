<?php

use Modules\Organisation\Application\UseCases\GetOrganisationUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

uses(Modules\Organisation\Tests\TestCase::class);

it('fetches an organisation unit by id', function () {
    $unit = OrganisationUnit::factory()->create();

    $result = resolve(GetOrganisationUnitAction::class)->handle($unit->id);

    expect($result)->toBeInstanceOf(OrganisationUnitData::class);
    expect($result->id)->toEqual($unit->id);
    expect($result->name)->toEqual($unit->name);
});
