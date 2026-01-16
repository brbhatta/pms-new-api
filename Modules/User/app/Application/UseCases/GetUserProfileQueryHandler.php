<?php

namespace Modules\User\Application\UseCases;

use App\Framework\Query;
use App\Framework\QueryHandler;
use Modules\User\Application\Queries\GetUserProfileQuery;
use Modules\User\Domain\Models\User;
use Modules\User\Http\Data\UserProfileData;

class GetUserProfileQueryHandler implements QueryHandler
{
    /**
     * @param  GetUserProfileQuery  $query
     * @return UserProfileData
     */
    public function handle(Query $query): UserProfileData
    {
        $user = User::findOrFail($query->userId);

        return UserProfileData::from([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'fullName' => $user->full_name,
            'address' => $user->address,
            'profilePicture' => $user->profile_picture,
            'employeeIdentifier' => $user->employee_identifier,
            'emailVerifiedAt' => $user->email_verified_at?->toISOString(),
            'createdAt' => $user->created_at->toISOString(),
            'updatedAt' => $user->updated_at->toISOString(),
        ]);
    }
}
