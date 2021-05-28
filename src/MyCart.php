<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;
use SebaCarrasco93\MyCart\Traits\Attributes;
use SebaCarrasco93\MyCart\Traits\KeyNames;

class MyCart extends Model
{
    use Attributes, KeyNames;

    public function add(array $item, string $key = null)
    {
        $key = $this->itemsKey($key);


        $this->attributes[$key][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get(string $key = null)
    {
        $key = $this->itemsKey($key);

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
        $key = $this->itemsKey($key);

        $this->attributes[$key] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function count(string $key = null)
    {
        $key = $this->itemsKey($key);

        if ($get = $this->get($key)) {
            return $get->count();
        }

        return 0;
    }

    public function total(string $key = null, $priceName = null)
    {
        $key = $this->itemsKey($key);

        $priceName = $priceName ?? $this->getPriceName();

        if ($get = $this->get($key)) {
            return $get->pluck($priceName)->sum();
        }

        return 0;
    }
}
