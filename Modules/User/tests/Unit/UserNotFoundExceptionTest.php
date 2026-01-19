<?php

use Modules\User\Application\Exceptions\UserNotFoundException;
use App\Exceptions\ApplicationException;

uses(Modules\User\Tests\TestCase::class);

it('has correct properties', function () {
    $ex = new UserNotFoundException('user-123');

    expect($ex)->toBeInstanceOf(ApplicationException::class);
    expect($ex->getHttpStatusCode())->toBe(404);
    expect($ex->getErrorCode())->toBe('USER_NOT_FOUND');
    expect($ex->getMessage())->toContain('user-123');
});
