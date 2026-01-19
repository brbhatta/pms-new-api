<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenericResponse;
use Illuminate\Http\Request;
use Modules\User\Application\Contracts\AuthServiceInterface;

final  class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $token = $this->authService->login($request->email, $request->password);

        return response()->json([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
        ]);
    }

    public function logout()
    {
        $actorId = (string) auth()->id();
        $this->authService->logout($actorId);

        return GenericResponse::success("Successfully logged out.");
    }
}
