<?php

namespace Modules\User\Application\UseCases;

use Illuminate\Support\Facades\DB;
use Modules\User\Http\Data\UserData;
use Modules\User\Http\Events\UserProfileCreated;
use Modules\User\Models\User;
use Throwable;

final readonly class CreateUserAction
{
    public function __construct(
        private User $userModel,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(UserData $data): UserData
    {
        $dataToInsert = $data->toArray();
        $dataToInsert['password'] = bcrypt($data->password);

        $user = $this->userModel->newQuery()->create($dataToInsert);

        event(new UserProfileCreated($user->id));

        DB::commit();

        return UserData::from($user);
    }
}
