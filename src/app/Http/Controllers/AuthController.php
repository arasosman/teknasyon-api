<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepositoryContract::class);
    }

    /**
     * Create user
     *
     * @param string name
     * @param string email
     * @param string password
     * @return UserResource
     */
    public function register(RegisterRequest $request)
    {
        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(60)
        ];
        $user = $this->userRepository->create($params);
        if ($user) {
            return new UserResource($user, BaseResource::HTTP_CREATED, BaseResource::$statusTexts[BaseResource::HTTP_CREATED]);
        }
        return new UserResource(null, BaseResource::HTTP_BAD_REQUEST, BaseResource::$statusTexts[BaseResource::HTTP_BAD_REQUEST]);
    }

    /**
     * Login user and create token
     *
     * @param string email
     * @param string password
     * @return UserResource
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return new UserResource(null, BaseResource::HTTP_UNAUTHORIZED, BaseResource::$statusTexts[BaseResource::HTTP_UNAUTHORIZED]);
        }

        $user = $request->user();
        $user = $this->userRepository->update($user, ['api_token' => Str::random(60)]);
        return new UserResource($user, BaseResource::HTTP_ACCEPTED, BaseResource::$statusTexts[BaseResource::HTTP_ACCEPTED]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return UserResource message
     */
    public function logout(Request $request)
    {
        $user = $this->userRepository->findBytoken($request);
        $this->userRepository->update($user, ['api_token' => '']);
        return new UserResource(null, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
    }

    /**
     * Get the authenticated User
     * @return UserResource
     */
    public function user(Request $request)
    {
        $user = $this->userRepository->findByToken($request);
        return new UserResource($user, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
    }
}
