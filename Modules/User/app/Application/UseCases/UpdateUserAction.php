<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Http\Events\UserProfileUpdated;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

final readonly class UpdateUserAction
{
    public function __construct(
        private User $user
    ) {
    }

    public function handle(string $userId, UserData $data): UserData
    {
        $user = $this->user->findOrFail($userId);
        $user->update($data->toArray());

        event(new UserProfileUpdated($userId, array_keys($data->toArray())));

        return UserData::from($user);
    }
}
