<?php

namespace App\Providers;

use App\repositories\Cart\CartModelRepository;
use App\repositories\Cart\CartRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepository::class, function () {
            return new CartModelRepository;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
