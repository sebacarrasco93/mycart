<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;

class MyCart extends Model
{
    public function getSessionName()
    {
        return config('mycart.session_name');
    }

    public function add(array $item, $key = 'items')
    {
        $this->attributes[$key][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get($key = 'items')
    {
        if ($sesion = session($this->getSessionName())) {
            if (isset($sesion[$key])) {
                return collect($sesion[$key]);
            }
        }

        // return null;
    }

    public function findByUuid(string $uuid)
    {
        if ($get = $this->get()) {
            $found = $get->where('uuid', $uuid);

            return $found ? $found->first() : null;
        }
    }

    public function flush(string $key = 'items')
    {
        $this->attributes[$key] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function count(string $key = 'items')
    {
        if ($get = $this->get($key)) {
            return $get->count();
        }

        return 0;
    }

    public function total(string $key = 'items', $totalName = 'total')
    {
        if ($get = $this->get($key)) {
            return $get->pluck($totalName)->sum();
        }

        return 0;
    }
}
