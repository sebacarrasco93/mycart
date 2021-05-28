<?php

namespace SebaCarrasco93\MyCart\Traits;

trait Attributes
{
    public $hasItems = false;
    public $countItems = 0;
    public $key;

    public function itemsKey(string $key = null)
    {
        // should return $key ?? "item"
        $this->key = $key ?? $this->getItemsName();

        return $this->key;
    }

    public function hasItems(string $key = null)
    {
        $key = $this->itemsKey($key);

        $this->hasItems = (bool) $this->get($key);
    }

    public function countItems(string $key = null)
    {
        $key = $this->itemsKey($key);

        $get = $this->get($key);

        if ($get) {
            $this->countItems = count($get);
        }
    }
}
