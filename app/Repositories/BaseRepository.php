<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository as BaseRepositoryContract;

abstract class BaseRepository implements BaseRepositoryContract
{
    public function getData(array $data): array
    {
        //
    }
}
