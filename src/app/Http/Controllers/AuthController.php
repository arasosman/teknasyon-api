<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
     * @return User|string
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
            return $user;
        }
        return response()->json([
            'message' => 'fail'
        ], 400);
    }

    /**
     * Login user and create token
     *
     * @param string email
     * @param string password
     * @return User|string user
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        return $this->userRepository->update($user, ['api_token' => Str::random(60)]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return string message
     */
    public function logout(Request $request)
    {
        $user = $this->userRepository->findBytoken($request);
        $this->userRepository->update($user, ['api_token' => '']);
        return response()->json([
            'message' => 'Successfully logged out'
        ])->setStatusCode(200);
    }

    /**
     * Get the authenticated User
     * @return \HttpResponse|string $user
     */
    public function user(Request $request)
    {
        $user = $this->userRepository->findByToken($request);
        return response()->json($user)->setStatusCode(200);
    }
}
