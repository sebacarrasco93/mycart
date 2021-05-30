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

    public function setAllKeys(string $customItemsName = null, string $customPriceName = null, string $customSessionName = null)
    {
        $this->setKeyItemsName($customItemsName);
        $this->setKeyPriceName($customPriceName);
        $this->setKeySessionName($customSessionName);
    }

    public function getAllKeys()
    {
        $this->getKeySessionName();
        $this->getKeyItemsName();
        $this->getKeyPriceName();
    }

    public function add(array $item, string $customItemsName = null, string $customPriceName = null, string $customSessionName = null)
    {
        $this->setAllKeys($customItemsName);
        $this->getAllKeys();

        $this->attributes[$this->keyItemsName][] = $item;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function get(string $customItemsName = null)
    {
        $this->setAllKeys($customItemsName);
        $this->getAllKeys();

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

    public function flush(string $customItemsName = null)
    {
        $this->setAllKeys($customItemsName);

        $this->attributes[$this->keyItemsName] = null;

        session([$this->getSessionName() => $this->attributes]);
    }

    public function setCount(string $customItemsName = null)
    {
        $this->setAllKeys($customItemsName);

        if ($get = $this->get($customItemsName)) {
            $this->itemsCount = count($get);
        }
    }

    public function setTotal(string $customItemsName = null, string $customPriceName = null)
    {
        $this->setAllKeys($customItemsName, $customPriceName);

        if ($get = $this->get($this->itemsKey)) {
            $this->itemsTotal = $get->pluck($this->keyPriceName)->sum();
        }

        return $this->itemsTotal;
    }
}
