<?php

namespace SebaCarrasco93\MyCart\Traits;

trait KeyNames
{
    public function getSessionName()
    {
        return config('mycart.session_name');
    }

    public function getItemsName()
    {
        return config('mycart.items_name');
    }

    public function getPriceName()
    {
        return config('mycart.price_name');
    }
}
