<?php

namespace App\Providers;

use App\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Repositories\Contracts\SongRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\SongRepository;
use App\Repositories\UserRepository;
use App\Song;
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

        $this->app->bind(SongRepositoryContract::class, function () {
            return new SongRepository(new Song());
        });

        $this->app->bind(CategoryRepositoryContract::class, function () {
            return new CategoryRepository(new Category());
        });
    }
}
