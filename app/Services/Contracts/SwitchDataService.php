<?php

namespace App\Services\Contracts;

interface SwitchDataService
{
    public function getData(string $switchBrand, array $data): array;
}
