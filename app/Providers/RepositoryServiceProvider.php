<?php

namespace App\Providers;

use App\Repositories\Contracts\AddressRepositoryContract;
use App\Repositories\Contracts\CurrencyRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\CurrencyRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\UserRepository;
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
            UserRepositoryContract::class,
            UserRepository::class
        );

        $this->app->bind(
            CurrencyRepositoryContract::class,
            CurrencyRepository::class
        );

        $this->app->bind(
            AddressRepositoryContract::class,
            AddressRepository::class
        );

        $this->app->bind(
            ProductRepositoryContract::class,
            ProductRepository::class
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
