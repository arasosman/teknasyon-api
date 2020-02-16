<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SongRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SongResource;
use App\Repositories\Contracts\SongRepositoryContract;
use App\Repositories\SongRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SongController extends Controller
{
    /** @var SongRepository */
    protected $songRepository;

    public function __construct()
    {
        $this->songRepository = app(SongRepositoryContract::class);
    }

    /** @SWG\Get(
     *     path="/api/song",
     *     tags={"Song"},
     *     summary="Şarkı listesini döner",
     *     description="Şarkı listesini döner",
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
        $songs = $this->songRepository->all();
        if ($songs) {
            return new SongResource($songs, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, BaseResource::$statusTexts[BaseResource::HTTP_BAD_REQUEST]);
    }

    /** @SWG\Post(
     *     path="/api/song",
     *     tags={"Song"},
     *     summary="Şarkı ekle",
     *     description="Şarkı ekle",
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Parameter(
     *          name="title",
     *          description="title",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="image",
     *          description="image",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Response(
     *          response=201,
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
     * @param SongRequest $request
     * @return SongResource
     */
    public function store(SongRequest $request)
    {
        $song = $this->songRepository->create($request->only('title', 'image'));
        if ($song) {
            return new SongResource($song, BaseResource::HTTP_CREATED, BaseResource::$statusTexts[BaseResource::HTTP_CREATED]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, "Şarkı Eklenemedi Bad request");
    }

    /** @SWG\Get(
     *     path="/api/song/{songId}",
     *     tags={"Song"},
     *     summary="Şarkı detayı",
     *     description="Şarkı detayo",
     *     @SWG\Parameter(name="songId", description="songId", in="path", type="integer", format="int32"),
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *
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
     * @param $id
     * @return SongResource
     */
    public function show($id)
    {
        $song = $this->songRepository->find($id);
        if ($song) {
            return new SongResource($song, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, "Şarkı bulunamadı. Bad request");
    }


    /** @SWG\Put(
     *     path="/api/song/{songId}",
     *     tags={"Song"},
     *     summary="Şarkı güncelleme",
     *     description="Şarkı güncelleme",
     *     @SWG\Parameter(name="songId", description="songId", in="path", type="integer", format="int32"),
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),@SWG\Parameter(
     *          name="title",
     *          description="title",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="image",
     *          description="image",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *
     *     @SWG\Response(
     *          response=201,
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
     * @param SongRequest $request
     * @param $id
     * @return SongResource
     */
    public function update(SongRequest $request, $id)
    {
        $song = $this->songRepository->find($id);
        $song = $this->songRepository->update($song, $request->only('title', 'image'));
        if ($song) {
            return new SongResource($song, BaseResource::HTTP_ACCEPTED, BaseResource::$statusTexts[BaseResource::HTTP_ACCEPTED]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, "Şarkı bulunamadı. Bad request");
    }

    /** @SWG\Delete(
     *     path="/api/song/{songId}",
     *     tags={"Song"},
     *     summary="Şarkı Silme",
     *     description="Şarkı Silme",
     *     @SWG\Parameter(name="songId", description="songId", in="path", type="integer", format="int32"),
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
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
     * @param $id
     * @return SongResource
     */
    public function destroy($id)
    {
        $song = $this->songRepository->find($id);
        $remove = $this->songRepository->destroy($song);
        if ($remove) {
            return new SongResource(null, BaseResource::HTTP_NO_CONTENT, BaseResource::$statusTexts[BaseResource::HTTP_NO_CONTENT]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, "Şarkı bulunamadı. Bad request");
    }
}
