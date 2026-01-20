<?php

use Modules\Organisation\Application\Exceptions\PostNotFoundException;
use App\Exceptions\ApplicationException;
use Psr\Log\LogLevel;

uses(Modules\Organisation\Tests\TestCase::class);

it('has correct properties and inherits from ApplicationException', function () {
    $postId = 'non-existent-post-id';

    $exception = new PostNotFoundException($postId);

    expect($exception)->toBeInstanceOf(ApplicationException::class)
        ->and($exception->getHttpStatusCode())->toBe(404)
        ->and($exception->getErrorCode())->toBe('ORGANISATION_NOT_FOUND')
        ->and($exception->getMessage())->toContain($postId)
        ->and($exception->getLogLevel())->toBe(LogLevel::WARNING);
});
