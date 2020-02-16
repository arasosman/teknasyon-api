<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface UserRepositoryContract extends BaseRepositoryContract
{
    public function findByToken(Request $request);
}
