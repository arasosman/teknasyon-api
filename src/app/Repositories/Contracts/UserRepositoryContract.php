<?php

namespace App\Repositories\Contracts;

use App\Song;
use App\User;
use Illuminate\Http\Request;

interface UserRepositoryContract extends BaseRepositoryContract
{
    public function findByToken(Request $request);

    public function favoriteSongs();

    public function createSong($songId);

    public function removeSong($songId);
}
