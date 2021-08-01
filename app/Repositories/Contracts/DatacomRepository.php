<?php

namespace App\Repositories\Contracts;

interface DatacomRepository extends SwitchRepository
{
    public function getData(array $data): array;
}
