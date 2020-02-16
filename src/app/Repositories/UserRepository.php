<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    public function findByToken(Request $request)
    {
        return $this->findByAttributes(['api_token' => $request->headers->get('token')]);
    }
}
