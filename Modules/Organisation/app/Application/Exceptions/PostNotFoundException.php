<?php

namespace Modules\Organisation\Application\Exceptions;

use App\Exceptions\ApplicationException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PostNotFoundException extends ApplicationException
{
    public function __construct(string $postId)
    {
        parent::__construct(
            httpStatusCode: ResponseAlias::HTTP_NOT_FOUND,
            errorCode: 'ORGANISATION_NOT_FOUND',
            message: "Organisation with ID {$postId} not found.",
            logLevel: LogLevel::WARNING
        );
    }
}
