<?php

namespace App\Exceptions;

use Psr\Log\LogLevel;
use RuntimeException;
use Throwable;

class ApplicationException extends RuntimeException
{
    public function __construct(
        protected int $httpStatusCode,
        protected string $errorCode,
        string $message,
        ?Throwable $previous = null,
        protected string $logLevel = LogLevel::ERROR,
    ) {
        parent::__construct($message, $httpStatusCode, $previous);
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getLogLevel(): string
    {
        return $this->logLevel;
    }
}
