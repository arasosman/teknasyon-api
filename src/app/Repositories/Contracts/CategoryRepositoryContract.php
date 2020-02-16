<?php

namespace App\Repositories\Contracts;

use App\Song;

interface CategoryRepositoryContract extends BaseRepositoryContract
{

    public function song($categoryId);
}
