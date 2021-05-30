<?php

namespace SebaCarrasco93\MyCart\Tests\Unit;

use SebaCarrasco93\MyCart\Tests\TestCase;
use SebaCarrasco93\MyCart\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class MyCartTest extends TestCase
{
    /** @test */
    function it_knows_its_original_session_name() {
        $myCart = new MyCart();

        $this->assertEquals('mycart', $myCart->getKeySessionName());
    }

    /** @test */
    function it_knows_its_custom_session_name() {
        $myCart = new MyCart();
        
        $myCart->setKeySessionName('myowncart');

        $this->assertEquals('myowncart', $myCart->getKeySessionName());
    }

    /** @test */
    function it_knows_its_custom_items_name() {
        $myCart = new MyCart();
        
        $myCart->setKeyItemsName('myownitems');

        $this->assertEquals('myownitems', $myCart->getKeyItemsName());
    }

    /** @test */
    function it_knows_its_original_items_name() {
        $myCart = new MyCart();

        $this->assertEquals('items', $myCart->getKeyItemsName());
    }

    /** @test */
    function it_knows_its_custom_price_name() {
        $myCart = new MyCart();
        
        $myCart->setKeyPriceName('myownprice');

        $this->assertEquals('myownprice', $myCart->getKeyPriceName());
    }

    /** @test */
    function it_knows_its_original_price_name() {
        $myCart = new MyCart();

        $this->assertEquals('price', $myCart->getKeyPriceName());
    }

    /** @test */
    function it_knows_all_of_its_attributes() {
        $myCart = new MyCart();

        $myCart->setAllKeys('myownitems', 'myownprice', 'myownsession');

        $this->assertEquals('myownitems', $myCart->keyItemsName);
        $this->assertEquals('myownprice', $myCart->keyPriceName);
        $this->assertEquals('myownsession', $myCart->keySessionName);
    }

    /** @test */
    function it_can_add_an_item() {
        $myCart = new MyCart();
        $myCart->add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['items'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_items_key_from_session() {
        config(['mycart.items_name' => 'products']);

        $myCart = new MyCart();
        $myCart->add($this->itemOne);

        $this->assertEquals($this->itemOne, session('mycart')['products'][0]);
    }

    /** @test */
    function it_can_add_an_item_on_a_custom_items_key_from_parameter() {
        $myCart = new MyCart();
        $myCart->add($this->itemOne, 'products');
        
        $this->assertEquals($this->itemOne, session('mycart')['products'][0]);
    }

    /** @test */
    function it_can_get_all_the_items() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne);
        $myCart->add($this->itemTwo);

        $this->assertEquals($this->itemOne, $myCart->get()[0]);
        $this->assertEquals($this->itemTwo, $myCart->get()[1]);
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne);
        $myCart->add($this->itemTwo);

        $this->assertEquals($this->itemTwo, $myCart->findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_is_inexistent() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne);

        $this->assertNull($myCart->findByUuid('222BBB'));
    }

    /** @test */
    function it_can_find_an_item_by_their_uuid_if_it_doesnt_have_any_items() {
        $myCart = new MyCart();

        $this->assertNull($myCart->findByUuid('222BBB'));
    }

    /** @test */
    function it_can_flush_all_the_items() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne);

        $myCart->flush();

        $this->assertNull($myCart->get());
    }

    /** @test */
    function it_can_flush_all_the_items_with_a_custom_key() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne, 'customCart');

        $myCart->flush('customCart');

        $this->assertNull($myCart->get('customCart'));
    }

    /** @test */
    function it_can_knows_its_count_of_items() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne);
        $myCart->add($this->itemTwo);

        $myCart->setCount();

        $this->assertEquals(2, $myCart->itemsCount);
    }

    /** @test */
    function it_can_set_its_count_of_items_with_a_custom_key() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne, 'customCart');
        $myCart->add($this->itemTwo, 'customCart');

        $myCart->setCount();

        $this->assertEquals(2, $myCart->itemsCount);
    }

    /** @test */
    function it_can_set_its_count_of_zero_items_if_doesnt_have_items() {
        $myCart = new MyCart();

        $myCart->setCount();

        $this->assertEquals(0, $myCart->itemsCount);
    }

    /** @test */
    function it_can_set_its_total() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne);
        $myCart->add($this->itemOne);

        $myCart->setTotal();

        $this->assertEquals(17, $myCart->itemsTotal);
    }

    /** @test */
    function it_knows_its_total_with_a_custom_key() {
        $myCart = new MyCart();

        $myCart->add($this->itemOne, 'AnotherCart');
        $myCart->add($this->itemTwo, 'AnotherCart');

        $myCart->setTotal('AnotherCart');

        $this->assertEquals(16.4, $myCart->itemsTotal);
    }

    /** @test */
    function it_knows_its_total_with_a_custom_key_and_total_name() {
        $myCart = new MyCart();

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

        $myCart->add($this->itemOne, 'AnotherCart', 'partial_total');
        $myCart->add($this->itemTwo, 'AnotherCart', 'partial_total');

        $myCart->setTotal('AnotherCart', 'partial_total');

        $this->assertEquals(10.7, $myCart->itemsTotal);
    }

    /** @test */
    function it_can_get_total_of_zero_if_doesnt_have_items() {
        $myCart = new MyCart();

        $myCart->setTotal();

        $this->assertEquals(0, $myCart->total);
    }
}
