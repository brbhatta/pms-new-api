<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenericResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Application\Contracts\UserServiceInterface;
use Modules\User\Application\Exceptions\UserNotFoundException;

use Modules\User\Http\Data\UserData;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $data = $this->userService->getPaginatedUsers();

        return GenericResponse::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = UserData::from($request->all());

        $result = $this->userService->createUser($data);

        return GenericResponse::resource($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = UserData::from($request->all());

        $result = $this->userService->updateUser($id, $data);

        return GenericResponse::resource($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if (!$result) {
            GenericResponse::failed("FAILED.TO.DELETE.USER", "Failed to delete user.");
        }

        return GenericResponse::success("User deleted successfully.");
    }

    public function currentUser(): UserData
    {
        $result = $this->userService->getUserById(auth()->id());

        if ($result === null) {
            throw new UserNotFoundException(auth()->id());
        }

        return $result;
    }
}
