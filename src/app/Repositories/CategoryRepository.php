<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use App\Repositories\Contracts\CategoryRepositoryContract;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract
{

    public function song($categoryId)
    {
        $category = $this->find($categoryId);
        return $category->songs;
    }
}
