<?php

namespace Modules\User\Application\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Application\Contracts\UserServiceInterface;
use Modules\User\Application\Exceptions\UserNotFoundException;
use Modules\User\Application\UseCases\CreateUserAction;
use Modules\User\Application\UseCases\DeleteUserAction;
use Modules\User\Application\UseCases\GetPaginatedUsers;
use Modules\User\Application\UseCases\GetUserAction;
use Modules\User\Application\UseCases\UpdateUserAction;
use Modules\User\Http\Data\UserData;

final readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private GetUserAction $getUserAction,
        private GetPaginatedUsers $getPaginatedUsers,
        private CreateUserAction $createUserAction,
        private UpdateUserAction $updateUserAction,
        private DeleteUserAction $deleteUserAction,
    ) {
    }

    public function findByUserId(string $userId): UserData
    {
        return $this->getUserById($userId) ?? throw new UserNotFoundException($userId);
    }

    /**
     * @param  string  $userId
     * @return UserData|null
     */
    public function getUserById(string $userId): ?UserData
    {
        try {
            return $this->getUserAction->handle($userId);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function createUser(UserData $data): UserData
    {
        return $this->createUserAction->handle($data, collect());
    }

    public function updateUser(string $userId, UserData $data): UserData
    {
        return $this->updateUserAction->handle($userId, $data);
    }

    public function deleteUser(string $userId): bool
    {
        $userData = $this->findByUserId($userId);

        return $this->deleteUserAction->handle($userData);
    }

    public function getPaginatedUsers(): LengthAwarePaginator
    {
        return $this->getPaginatedUsers->handle();
    }
}
