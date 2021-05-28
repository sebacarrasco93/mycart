<?php

namespace SebaCarrasco93\MyCart\Traits;

trait Attributes
{
    public $hasItems = false;
    public $countItems = 0;

    public function hasItems(string $key = 'items')
    {
        $this->hasItems = (bool) $this->get($key);
    }

    public function countItems(string $key = 'items')
    {
        $get = $this->get($key);

        if ($get) {
            $this->countItems = count($get);
        }
    }
}
