<?php

namespace App\Providers;

use App\Services\Interfaces\PropertyInterface;
use App\Services\Interfaces\UserInterface;
use App\Services\PropertyService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(PropertyInterface::class, PropertyService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
