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
        
        MyCart::add($item);

        $this->assertEquals($item, session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_key() {
        $item = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        MyCart::add($item, 'waffles');
        
        $this->assertEquals($item, session('mycart')['waffles'][0]);
    }

    /** @test */
    function it_can_get_all_the_items() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];

        $itemTwo = [
            'uuid' => '222BBB',
            'name' => "Mixed Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne);
        MyCart::add($itemTwo);

        $this->assertEquals($itemOne, MyCart::get()[0]);
        $this->assertEquals($itemTwo, MyCart::get()[1]);
    }

    /** @test */
    function it_can_get_an_item_by_their_uuid() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];

        $itemTwo = [
            'uuid' => '222BBB',
            'name' => "Mixed Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne);
        MyCart::add($itemTwo);

        $this->assertEquals($itemTwo, MyCart::getByUuid('222BBB'));
    }

    /** @test */
    function it_can_get_an_item_by_their_uuid_if_it_is_inexistent() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne);

        $this->assertNull(MyCart::getByUuid('222BBB'));
    }

    /** @test */
    function it_can_get_an_item_by_their_uuid_if_it_doesnt_have_any_items() {
        $this->assertNull(MyCart::getByUuid('222BBB'));
    }
}
