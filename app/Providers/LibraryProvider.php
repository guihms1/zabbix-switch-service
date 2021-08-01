<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Contracts\{
  Ssh as SshContract
};
use App\Libraries\{
  Ssh
};

class LibraryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SshContract::class, Ssh::class);
    }
}
