<?php

namespace SebaCarrasco93\MyCart\Tests\Unit\Traits;

use SebaCarrasco93\MyCart\Tests\TestCase;
use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class AttributesTest extends TestCase
{
    /** @test */
    function it_can_get_attributes_using_get() {
        $this->myCart->setItemsKey('customItemKey');

        $this->assertEquals('customItemKey', $this->myCart->getAttribute('itemsKey'));
    }

    /** @test */
    function it_can_get_the_original_price_key() {
        $this->myCart->setPriceKey();

        $this->assertEquals('price', $this->myCart->getAttribute('priceKey'));
    }

    /** @test */
    function it_can_get_the_original_items_key() {
        $this->myCart->setItemsKey();

        $this->assertEquals('items', $this->myCart->getAttribute('itemsKey'));
    }

    /** @test */
    function it_can_set_the_original_items_key() {
        $this->myCart->setItemsKey('MyCart');

        $this->assertEquals('MyCart', $this->myCart->getAttribute('itemsKey'));
    }

    /** @test */
    function it_knows_when_it_has_items() {
        $this->myCart->add($this->itemOne);

        $this->myCart->hasItems();

        $this->assertTrue($this->myCart->getAttribute('hasItems'));
    }

    /** @test */
    function it_knows_when_it_has_items_with_a_custom_key() {
        $this->myCart->add($this->itemOne, 'customCart');

        $this->myCart->hasItems('customCart');

        $this->assertTrue($this->myCart->getAttribute('hasItems'));
    }

    /** @test */
    function it_knows_when_it_doesnt_have_any_items() {
        $this->myCart->hasItems();

        $this->assertFalse($this->myCart->getAttribute('hasItems'));
    }

    /** @test */
    function it_knows_when_it_doesnt_have_any_items_with_a_custom_key() {
        $this->myCart->add($this->itemOne);

        $this->myCart->hasItems('customCart');

        $this->assertFalse($this->myCart->getAttribute('hasItems'));
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_has_items() {
        $this->myCart->add($this->itemOne);
        $this->myCart->add($this->itemTwo);

        $this->myCart->countItems();
        
        $this->assertEquals(2, $this->myCart->getAttribute('countItems'));
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_has_items_with_a_custom_key() {
        $this->myCart->add($this->itemOne, 'someNewKey');
        $this->myCart->add($this->itemTwo);
        $this->myCart->add($this->itemTwo);

        $this->myCart->countItems('someNewKey');
        
        $this->assertEquals(1, $this->myCart->getAttribute('countItems'));

        $this->myCart->countItems();
        
        $this->assertEquals(2, $this->myCart->getAttribute('countItems'));
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_doesnt_have_any_items() {
        $this->myCart->countItems();
        
        $this->assertEquals(0, $this->myCart->getAttribute('countItems'));
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_doesnt_have_any_items_with_a_custom_key() {
        $this->myCart->add($this->itemTwo);
        
        $this->myCart->countItems('AnotherCustomKey');
        
        $this->assertEquals(0, $this->myCart->getAttribute('countItems'));
    }

    /** @test */
    function it_can_calculate_the_total() {
        $this->myCart->add($this->itemOne);
        $this->myCart->add($this->itemTwo);

        $this->myCart->calculateTotal();

        $this->assertEquals(16.4, $this->myCart->getAttribute('total'));
    }
}
