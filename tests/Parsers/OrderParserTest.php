<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class OrderParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_order()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Entities\Order::class, $order);

        $this->assertEquals('362812', $order->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('789456712', $order->getIdentifiers()->get('ap21_number'));
        $this->assertEquals(Carbon::parse('2017-09-28 13:28:02'), $order->getDateTime());
        $this->assertEquals(5990, $order->getTotal());
        $this->assertEquals(545, $order->getTotalTax());
        $this->assertEquals(1050, $order->getTotalDiscount());
    }

    /**
     * @test
     */
    public function returns_populated_order_customer()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Entities\Person::class, $order->getCustomer());

        $this->assertEquals('101451', $order->getCustomer()->getIdentifiers()->get('ap21_id'));
    }

    /**
     * @test
     */
    public function returns_populated_order_contacts()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getContacts());
        $this->assertEquals(1, $order->getContacts()->count());

        $this->assertInstanceOf(Entities\Contact::class, $order->getContacts()->first());
        $this->assertEquals('email', $order->getContacts()->first()->getType());
        $this->assertEquals('john.smith@test.com.au', $order->getContacts()->first()->getValue());
    }

    /**
     * @test
     */
    public function returns_populated_order_addresses()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getAddresses());
        $this->assertEquals(2, $order->getAddresses()->count());

        $address = $order->getAddresses()->get(1);

        $this->assertInstanceOf(Entities\Address::class, $address);
        $this->assertEquals('delivery', $address->getType());
        $this->assertEquals('Michy Rosens', $address->getContactName());
        $this->assertEquals('37 Swan Street', $address->getLine1());
        $this->assertEquals('St Kilda East', $address->getCity());
        $this->assertEquals('VIC', $address->getState());
        $this->assertEquals('3183', $address->getPostcode());
        $this->assertEquals('AU', $address->getCountry());
    }

    /**
     * @test
     */
    public function returns_populated_order_line_items()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getLineItems());
        $this->assertEquals(2, $order->getLineItems()->count());

        $lineItem = $order->getLineItems()->first();

        $this->assertInstanceOf(Entities\LineItem::class, $lineItem);

        $this->assertEquals('Processing', $lineItem->getStatus());
        $this->assertEquals(1, $lineItem->getQuantity());
        $this->assertEquals(5990, $lineItem->getTotal());

        $this->assertEquals(1418618, $lineItem->getIdentifiers()->get('ap21_id'));

        $this->assertEquals(false, $lineItem->getAttributes()->get('gift_wrap'));
        $this->assertEquals('', $lineItem->getAttributes()->get('gift_wrap_message'));
        $this->assertEquals('', $lineItem->getAttributes()->get('sender_name'));
        $this->assertEquals('', $lineItem->getAttributes()->get('receiver_name'));
        $this->assertEquals('Australia Post', $lineItem->getAttributes()->get('carrier'));
        $this->assertEquals('', $lineItem->getAttributes()->get('carrier_url'));

        $this->assertInstanceOf(Entities\ServiceType::class, $lineItem->getServiceType());
        $this->assertEquals(19785, $lineItem->getServiceType()->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('02S1', $lineItem->getServiceType()->getIdentifiers()->get('ap21_code'));

        $this->assertInstanceOf(Entities\Variant::class, $lineItem->getSellable());
        $this->assertEquals('Rose Bow Dress', $lineItem->getSellable()->getTitle());
        $this->assertEquals(5990, $lineItem->getSellable()->getPrice());
        $this->assertEquals(3958, $lineItem->getSellable()->getIdentifiers()->get('ap21_product_id'));
        $this->assertEquals('1298DWSS', $lineItem->getSellable()->getIdentifiers()->get('ap21_product_code'));
        $this->assertEquals(7535, $lineItem->getSellable()->getIdentifiers()->get('ap21_colour_id'));
        $this->assertEquals('-', $lineItem->getSellable()->getIdentifiers()->get('ap21_colour_code'));
        $this->assertEquals(21503, $lineItem->getSellable()->getIdentifiers()->get('ap21_sku_id'));
        $this->assertEquals('-', $lineItem->getSellable()->getIdentifiers()->get('ap21_size_code'));
    }

    /**
     * @test
     */
    public function returns_populated_order_line_items_discounts()
    {
        $order = (new OrderParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__ . '/../Stubs/Orders/order.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $order->getLineItems());
        $this->assertEquals(2, $order->getLineItems()->count());

        $lineItem = $order->getLineItems()->first();

        $this->assertInstanceOf(Entities\LineItem::class, $lineItem);

        $discount = $lineItem->getDiscount()->first();

        $this->assertEquals(1, $discount['ap21_discount_type']);
        $this->assertEquals(1050, $discount['value']);
    }
}
