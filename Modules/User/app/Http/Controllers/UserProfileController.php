<?php

namespace Modules\User\Http\Controllers;

use App\Framework\CommandBus;
use App\Framework\Facades\QueryBus;
use Illuminate\Http\Request;
use Modules\User\Application\Commands\CreateUserProfileCommand;
use Modules\User\Application\Commands\UpdateUserProfileCommand;
use Modules\User\Application\Queries\GetUserProfileQuery;
use Modules\User\Http\Data\CreateUserProfileData;
use Modules\User\Http\Data\UpdateUserProfileData;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController
{
    public function store(Request $request, string $userId)
    {
        $data = CreateUserProfileData::validateAndCreate($request->all());
        $user = CommandBus::dispatch(new CreateUserProfileCommand($userId, $data));

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(string $userId)
    {
        $query = new GetUserProfileQuery($userId);

        $userProfile = QueryBus::dispatch($query);

        return response()->json($userProfile, Response::HTTP_OK);
    }

    public function update(Request $request, string $userId)
    {
        $data = UpdateUserProfileData::validateAndCreate($request->all());

        $command = new UpdateUserProfileCommand($userId, $data);

        $user = CommandBus::dispatch($command);

        return response()->json($user, Response::HTTP_OK);
    }
}
