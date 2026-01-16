<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Application\Contracts\UserInterface;
use Modules\User\Models\Department;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class CreateUser
{
    private UserInterface $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function execute(array $data): User
    {
        // Validate data (e.g., using Laravel validation if applicable)
        $user = $this->userService->createUser($data);

        // Assign department if provided
        if (isset($data['department_id'])) {
            $department = Department::findOrFail($data['department_id']);
            $user->department()->associate($department);
        }

        // Assign default role if provided
        if (isset($data['role_id'])) {
            $role = Role::findOrFail($data['role_id']);
            $user->roles()->attach($role);
        }

        $user->save();
        return $user;
    }
}
