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
    function it_can_find_an_item_by_their_uuid() {
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

        $this->assertEquals($itemTwo, MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_is_inexistent() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne);

        $this->assertNull(MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_doesnt_have_any_items() {
        $this->assertNull(MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_flush_all_the_items() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne);

        MyCart::flush();

        $this->assertNull(MyCart::get());
    }

    /** @test */
    function it_can_flush_all_the_items_with_a_custom_key() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne, 'customCart');

        MyCart::flush('customCart');

        $this->assertNull(MyCart::get('customCart'));
    }

    /** @test */
    function it_can_knows_its_count_of_items() {
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

        $this->assertEquals(2, MyCart::count());
    }

    /** @test */
    function it_can_knows_its_count_of_items_with_a_custom_key() {
        $itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
        ];

        $itemTwo = [
            'uuid' => '222BBB',
            'name' => "Mixed Waffle by SoloWaffles",
        ];
        
        MyCart::add($itemOne, 'customCart');
        MyCart::add($itemTwo, 'customCart');

        $this->assertEquals(2, MyCart::count('customCart'));
    }

    /** @test */
    function it_can_get_count_of_zero_items_if_doesnt_have_items() {
        $this->assertEquals(0, MyCart::count());
    }
}
