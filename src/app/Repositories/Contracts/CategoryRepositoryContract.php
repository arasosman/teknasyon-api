<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryContract extends BaseRepositoryContract
{

    public function song($categoryId);
}
