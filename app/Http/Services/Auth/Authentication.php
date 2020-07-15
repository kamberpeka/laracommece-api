<?php

namespace App\Http\Services\Auth;

use App\Enums\RoleEnum;
use App\Models\User\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Exception;

class Authentication implements AuthenticationInterface
{
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;

    /**
     * @param UserRepositoryContract $userRepository
     */
    public function __construct(
        UserRepositoryContract $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check() : bool
    {
        return $this->guard()->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        return $this->guard()->user();
    }

    /**
     * Get the ID for the currently authenticated user
     *
     * @return int
     */
    public function id() : int
    {
        $user = $this->user();

        if ($user !== null) {
            $user->id;
        }

        return 0;
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @return JsonResponse
     */
    public function login(array $credentials, $remember = false) : JsonResponse
    {
        try{
            if ($this->guard()->attempt($credentials + ['guest' => 0, 'banned' => '0'])) {

                $user = $this->guard()->user();

                return $this->respondWithToken($user->createToken('api'));
            }

        } catch(Exception $exception){
            Log::error('Authentication::login Exception Error: ' . $exception->getMessage());
        }

        return response()->json(['error' => __('auth.failed')], 401);
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout() : void
    {
        if($this->check()){

            $this->user()->token()->revoke();
        }
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function register(array $data) : JsonResponse
    {
        try {
            $user = $this->userRepository->findBy('email', $data['email']);

            if(!$user){
                $user = $this->userRepository->create(
                    Arr::only($data, [
                        'first_name',
                        'last_name',
                        'email',
                        'password',
                        'guest'
                    ]) + [
                        'role' => RoleEnum::CUSTOMER
                    ]
                );
            } else {
                $user->update(
                    Arr::only($data, [
                        'first_name',
                        'last_name',
                        'password',
                    ]) + [
                        'guest' => 0
                    ]
                );
            }

            if(!$user->isGuest())
                $this->logUserIn($user);

//            event(new Registered($user));

            $this->registered($user);

            return $this->respondWithToken($user->createToken('api'));

        } catch (Exception $exception){
            Log::error('Authentication::register Exception Error: ' . $exception->getMessage());

            return response()->json(['message' => __('auth.register_error')], 400);
        }
    }

    protected function registered($user)
    {
        //
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken($token) : JsonResponse
    {
        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $this->user()
        ]);
    }

    /**
     * Log a user into the application.
     *
     * @param $user
     * @return void
     */
    protected function logUserIn($user)
    {
        $this->guard()->login($user);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
