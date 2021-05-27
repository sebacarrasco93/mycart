<?php

namespace SebaCarrasco93\MyCart\Tests;

use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class MyCartTest extends TestCase
{
    /** @test */
    function it_can_add_an_item() {
        $item = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        $cart = MyCart::add($item);

        $this->assertEquals($item, session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_key() {
        $item = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        $cart = MyCart::add($item, 'waffles');
        
        $this->assertEquals($item, session('mycart')['waffles'][0]);
    }
}
