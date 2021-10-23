<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\PostRepositoryInterface',
            'App\Repositories\PostRepository'
        );

        $this->app->bind(
            'App\Repositories\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
