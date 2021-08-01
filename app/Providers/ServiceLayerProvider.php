<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\{
    SwitchDataService as SwitchDataServiceContract,
};
use App\Services\{
    SwitchDataService
};

class ServiceLayerProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SwitchDataServiceContract::class, SwitchDataService::class);
    }
}
