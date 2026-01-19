<?php

use Modules\Organisation\Application\Exceptions\OrganisationNotFoundException;
use App\Exceptions\ApplicationException;
use Psr\Log\LogLevel;

uses(Modules\Organisation\Tests\TestCase::class);

it('has correct properties and inherits from ApplicationException', function () {
    $orgId = 'non-existent-id';

    $exception = new OrganisationNotFoundException($orgId);

    expect($exception)->toBeInstanceOf(ApplicationException::class);
    expect($exception->getHttpStatusCode())->toBe(404);
    expect($exception->getErrorCode())->toBe('ORGANISATION_NOT_FOUND');
    expect($exception->getMessage())->toContain($orgId);
    expect($exception->getLogLevel())->toBe(LogLevel::WARNING);
});
