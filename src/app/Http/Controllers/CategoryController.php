<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SongResource;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryContract;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /** @var CategoryRepository */
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepositoryContract::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return CategoryResource
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();
        if ($categories) {
            return new CategoryResource($categories, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, BaseResource::$statusTexts[BaseResource::HTTP_BAD_REQUEST]);
    }

    /**
     * Store a newly created resource in storage.
     *
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CategoryResource
     */
    public function show($id)
    {
        $song = $this->categoryRepository->find($id);
        if ($song) {
            return new CategoryResource($song, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new CategoryResource(null, BaseResource::HTTP_BAD_REQUEST, "Kategori bulunamadı. Bad request");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param int $id
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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

    /**
     * @param $id
     * @return SongResource
     */
    public function song($id)
    {
        $songs = $this->categoryRepository->song($id);
        if (!$songs->isEmpty()) {
            return new SongResource($songs, BaseResource::HTTP_OK, BaseResource::$statusTexts[BaseResource::HTTP_OK]);
        }
        return new SongResource(null, BaseResource::HTTP_BAD_REQUEST, "Şarkı bulunamadı. Bad Request!");
    }
}
