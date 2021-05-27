<?php

namespace SebaCarrasco93\MyCart\Facades;

use Illuminate\Support\Facades\Facade;

class MyCart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mycart';
    }
}
