<?php

namespace SebaCarrasco93\MyCart\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MyCartServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'MyCart' => '\SebaCarrasco93\MyCart\Facades\MyCart::class'
        ];
    }
}
