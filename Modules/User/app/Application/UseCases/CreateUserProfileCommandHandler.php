<?php

namespace Modules\User\Application\UseCases;

use App\Framework\Command;
use App\Framework\CommandHandler;
use Modules\User\Domain\Models\User;
use Modules\User\Events\UserProfileCreated;

class CreateUserProfileCommandHandler implements CommandHandler
{
    public function handle(Command $command): User
    {
        $user = User::findOrFail($command->userId);

        $user->update([
            'full_name' => $command->data->fullName,
            'address' => $command->data->address,
            'profile_picture' => $command->data->profilePicture,
            'employee_identifier' => $command->data->employeeIdentifier,
        ]);

        event(UserProfileCreated::dispatch($user->id, $command->data->toArray()));

        return $user;
    }
}
