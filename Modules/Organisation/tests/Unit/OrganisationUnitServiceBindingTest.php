<?php

use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;

uses(Modules\Organisation\Tests\TestCase::class);

it('resolves the OrganisationUnitServiceInterface from the container', function () {
    $service = app()->make(OrganisationUnitServiceInterface::class);
    expect($service)->toBeInstanceOf(OrganisationUnitServiceInterface::class);
});
