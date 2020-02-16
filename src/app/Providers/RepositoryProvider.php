<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryContract::class, function () {
            return new UserRepository(new User());
        });
    }
}
