<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Http\Requests\SongRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\SongResource;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /** @var UserRepositoryContract */
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepositoryContract::class);
    }

    /** @SWG\Get(
     *     path="/api/favorite",
     *     tags={"Favorite"},
     *     summary="Favori Şarkı listesini döner",
     *     description="Favori Şarkı listesini döner",
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="işlem başarılı",
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
     * @return SongResource
     */
    public function index()
    {
        $songs = $this->userRepository->favoriteSongs();
        if (!$songs->isEmpty()) {
            return new SongResource($songs, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new SongResource(null, BaseResource::HTTP_NO_CONTENT, "Favoriler Boş");
    }

    /** @SWG\Post(
     *     path="/api/favorite",
     *     tags={"Favorite"},
     *     summary="Favori Şarkı ekle",
     *     description="Favori Şarkı ekle",
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Parameter(
     *          name="songId",
     *          description="songId",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="işlem başarılı",
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
     * @param FavoriteRequest $request
     * @return SongResource
     */
    public function store(FavoriteRequest $request)
    {
        $this->userRepository->createSong($request->songId);
        return new SongResource(null, BaseResource::HTTP_NO_CONTENT, "Ekleme Başarılı");
    }

    /** @SWG\Delete(
     *     path="/api/favorite",
     *     tags={"Favorite"},
     *     summary="Favori Şarkı sil",
     *     description="Favori Şarkı sil",
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Parameter(name="songId", description="songId", in="path", type="integer", format="int32"),
     *     @SWG\Response(
     *          response=204,
     *          description="işlem başarılı",
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
     * @param $id
     * @return SongResource
     */
    public function destroy($id)
    {
        $this->userRepository->removeSong($id);
        return new SongResource(null, BaseResource::HTTP_NO_CONTENT, "Kaldırma Başarılı");
    }
}
