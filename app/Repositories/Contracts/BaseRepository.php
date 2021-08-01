<?php

namespace App\Repositories\Contracts;

interface BaseRepository
{
    public function getData(array $data): array;
}
