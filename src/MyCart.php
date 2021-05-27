<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;

class MyCart extends Model
{
    protected $sessionName = 'mycart';

    public function add(array $item, $key = 'items')
    {
        $this->attributes[$key][] = $item;

        session([$this->sessionName => $this->attributes]);
    }

    public function get()
    {
        // return $this->items;
    }
}
