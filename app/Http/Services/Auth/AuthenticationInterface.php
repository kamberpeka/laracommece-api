<?php

namespace App\Http\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

interface AuthenticationInterface
{
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check() : bool;

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated user
     *
     * @return int
     */
    public function id() : int;

    /**
     * @param array $credentials
     * @param bool $remember
     * @return JsonResponse
     */
    public function login(array $credentials, $remember = false) : JsonResponse;

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout() : void;

    /**
     * @param array $userData
     * @return JsonResponse
     */
    public function register(array $userData) : JsonResponse;
}
