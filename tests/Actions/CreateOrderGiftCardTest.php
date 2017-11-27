<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Parsers\OrderParser;
use Arkade\Apparel21\Parsers\PayloadParser;
use Arkade\Apparel21\Serializers\OrderSerializer;
use Arkade\Apparel21\Serializers\XMLHelper;
use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class CreateOrderGiftCardTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new CreateOrder((new Factories\OrderGiftCardFactory())->make()))->request();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('Persons/1122/Orders', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_order_with_populate_gift_card()
    {
        $order = (new CreateOrder((new Factories\OrderGiftCardFactory())->make()))->response(
            new Response(
                201,
                ['Location' => 'http://api.example.com.au/RetailAPI/Persons/1122/Orders/12345?CountryCode=AU']
            )
        );

        $this->assertInstanceOf(Entities\Order::class, $order);
        $lineItem = $order->getLineItems()->first();

        $giftCard = $lineItem->getGiftCard()->toArray();

        $this->assertArrayHasKey('VoucherType', $giftCard);
        $this->assertArrayHasKey('EmailSubject', $giftCard);
        $this->assertArrayHasKey('Email', $giftCard);
        $this->assertArrayHasKey('PersonalisedMessage', $giftCard);
        $this->assertArrayHasKey('RecieverName', $giftCard);
    }

    /**
     * @test
     */
    public function returns_populated_xml()
    {
        $xml = (new OrderSerializer)->serialize(
            (new Factories\OrderGiftCardFactory())->make()
        );

        $this->assertTrue(
            (new XMLHelper)->compare(
                file_get_contents(__DIR__.'/../Stubs/Orders/create_order_gift_card.xml'),
                $xml
            )
        );
    }

}