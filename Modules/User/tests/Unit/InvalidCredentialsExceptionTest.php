<?php

use Modules\User\Application\Exceptions\InvalidCredentialsException;
use App\Exceptions\ApplicationException;
use Psr\Log\LogLevel;

uses(Modules\User\Tests\TestCase::class);

it('has correct properties', function () {
    $ex = new InvalidCredentialsException();

    expect($ex)->toBeInstanceOf(ApplicationException::class);
    expect($ex->getHttpStatusCode())->toBe(400);
    expect($ex->getErrorCode())->toBe('INVALID_CREDENTIALS');
    expect($ex->getMessage())->toBe('The provided credentials are incorrect.');
});
