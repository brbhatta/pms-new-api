<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Models\User;

final readonly class LogoutUserAction
{
    public function __construct(
        private User $userModel
    ) {
    }

    public function handle(string $actorId): bool
    {
        $user = $this->userModel->newQuery()->find($actorId);

        if (!$user) {
            return false;
        }

        // Prefer the in-memory current access token (set by auth), but fall back to the latest persisted token.
        $token = $user->currentAccessToken() ?? $user->tokens()->latest('id')->first();

        return (bool) $token?->delete();
    }
}
