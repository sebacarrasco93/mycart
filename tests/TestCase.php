<?php

namespace SebaCarrasco93\MyCart\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCart as MyCartClass;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class TestCase extends BaseTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        
        $this->itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
            'price' => '8.5',
        ];

        $this->itemTwo = [
            'uuid' => '222BBB',
            'name' => "Mixed Waffle by SoloWaffles",
            'price' => '7.9',
        ];

        $this->myCart = new MyCartClass();
    }

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
