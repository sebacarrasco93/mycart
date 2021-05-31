<?php

namespace SebaCarrasco93\MyCart\Tests\Unit;

use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\Tests\TestCase;

class MyCartFacadeTest extends TestCase
{
    /** @test */
    function it_can_set_a_custom_session_name() {
        MyCart::setKeySessionName('newSessionName');

        $this->assertEquals(
            'newSessionName',
            MyCart::getKeySessionName()
        );
    }

    /** @test */
    function it_can_set_a_custom_key_name() {
        MyCart::setKeyItemsName('newItemsName');

        $this->assertEquals(
            'newItemsName',
            MyCart::getKeyItemsName()
        );
    }

    /** @test */
    function it_can_set_a_custom_price_name() {
        MyCart::setKeyPriceName('newPriceName');

        $this->assertEquals(
            'newPriceName',
            MyCart::getKeyPriceName()
        );
    }

    /** @test */
    function it_can_add_an_item() {
        MyCart::add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_with_custom_price_name() {
        MyCart::setKeyPriceName('superPrice');

        $newItemOne = [
            'uuid' => '111AAA',
            'name' => "Lemon Waffle by SoloWaffles",
            'superPrice' => '6.1'
        ];

        MyCart::add($newItemOne);

        $this->assertArrayHasKey('superPrice', session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_with_custom_items_name() {
        MyCart::setKeyItemsName('customKey');
        MyCart::add($this->itemOne);
        
        $this->assertEquals($this->itemOne, session('mycart')['customKey'][0]);

        MyCart::setKeyItemsName('anotherCustomKey');
        MyCart::add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['anotherCustomKey'][0]);
    }

    /** @test */
    function it_can_get_all_the_items() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        $this->assertEquals($this->itemOne, MyCart::get()[0]);
        $this->assertEquals($this->itemTwo, MyCart::get()[1]);
    }

    /** @test */
    function it_can_get_its_count_of_items() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        MyCart::setCount();

        $this->assertEquals(2, MyCart::getCount());
    }

    /** @test */
    function it_can_get_its_count_of_items_equals_to_zero_if_doesnt_have_it() {
        MyCart::setCount();

        $this->assertEquals(0, MyCart::getCount());
    }

    /** @test */
    function it_can_get_its_total() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        MyCart::setTotal();

        $this->assertEquals(16.4, MyCart::getTotal());
    }

    /** @test */
    function it_can_get_its_count_of_total_equals_to_zero_if_doesnt_have_it() {
        MyCart::setTotal();

        $this->assertEquals(0, MyCart::getTotal());
    }

    /** @test */
    function it_can_get_all_the_items_with_custom_items_key() {
        MyCart::setKeyItemsName('newItemsName');

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
    function it_cant_find_an_item_by_their_uuid_if_it_is_inexistent() {
        MyCart::add($this->itemOne);

        $this->assertNull(MyCart::findByUuid('222BBB'));
    }

    /** @test */
    function it_can_flush_all_the_items() {
        MyCart::add($this->itemOne);

        MyCart::flush();

        $this->assertNull(MyCart::get());
    }

    /** @test */
    function it_knows_its_total_with_a_custom_key_and_total_name() {
        MyCart::setKeyPriceName('partial_total');

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

        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        $this->assertEquals(10.7, MyCart::getTotal());
    }
}
