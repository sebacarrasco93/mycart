<?php

namespace SebaCarrasco93\MyCart\Tests\Unit\Traits;

use SebaCarrasco93\MyCart\Tests\TestCase;
use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class KeyNamesTest extends TestCase
{
    /** @test */
    function it_can_know_its_default_session_name() {
        $this->assertEquals('mycart', MyCart::getSessionName());
    }

    /** @test */
    function it_can_change_its_session_name() {
        config(['mycart.session_name' => 'cart-2']);

        $this->assertEquals('cart-2', MyCart::getSessionName());
    }

    /** @test */
    function it_can_know_its_default_items_name() {
        $this->assertEquals('items', MyCart::getItemsName());
    }

    /** @test */
    function it_can_change_its_items_name() {
        config(['mycart.items_name' => 'products']);

        $this->assertEquals('products', MyCart::getItemsName());
    }

    /** @test */
    function it_can_know_its_default_price_name() {
        $this->assertEquals('price', MyCart::getPriceName());
    }

    /** @test */
    function it_can_change_its_price_name() {
        config(['mycart.price_name' => 'subtotal']);

        $this->assertEquals('subtotal', MyCart::getPriceName());
    }
}
