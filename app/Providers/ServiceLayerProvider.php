<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\{
    Ssh\SshService as SshServiceContract,
    SwitchData\SwitchDataService as SwitchDataServiceContract,
};
use App\Services\{
    Ssh\SshService,
    SwitchData\SwitchDataService
};

class ServiceLayerProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SshServiceContract::class, SshService::class);
        $this->app->bind(SwitchDataServiceContract::class, SwitchDataService::class);
    }
}
