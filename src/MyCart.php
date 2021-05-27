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

    public function get($key = 'items')
    {
        if ($sesion = session($this->sessionName)) {
            if (isset($sesion[$key])) {
                return collect($sesion[$key]);
            }
        }

        // return null;
    }

    public function getByUuid(string $uuid)
    {
        if ($get = $this->get()) {
            $found = $get->where('uuid', $uuid);
            
            return $found ? $found->first() : null;
        }
    }
}
