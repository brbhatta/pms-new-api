<?php

namespace Modules\User\Application\Services;

use Modules\User\Application\Contracts\UserInterface;
use Modules\User\Domain\Models\User;

class UserService implements UserInterface
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function assignRoleToUser(int $userId, int $roleId): bool
    {
        $user = User::findOrFail($userId);
        $user->roles()->attach($roleId);
        return true;
    }

    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }
}
