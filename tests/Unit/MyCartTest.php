<?php

namespace SebaCarrasco93\MyCart\Tests\Unit;

use SebaCarrasco93\MyCart\Tests\TestCase;
use SebaCarrasco93\MyCart\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class MyCartTest extends TestCase
{
    /** @test */
    function it_knows_its_original_session_name() {
        $this->assertEquals('mycart', $this->myCart->getKeySessionName());
    }

    /** @test */
    function it_knows_its_custom_session_name() {
        $this->myCart->setKeySessionName('myowncart');

        $this->assertEquals('myowncart', $this->myCart->getKeySessionName());
    }

    /** @test */
    function it_knows_its_custom_items_name() {
        $this->myCart->setKeyItemsName('myownitems');

        $this->assertEquals('myownitems', $this->myCart->getKeyItemsName());
    }

    /** @test */
    function it_knows_its_original_items_name() {
        $this->assertEquals('items', $this->myCart->getKeyItemsName());
    }

    /** @test */
    function it_knows_its_custom_price_name() {
        $this->myCart->setKeyPriceName('myownprice');

        $this->assertEquals('myownprice', $this->myCart->getKeyPriceName());
    }

    /** @test */
    function it_knows_its_original_price_name() {
        $this->assertEquals('price', $this->myCart->getKeyPriceName());
    }

    /** @test */
    function it_knows_all_of_its_attributes() {
        $this->myCart->setAllKeys('myownitems', 'myownprice', 'myownsession');

        $this->assertEquals('myownitems', $this->myCart->keyItemsName);
        $this->assertEquals('myownprice', $this->myCart->keyPriceName);
        $this->assertEquals('myownsession', $this->myCart->keySessionName);
    }

    /** @test */
    function it_can_add_an_item() {
        $this->myCart->add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_items_key_from_session() {
        config(['mycart.items_name' => 'products']);

        $this->myCart->add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['products'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_items_key_from_parameter() {
        $this->myCart->add($this->itemOne, 'products');
        
        $this->assertEquals($this->itemOne, session('mycart')['products'][0]);
    }

    /** @test */
    function it_can_get_all_the_items() {
        $this->myCart->add($this->itemOne);
        $this->myCart->add($this->itemTwo);

        $this->assertEquals($this->itemOne, $this->myCart->get()[0]);
        $this->assertEquals($this->itemTwo, $this->myCart->get()[1]);
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid() {
        $this->myCart->add($this->itemOne);
        $this->myCart->add($this->itemTwo);

        $this->assertEquals($this->itemTwo, $this->myCart->findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_is_inexistent() {
        $this->myCart->add($this->itemOne);

        $this->assertNull($this->myCart->findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_doesnt_have_any_items() {
        $this->assertNull($this->myCart->findByUuid('222BBB'));
    }

    /** @test */
    function it_can_flush_all_the_items() {
        $this->myCart->add($this->itemOne);

        $this->myCart->flush();

        $this->assertNull($this->myCart->get());
    }

    /** @test */
    function it_can_flush_all_the_items_with_a_custom_key() {
        $this->myCart->add($this->itemOne, 'customCart');

        $this->myCart->flush('customCart');

        $this->assertNull($this->myCart->get('customCart'));
    }

    /** @test */
    function it_can_knows_its_count_of_items() {
        $this->myCart->add($this->itemOne);
        $this->myCart->add($this->itemTwo);

        $this->myCart->setCount();

        $this->assertEquals(2, $this->myCart->itemsCount);
    }

    /** @test */
    function it_can_set_its_count_of_items_with_a_custom_key() {
        $this->myCart->add($this->itemOne, 'customCart');
        $this->myCart->add($this->itemTwo, 'customCart');

        $this->myCart->setCount();

        $this->assertEquals(2, $this->myCart->itemsCount);
    }

    /** @test */
    function it_can_set_its_count_of_zero_items_if_doesnt_have_items() {
        $this->myCart->setCount();

        $this->assertEquals(0, $this->myCart->itemsCount);
    }

    /** @test */
    function it_can_set_its_total() {
        $this->myCart->add($this->itemOne);
        $this->myCart->add($this->itemOne);

        $this->myCart->setTotal();

        $this->assertEquals(17, $this->myCart->itemsTotal);
    }

    /** @test */
    function it_knows_its_total_with_a_custom_key() {
        $this->myCart->add($this->itemOne, 'AnotherCart');
        $this->myCart->add($this->itemTwo, 'AnotherCart');

        $this->myCart->setTotal('AnotherCart');

        $this->assertEquals(16.4, $this->myCart->itemsTotal);
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

        $this->myCart->add($this->itemOne, 'AnotherCart', 'partial_total');
        $this->myCart->add($this->itemTwo, 'AnotherCart', 'partial_total');

        $this->myCart->setTotal('AnotherCart', 'partial_total');

        $this->assertEquals(10.7, $this->myCart->itemsTotal);
    }

    /** @test */
    function it_can_get_total_of_zero_if_doesnt_have_items() {
        $this->myCart->setTotal();

        $this->assertEquals(0, $this->myCart->total);
    }
}
