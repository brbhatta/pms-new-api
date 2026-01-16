<?php

namespace Modules\User\Application\Contracts;

interface UserInterface
{
    public function createUser(array $data): \Modules\User\Models\User;
    public function assignRoleToUser(int $userId, int $roleId): bool;
    public function getUserById(int $id): ?\Modules\User\Models\User;
}
