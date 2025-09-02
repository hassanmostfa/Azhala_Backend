<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthService;
use App\Http\Requests\UserRequest;

class AuthController extends BaseApiController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user
     */
    public function register(UserRequest $request)
    {
        $result = $this->authService->register($request->validated());

        if ($result['success']) {
            return $this->successResponse($result, $result['message']);
        }

        return $this->errorResponse($result['message']);
    }

    /**
     * Logout current user (revoke all tokens)
     */
    public function logout()
    {
        $result = $this->authService->logout();

        if ($result['success']) {
            return $this->successResponse(null, $result['message']);
        }

        return $this->errorResponse($result['message']);
    }
}
