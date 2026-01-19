<?php

namespace Modules\User\Application\Services;

use Modules\User\Application\Contracts\AuthServiceInterface;
use Modules\User\Application\UseCases\AuthenticateUserAction;
use Modules\User\Application\UseCases\LogoutUserAction;

final readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        private AuthenticateUserAction $authenticate,
        private LogoutUserAction $logout
    ) {
    }

    public function login(string $email, string $password): string
    {
        return $this->authenticate->handle($email, $password);
    }

    public function logout(string $actorId): bool
    {
        return $this->logout->handle($actorId);
    }
}
