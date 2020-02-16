<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Http\Resources\BaseResource;
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

    /**
     * Display a listing of the resource.
     *
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

    /**
     * Store a newly created resource in storage.
     *
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

    /**
     * Display the specified resource.
     *
     * @param int $id
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


    /**
     * Update the specified resource in storage.
     *
     * @param SongRequest $request
     * @param int $id
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
