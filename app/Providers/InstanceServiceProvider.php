<?php

namespace App\Providers;

use App\Http\Services\AddressService;
use App\Http\Services\Auth\AuthenticationInterface;
use App\Http\Services\Auth\Authentication;
use App\Http\Services\CurrencyService;
use App\Http\Services\ProductService;
use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\CurrencyRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\ServiceProvider;
use Exception;

class InstanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AuthenticationInterface::class,
            Authentication::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws Exception
     */
    public function boot()
    {
        $this->app->instance(CurrencyService::class,
            new CurrencyService(
                new CurrencyRepository($this->app)
            )
        );

        $this->app->instance(AddressService::class,
            new AddressService(
                new AddressRepository($this->app)
            )
        );

        $this->app->instance(ProductService::class,
            new ProductService(
                new ProductRepository($this->app)
            )
        );
    }
}
