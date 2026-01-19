<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Application\Exceptions\UserNotFoundException;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

final readonly class GetUserAction
{
    public function __construct(
        private User $userModel
    ) {
    }

    public function handle(string $userId): UserData
    {
        $user = $this->userModel->newQuery()->find($userId);

        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        return UserData::from($user);
    }
}
