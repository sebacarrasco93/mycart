<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;
use SebaCarrasco93\MyCart\Traits\Attributes;
use SebaCarrasco93\MyCart\Traits\KeyNames;

class MyCart extends Model
{
    use Attributes, KeyNames;

    public function add(array $item, string $itemsKey = null)
    {
        $this->setItemsKey($itemsKey);

        $this->attributes[$this->itemsKey][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get(string $itemsKey = null)
    {
        $this->setItemsKey($itemsKey);

        if ($sesion = session($this->getSessionName())) {
            if (isset($sesion[$this->itemsKey])) {
                return collect($sesion[$this->itemsKey]);
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

    public function flush(string $itemsKey = null)
    {
        $this->setItemsKey($itemsKey);

        $this->attributes[$this->itemsKey] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function count(string $itemsKey = null)
    {
        $this->setItemsKey($itemsKey);

        if ($get = $this->get($this->itemsKey)) {
            return $get->count();
        }

        return 0;
    }

    public function total(string $itemsKey = null, $priceName = null)
    {
        $this->setItemsKey($itemsKey);

        $priceName = $priceName ?? $this->getPriceName();

        if ($get = $this->get($this->itemsKey)) {
            return $get->pluck($priceName)->sum();
        }

        return 0;
    }
}
