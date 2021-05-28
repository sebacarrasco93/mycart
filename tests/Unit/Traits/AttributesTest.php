<?php

namespace SebaCarrasco93\MyCart\Tests\Unit\Traits;

use SebaCarrasco93\MyCart\Tests\TestCase;
use SebaCarrasco93\MyCart\Facades\MyCart;
use SebaCarrasco93\MyCart\MyCartServiceProvider;

class AttributesTest extends TestCase
{
    /** @test */
    function it_knows_when_it_has_items() {
        MyCart::add($this->itemOne);

        MyCart::hasItems();

        $this->assertTrue(MyCart::getFacadeRoot()->hasItems);
    }

    /** @test */
    function it_knows_when_it_has_items_with_a_custom_key() {
        MyCart::add($this->itemOne, 'customCart');

        MyCart::hasItems('customCart');

        $this->assertTrue(MyCart::getFacadeRoot()->hasItems);
    }

    /** @test */
    function it_knows_when_it_doesnt_have_any_items() {
        MyCart::hasItems();

        $this->assertFalse(MyCart::getFacadeRoot()->hasItems);
    }

    /** @test */
    function it_knows_when_it_doesnt_have_any_items_with_a_custom_key() {
        MyCart::add($this->itemOne);

        MyCart::hasItems('customCart');

        $this->assertFalse(MyCart::getFacadeRoot()->hasItems);
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_has_items() {
        MyCart::add($this->itemOne);
        MyCart::add($this->itemTwo);

        MyCart::countItems();
        
        $this->assertEquals(2, MyCart::getFacadeRoot()->countItems);
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_has_items_with_a_custom_key() {
        MyCart::add($this->itemOne, 'someNewKey');
        MyCart::add($this->itemTwo);
        MyCart::add($this->itemTwo);

        MyCart::countItems('someNewKey');
        
        $this->assertEquals(1, MyCart::getFacadeRoot()->countItems);

        MyCart::countItems();
        
        $this->assertEquals(2, MyCart::getFacadeRoot()->countItems);
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_doesnt_have_any_items() {
        MyCart::countItems();
        
        $this->assertEquals(0, MyCart::getFacadeRoot()->countItems);
    }

    /** @test */
    function it_knows_the_count_of_items_when_it_doesnt_have_any_items_with_a_custom_key() {
        MyCart::add($this->itemTwo);
        
        MyCart::countItems('AnotherCustomKey');
        
        $this->assertEquals(0, MyCart::getFacadeRoot()->countItems);
    }
}
