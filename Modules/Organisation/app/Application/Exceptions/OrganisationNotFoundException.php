<?php

namespace Modules\Organisation\Application\Exceptions;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrganisationNotFoundException extends ApplicationException
{
    public function __construct(string $organisationId)
    {
        parent::__construct(
            httpStatusCode: ResponseAlias::HTTP_NOT_FOUND,
            errorCode: 'ORGANISATION_NOT_FOUND',
            message: "Organisation with ID {$organisationId} not found.",
            logLevel: LogLevel::WARNING
        );
    }
}
