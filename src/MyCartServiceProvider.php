<?php

namespace SebaCarrasco93\MyCart;

use Illuminate\Support\ServiceProvider;

class MyCartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/mycart.php' => base_path('config/mycart.php')
        ], 'mycart-config');
    }

    public function register()
    {
        $this->app->bind('mycart', function() {
            return new MyCart();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/mycart.php', 'mycart');
    }
}
