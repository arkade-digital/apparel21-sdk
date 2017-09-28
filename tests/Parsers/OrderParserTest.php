<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use Arkade\Support\Contracts;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class OrderParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_order_entity()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Entities\Order::class, $order);
        $this->assertInstanceOf(Contracts\Order::class, $order);

        $this->assertEquals('7894567', $order->getIdentifiers()->get('ap21_order_id'));

    }

    /**
     * @test
     */
    public function returns_populated_order_with_contacts()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getContacts());
        $this->assertCount(1, $order->getContacts());
        $this->assertInstanceOf(Entities\Contact::class, $order->getContacts()->first());
        $this->assertInstanceOf(Contracts\Contact::class, $order->getContacts()->first());

        $this->assertEquals('john.smith@test.com.au', $order->getContacts()->first(function (Entities\Contact $contact) {
            return 'email' == $contact->getType();
        })->getValue());
    }

    /**
     * @test
     */
    public function returns_populated_order_with_address()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getAddresses());
        $this->assertCount(2, $order->getAddresses());

        $this->assertInstanceOf(Entities\Address::class, $order->getAddresses()->first());
        $this->assertInstanceOf(Contracts\Address::class, $order->getAddresses()->first());

        $this->assertEquals('billing', $order->getAddresses()->first()->getType());
        $this->assertEquals('101 Cremorne St', $order->getAddresses()->first()->getLine1());

        $this->assertEquals('delivery', $order->getAddresses()->get(1)->getType());
        $this->assertEquals('37 Swan Street', $order->getAddresses()->get(1)->getLine1());
    }

    /**
     * @test
     */
    public function returns_populated_order_with_payment()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getPayments());
        $this->assertCount(1, $order->getContacts());
        $this->assertInstanceOf(Entities\Payment::class, $order->getPayments()->first());
        $this->assertInstanceOf(Contracts\Payment::class, $order->getPayments()->first());

        $this->assertEquals(7781, $order->getIdentifiers()->get('payment_id'));
    }

}