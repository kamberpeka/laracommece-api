<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\Auth\AuthenticationInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @param AuthenticationInterface $authentication
     */
    public function __construct(AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->authentication->login(
            $request->only('email', 'password')
        );
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        $this->authentication->logout();

        return response()->json(null, 204);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $request->merge(['full_name' => $request->input('name')]);

        return $this->authentication->register($request->all());
    }

    /**
     * @return UserResource
     */
    public function user()
    {
        return new UserResource($this->authentication->user());
    }
}
