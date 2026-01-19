<?php

namespace Modules\User\Application\UseCases;

use Illuminate\Support\Facades\Log;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

final readonly class DeleteUserAction
{
    public function __construct(
        private User $model
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(UserData $user): bool
    {
        Log::info("Deleting user with ID: {$user->id}");

        return $this->model->newQuery()->where('id', $user->id)->delete();
    }
}
