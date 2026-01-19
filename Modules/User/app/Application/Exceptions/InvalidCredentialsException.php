<?php

namespace Modules\User\Application\Exceptions;

use App\Exceptions\ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class InvalidCredentialsException extends ApplicationException
{
    public function __construct(){
        parent::__construct(
            httpStatusCode: ResponseAlias::HTTP_BAD_REQUEST,
            errorCode: 'INVALID_CREDENTIALS',
            message: "The provided credentials are incorrect.",
        );
    }
}
