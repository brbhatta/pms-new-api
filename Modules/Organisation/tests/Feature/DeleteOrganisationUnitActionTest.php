<?php

use Modules\Organisation\Application\UseCases\DeleteOrganisationUnitAction;
use Modules\Organisation\Models\OrganisationUnit;

uses(Modules\Organisation\Tests\TestCase::class);

it('deletes an organisation unit', function () {
    $unit = OrganisationUnit::factory()->create();

    $result = resolve(DeleteOrganisationUnitAction::class)->handle($unit->id);

    expect($result)->toBeTrue();

    $db = OrganisationUnit::query()->find($unit->id);
    expect($db)->toBeNull();
});
