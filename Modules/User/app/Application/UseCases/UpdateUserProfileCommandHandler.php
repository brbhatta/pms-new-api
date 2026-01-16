<?php

namespace Modules\User\Application\UseCases;

use App\Framework\Command;
use App\Framework\CommandHandler;
use Modules\User\Application\Commands\UpdateUserProfileCommand;
use Modules\User\Domain\Models\User;

class UpdateUserProfileCommandHandler implements CommandHandler
{
    /**
     * @param  UpdateUserProfileCommand  $command
     * @return User
     */
    public function handle(Command $command): User
    {
        $user = User::findOrFail($command->userId);

        $data = array_filter([
            'full_name' => $command->data->fullName,
            'address' => $command->data->address,
            'profile_picture' => $command->data->profilePicture,
            'employee_identifier' => $command->data->employeeIdentifier,
        ], fn($value) => $value !== null);

        $user->updateProfile($data);

        return $user;
    }
}
