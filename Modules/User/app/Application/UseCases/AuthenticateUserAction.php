<?php

namespace Modules\User\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\User\Application\Exceptions\InvalidCredentialsException;
use Modules\User\Models\User;

final readonly class AuthenticateUserAction
{
    public function __construct(
        private User $userModel
    ) {
    }

    public function handle(string $email, string $password): string
    {
        $user = $this->userModel->newQuery()->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}
