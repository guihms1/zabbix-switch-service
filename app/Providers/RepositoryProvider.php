<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    BaseRepository as BaseRepositoryContract,
    SwitchRepository as SwitchRepositoryContract,
    DatacomRepository as DatacomRepositoryContract,
};
use App\Repositories\{
    BaseRepository,
    SwitchRepository,
    DatacomRepository
};

class RepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BaseRepositoryContract::class, BaseRepository::class);
        $this->app->bind(SwitchRepositoryContract::class, SwitchRepository::class);
        $this->app->bind(DatacomRepositoryContract::class, DatacomRepository::class);
    }
}
