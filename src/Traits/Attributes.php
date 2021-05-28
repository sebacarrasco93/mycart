<?php

namespace SebaCarrasco93\MyCart\Traits;

trait Attributes
{
    public $itemsKey; // 'items'
    public $priceKey; // 'price'

    public $hasItems = false;
    public $countItems = 0;
    public $total = 0;

    public function getAttribute($attributeName)
    {
        return $this->$attributeName;
    }

    public function setPriceKey(string $customPriceKey = null)
    {
        // should return $customPriceKey ?? "price"
        $this->priceKey = $customPriceKey ?? $this->getPriceName();
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

    public function calculateTotal(string $customItemsKey = null, string $customPriceKey = null)
    {
        $this->setItemsKey($customItemsKey);

        $customPriceKey = $customPriceKey ?? $this->getPriceName();

        if ($get = $this->get($this->itemsKey)) {
            $this->total = $get->pluck($customPriceKey)->sum();
        }
    }
}
