<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;

class MyCart extends Model
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

    public function add(array $item, string $key = null)
    {
        $key = $key ?? $this->getItemsName();

        $this->attributes[$key][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get(string $key = null)
    {
        $key = $key ?? $this->getItemsName();

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

    public function flush(string $key = null)
    {
        $key = $key ?? $this->getItemsName();

        $this->attributes[$key] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function count(string $key = null)
    {
        $key = $key ?? $this->getItemsName();

        if ($get = $this->get($key)) {
            return $get->count();
        }

        return 0;
    }

    public function total(string $key = null, $priceName = null)
    {
        $key = $key ?? $this->getItemsName();
        $priceName = $priceName ?? $this->getPriceName();

        if ($get = $this->get($key)) {
            return $get->pluck($priceName)->sum();
        }

        return 0;
    }
}
