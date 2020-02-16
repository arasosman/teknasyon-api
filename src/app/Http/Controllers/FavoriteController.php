<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
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

    /**
     * Display a listing of the resource.
     *
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return SongResource
     */
    public function store(FavoriteRequest $request)
    {
        $this->userRepository->createSong($request->songId);
        return new SongResource(null, BaseResource::HTTP_NO_CONTENT, "Ekleme Başarılı");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return SongResource
     */
    public function destroy($id)
    {
        $this->userRepository->removeSong($id);
        return new SongResource(null, BaseResource::HTTP_NO_CONTENT, "Kaldırma Başarılı");
    }
}
