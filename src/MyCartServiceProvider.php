<?php

namespace SebaCarrasco93\MyCart;

use Illuminate\Support\ServiceProvider;

class MyCartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // código...
    }

    public function register()
    {
        $this->app->bind('mycart', function() {
            return new MyCart();
        });
    }
}
