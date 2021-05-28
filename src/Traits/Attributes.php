<?php

namespace SebaCarrasco93\MyCart\Traits;

trait Attributes
{
    public $itemsKey; // 'items'

    public $hasItems = false;
    public $countItems = 0;

    public function getAttribute($attributeName)
    {
        return $this->$attributeName;
    }

    public function setItemsKey(string $customItemsKey = null)
    {
        // should return $customItemsKey ?? "item"
        $this->itemsKey = $customItemsKey ?? $this->getItemsName();
    }

    public function hasItems(string $customItemsKey = null)
    {
        $this->setItemsKey($customItemsKey);

        $this->hasItems = (bool) $this->get($this->itemsKey);
    }

    public function countItems(string $customItemsKey = null)
    {
        $this->setItemsKey($customItemsKey);

        $get = $this->get($this->itemsKey);

        if ($get) {
            $this->countItems = count($get);
        }
    }
}
