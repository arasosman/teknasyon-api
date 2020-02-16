<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SongResource;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /** @var CategoryRepository */
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepositoryContract::class);
    }

    /** @SWG\Get(
     *     path="/api/category",
     *     tags={"Category"},
     *     summary="Kategori listesini döner",
     *     description="Kategory listesini döner",
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
     * @return CategoryResource
     */
    public function index()
    {
        $categories = Cache::tags('categories')->remember('categories', 60, function () {
            return $this->categoryRepository->all();
        });

        if ($categories) {
            return new CategoryResource($categories, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, BaseResource::$statusTexts[BaseResource::HTTP_BAD_REQUEST]);
    }

    /** @SWG\Post(
     *     path="/api/category",
     *     tags={"Category"},
     *     summary="Kategori ekle",
     *     description="Kategory ekle",
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),
     *     @SWG\Parameter(
     *          name="name",
     *          description="name",
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
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request->only('name', 'image'));
        if ($category) {
            return new CategoryResource($category, BaseResource::HTTP_CREATED, BaseResource::$statusTexts[BaseResource::HTTP_CREATED]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, "Kategori Eklenemedi Bad request");
    }

    /** @SWG\Get(
     *     path="/api/category/{categoryId}",
     *     tags={"Category"},
     *     summary="Kategori detayı",
     *     description="Kategory detayo",
     *     @SWG\Parameter(name="categoryId", description="categoryId", in="path", type="integer", format="int32"),
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
     * @return CategoryResource
     */
    public function show($id)
    {
        $song = Cache::remember('category.' . $id, 60, function () use ($id) {
            return $this->categoryRepository->find($id);
        });
        if ($song) {
            return new CategoryResource($song, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, "Kategori bulunamadı. Bad request");
    }


    /** @SWG\Put(
     *     path="/api/category/{categoryId}",
     *     tags={"Category"},
     *     summary="Kategori güncelleme",
     *     description="Kategory güncelleme",
     *     @SWG\Parameter(name="categoryId", description="categoryId", in="path", type="integer", format="int32"),
     *     @SWG\Parameter(
     *          name="token",
     *          description="token",
     *          required=true,
     *          type="string",
     *          in="header"
     *     ),@SWG\Parameter(
     *          name="name",
     *          description="name",
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
     * @param CategoryRequest $request
     * @param $id
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->find($id);
        $category = $this->categoryRepository->update($category, $request->only('name', 'image'));
        if ($category) {
            return new CategoryResource($category, BaseResource::HTTP_ACCEPTED, BaseResource::$statusTexts[BaseResource::HTTP_ACCEPTED]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, "Kategori bulunamadı. Bad request");
    }

    /** @SWG\Delete(
     *     path="/api/category/{categoryId}",
     *     tags={"Category"},
     *     summary="Kategori Silme",
     *     description="Kategori Silme",
     *     @SWG\Parameter(name="categoryId", description="categoryId", in="path", type="integer", format="int32"),
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
     * @return CategoryResource
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);
        $remove = $this->categoryRepository->destroy($category);
        if ($remove) {
            return new CategoryResource(null, BaseResource::HTTP_NO_CONTENT, BaseResource::$statusTexts[BaseResource::HTTP_NO_CONTENT]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, "Kategori bulunamadı. Bad request");
    }

    /** @SWG\Get(
     *     path="/api/category/{categoryId}/song",
     *     tags={"Category"},
     *     summary="Kategori şarkılarını döner",
     *     description="Kategori şarkılarını döner",
     *     @SWG\Parameter(name="categoryId", description="categoryId", in="path", type="integer", format="int32"),
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
     * @param $id
     * @return SongResource
     */
    public function song($id)
    {
        $songs = Cache::remember('category.song.' . $id, 60, function () use ($id) {
            $this->categoryRepository->song($id);
        });
        if (!$songs->isEmpty()) {
            return new SongResource($songs, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, "Şarkı bulunamadı. Bad Request!");
    }
}
