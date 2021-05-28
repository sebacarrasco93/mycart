<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;
use SebaCarrasco93\MyCart\Traits\Attributes;
use SebaCarrasco93\MyCart\Traits\KeyNames;

class MyCart extends Model
{
    use Attributes, KeyNames;

    public function add(array $item, string $customItemsKey = null)
    {
        $this->setItemsKey($customItemsKey);

        $this->attributes[$this->itemsKey][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get(string $customItemsKey = null)
    {
        $this->setItemsKey($customItemsKey);

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

    public function flush(string $customItemsKey = null)
    {
        $this->setItemsKey($customItemsKey);

        $this->attributes[$this->itemsKey] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function count(string $customItemsKey = null)
    {
        $this->setItemsKey($customItemsKey);

        $this->countItems($customItemsKey);

        return $this->countItems;
    }

    public function total(string $customItemsKey = null, string $customPriceName = null)
    {
        $this->setItemsKey($customItemsKey);
        $customPriceName = $customPriceName ?? $this->getPriceName();
        
        $this->calculateTotal($customItemsKey, $customPriceName);

        return $this->total;
    }
}
