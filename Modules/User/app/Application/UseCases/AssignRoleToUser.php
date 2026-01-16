<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Application\Contracts\UserInterface;
use Modules\User\Domain\Policies\RoleHierarchyPolicy;
use Modules\User\Models\Role;

class AssignRoleToUser
{
    private UserInterface $userService;
    private RoleHierarchyPolicy $rolePolicy;

    public function __construct(UserInterface $userService, RoleHierarchyPolicy $rolePolicy)
    {
        $this->userService = $userService;
        $this->rolePolicy = $rolePolicy;
    }

    public function execute(int $userId, int $roleId): bool
    {
        $user = $this->userService->getUserById($userId);
        if (!$user) {
            throw new \Exception('User not found');
        }

        $role = Role::findOrFail($roleId);

        // Check role hierarchy policy
        if (!$this->rolePolicy->canAssignRole($user, $role)) {
            throw new \Exception('Cannot assign role due to hierarchy restrictions');
        }

        $user->roles()->attach($role);
        return true;
    }
}
