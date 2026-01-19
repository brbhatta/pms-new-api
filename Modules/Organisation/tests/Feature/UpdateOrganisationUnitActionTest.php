<?php

use Modules\Organisation\Application\UseCases\UpdateOrganisationUnitAction;
use Modules\Organisation\Http\Data\OrganisationUnitData;
use Modules\Organisation\Models\OrganisationUnit;

uses(Modules\Organisation\Tests\TestCase::class);

it('updates an organisation unit', function () {
    $unit = OrganisationUnit::factory()->create(['name' => 'Original']);

    $data = OrganisationUnitData::from([
        'name' => 'Updated',
        'code' => 'UPD',
        'type' => 'department',
        'parent_id' => null,
        'metadata' => null,
    ]);

    $result = resolve(UpdateOrganisationUnitAction::class)->handle($unit->id, $data);

    expect($result)->toBeInstanceOf(OrganisationUnitData::class);
    expect($result->name)->toEqual('Updated');

    $fresh = OrganisationUnit::query()->find($unit->id);
    expect($fresh->name)->toEqual('Updated');
});
