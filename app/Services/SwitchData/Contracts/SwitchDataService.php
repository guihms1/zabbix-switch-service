<?php

namespace App\Services\SwitchData\Contracts;

interface SwitchDataService
{
    public function getData(array $data): array;
}
