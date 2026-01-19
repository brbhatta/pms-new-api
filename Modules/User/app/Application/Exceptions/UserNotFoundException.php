<?php

namespace Modules\User\Application\Exceptions;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;
use Psr\Log\LogLevel;
use Throwable;

class UserNotFoundException extends ApplicationException
{
    public function __construct(string $userId, ?Throwable $previous = null){
        parent::__construct(
            httpStatusCode: Response::HTTP_NOT_FOUND,
            errorCode: 'USER_NOT_FOUND',
            message: "User with ID {$userId} not found.",
            previous: $previous,
            logLevel: LogLevel::WARNING
        );
    }
}
