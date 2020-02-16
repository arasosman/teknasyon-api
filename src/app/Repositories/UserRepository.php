<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Song;
use App\User;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    public function findByToken(Request $request): User
    {
        return $this->findByAttributes(['api_token' => $request->headers->get('token')]);
    }

    public function favoriteSongs()
    {
        $user = $this->findByToken(\request());
        return $user->favorites;
    }

    /**
     * @param $songId
     */
    public function createSong($songId)
    {
        $user = $this->findByToken(\request());
        return $user->favorites()->attach($songId);
    }

    public function removeSong($songId)
    {
        $user = $this->findByToken(\request());
        return $user->favorites()->detach($songId);
    }
}
