<?php

namespace Modules\User\Application\Contracts;

interface AuthServiceInterface
{
    public function login(string $email, string $password): string;

    public function logout(string $actorId): bool;
}
