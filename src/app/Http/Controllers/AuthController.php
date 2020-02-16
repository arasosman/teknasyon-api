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

    /** @SWG\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Kayıt işlemi",
     *     description="Kayıt işlemi",
     *     @SWG\Parameter(
     *          name="name",
     *          description="email adresi",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="email",
     *          description="User e-mail address",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="password",
     *          description="Kullanıcı şifresi",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Kayıt Başarılı",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="errorCode",
     *                  type="int"
     *             ),
     *             @SWG\Property(
     *                  property="errorMessage",
     *                  type="string"
     *             ),
     *             @SWG\Property(
     *                  property="data",
     *                  type="string"
     *             )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     )
     * )
     * @param RegisterRequest $request
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

    /** @SWG\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login işlemi",
     *     description="Login işlemi",
     *     @SWG\Parameter(
     *          name="email",
     *          description="User e-mail address",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="password",
     *          description="User password",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Kayıt Başarılı",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="errorCode",
     *                  type="int"
     *             ),
     *             @SWG\Property(
     *                  property="errorMessage",
     *                  type="string"
     *             ),
     *             @SWG\Property(
     *                  property="data",
     *                  type="string"
     *             )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     )
     * )
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

    /** @SWG\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Logout işlemi",
     *     description="Login işlemi",
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Kayıt Başarılı",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="errorCode",
     *                  type="int"
     *             ),
     *             @SWG\Property(
     *                  property="errorMessage",
     *                  type="string"
     *             ),
     *             @SWG\Property(
     *                  property="data",
     *                  type="string"
     *             )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     )
     * )
     * @param Request $request
     * @return UserResource
     */
    public function logout(Request $request)
    {
        $user = $this->userRepository->findBytoken($request);
        $this->userRepository->update($user, ['api_token' => '']);
        return new UserResource(null, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
    }

    /** @SWG\Get(
     *     path="/api/user",
     *     tags={"Auth"},
     *     summary="Profil bilgisi",
     *     description="Profil bilgisi",
     *     @SWG\Parameter(
     *          name="token",
     *          description="User token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="profile data",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="user_id",
     *                  type="integer"),
     *              @SWG\Property(
     *                  property="name_surname",
     *                  type="string"),
     *              @SWG\Property(
     *                  property="age",
     *                  type="integer"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     )
     * )
     * @param Request $request
     * @return UserResource
     */
    public function user(Request $request)
    {
        $user = $this->userRepository->findByToken($request);
        return new UserResource($user, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
    }
}
