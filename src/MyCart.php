<?php

namespace SebaCarrasco93\MyCart;

use Jenssegers\Model\Model;
// use SebaCarrasco93\MyCart\Traits\Attributes;
// use SebaCarrasco93\MyCart\Traits\KeyNames;
use SebaCarrasco93\MyCart\Traits\OriginalKeyNames;

class MyCart extends Model
{
    // use Attributes, KeyNames;
    use OriginalKeyNames;

    public $keySessionName;
    public $keyItemsName;
    public $keyPriceName;
    
    public $itemsCount = 0;
    public $itemsTotal = 0;
    
    public function getKeySessionName()
    {
        return $this->keySessionName ?? $this->getSessionName();
    }

    public function setKeySessionName(string $customSessionName = null)
    {
        $this->keySessionName = $customSessionName ?? $this->getKeySessionName();
    }

    public function getKeyItemsName()
    {
        return $this->keyItemsName ?? $this->getItemsName();
    }

    public function setKeyItemsName(string $customItemsName = null)
    {
        $this->keyItemsName = $customItemsName ?? $this->getKeyItemsName();
    }

    public function getKeyPriceName()
    {
        return $this->keyPriceName ?? $this->getPriceName();
    }

    public function setKeyPriceName(string $customPriceName = null)
    {
        $this->keyPriceName = $customPriceName ?? $this->getKeyPriceName();
    }

    public function setAllKeys()
    {
        $this->setKeyItemsName();
        $this->setKeyPriceName();
        $this->setKeySessionName();
    }

    public function getAllKeys()
    {
        $this->getKeySessionName();
        $this->getKeyItemsName();
        $this->getKeyPriceName();

        // return $this;
    }

    public function init()
    {
        $this->setAllKeys();
        $this->getAllKeys();
    }

    public function add(array $item)
    {
        $this->init();

        $this->attributes[$this->keyItemsName][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get(string $customItemsName = null)
    {
        $this->init();

        if ($sesion = session($this->getSessionName())) {
            if (isset($sesion[$this->keyItemsName])) {
                return collect($sesion[$this->keyItemsName]);
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

    public function flush()
    {
        $this->attributes[$this->keyItemsName] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function setCount()
    {
        // $this->setAllKeys();

        if ($get = $this->get()) {
            $this->itemsCount = count($get);
        }
    }

    public function getCount()
    {
        $this->setCount();

        return $this->itemsCount;
    }

    public function setTotal()
    {
        if ($get = $this->get($this->itemsKey)) {
            $this->itemsTotal = $get->pluck($this->keyPriceName)->sum();
        }

        return $this->itemsTotal;
    }

    public function getTotal()
    {
        $this->setTotal();

        return $this->itemsTotal;
    }
}
