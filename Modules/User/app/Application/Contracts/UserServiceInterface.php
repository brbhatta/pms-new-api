<?php

namespace Modules\User\Application\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Http\Data\UserData;

interface UserServiceInterface
{
    /**
     * @param  UserData  $data
     * @return UserData
     */
    public function createUser(UserData $data): UserData;

    /**
     * @param  string  $userId
     * @param  UserData  $data
     * @return UserData
     */
    public function updateUser(string $userId, UserData $data): UserData;

    /**
     * @param  string  $userId
     * @return bool
     */
    public function deleteUser(string $userId): bool;

    /**
     * @return LengthAwarePaginator<UserData>
     */
    public function getPaginatedUsers(): LengthAwarePaginator;

    /**
     * @param  string  $userId
     * @return UserData|null
     */
    public function getUserById(string $userId): ?UserData;
}
