<?php

namespace SebaCarrasco93\MyCart\Tests\Unit;

use SebaCarrasco93\MyCart\Tests\TestCase;
use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class MyCartTest extends TestCase
{
    /** @test */
    function it_can_add_an_item() {
        MyCart::add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_items_key() {
        config(['mycart.items_name' => 'products']);
        
        MyCart::add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['products'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_session_key() {        
        MyCart::add($this->itemOne, 'waffles');
        
        $this->assertEquals($this->itemOne, session('mycart')['waffles'][0]);
    }

    /** @test */
    function it_can_get_all_the_items() {        
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        $this->assertEquals($this->itemOne, MyCart::get()[0]);
        $this->assertEquals($this->itemTwo, MyCart::get()[1]);
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        $this->assertEquals($this->itemTwo, MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_is_inexistent() {
        MyCart::add($this->itemOne);

        $this->assertNull(MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_doesnt_have_any_items() {
        $this->assertNull(MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_flush_all_the_items() {
        MyCart::add($this->itemOne);

        MyCart::flush();

        $this->assertNull(MyCart::get());
    }

    /** @test */
    function it_can_flush_all_the_items_with_a_custom_key() {
        MyCart::add($this->itemOne, 'customCart');

        MyCart::flush('customCart');

        $this->assertNull(MyCart::get('customCart'));
    }

    /** @test */
    function it_can_knows_its_count_of_items() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        $this->assertEquals(2, MyCart::count());
    }

    /** @test */
    function it_can_knows_its_count_of_items_with_a_custom_key() {
        MyCart::add($this->itemOne, 'customCart');
        MyCart::add($this->itemTwo, 'customCart');

        $this->assertEquals(2, MyCart::count('customCart'));
    }

    /** @test */
    function it_can_get_count_of_zero_items_if_doesnt_have_items() {
        $this->assertEquals(0, MyCart::count());
    }

    /** @test */
    function it_knows_its_total() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        $this->assertEquals(16.4, MyCart::total());
    }

    /** @test */
    function it_knows_its_total_with_a_custom_key() {
        MyCart::add($this->itemOne, 'AnotherCart');
        MyCart::add($this->itemTwo, 'AnotherCart');

        $this->assertEquals(16.4, MyCart::total('AnotherCart'));
    }

    /** @test */
    function it_knows_its_total_with_a_custom_key_and_total_name() {
        $this->itemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
            'partial_total' => '6.1'
        ];

        $this->itemTwo = [
            'uuid' => '222BBB',
            'name' => "Mixed Waffle by SoloWaffles",
            'partial_total' => '4.6'
        ];

        MyCart::add($this->itemOne, 'AnotherCart', 'partial_total');
        MyCart::add($this->itemTwo, 'AnotherCart', 'partial_total');

        $this->assertEquals(10.7, MyCart::total('AnotherCart', 'partial_total'));
    }

    /** @test */
    function it_can_get_total_of_zero_if_doesnt_have_items() {
        $this->assertEquals(0, MyCart::total());
    }
}
