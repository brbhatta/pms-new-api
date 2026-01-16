<?php

namespace Modules\User\Domain\Policies;

use Modules\User\Models\Role;
use Modules\User\Models\User;

class RoleHierarchyPolicy
{
    public function canAssignRole(User $user, Role $role): bool
    {
        // Example: Prevent assigning higher roles to lower users
        // Implement based on your hierarchy logic (e.g., check user's current roles)
        $userHighestRoleLevel = $user->roles()->max('level'); // Assuming 'level' column in roles
        return $role->level >= $userHighestRoleLevel;
    }
}
