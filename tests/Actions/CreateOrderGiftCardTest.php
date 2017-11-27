<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Parsers\OrderParser;
use Arkade\Apparel21\Parsers\PayloadParser;
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

        $this->assertArrayHasKey('ExtraVoucherInformation', $giftCard);
        $this->assertArrayHasKey('VoucherType', $giftCard['ExtraVoucherInformation']);
        $this->assertArrayHasKey('EmailSubject', $giftCard['ExtraVoucherInformation']);
        $this->assertArrayHasKey('Email', $giftCard['ExtraVoucherInformation']);
        $this->assertArrayHasKey('PersonalisedMessage', $giftCard['ExtraVoucherInformation']);
        $this->assertArrayHasKey('RecieverName', $giftCard['ExtraVoucherInformation']);
    }

    /**
     * @test
     */
    public function returns_populated_order_line_items_giftCard()
    {
        $this->markTestSkipped();
    }


}