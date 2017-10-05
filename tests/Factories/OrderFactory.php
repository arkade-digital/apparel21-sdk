<?php

namespace Arkade\Apparel21\Factories;

use Arkade\Apparel21\Entities\Address;
use Arkade\Apparel21\Entities\Contact;
use Arkade\Apparel21\Entities\Order;
use Arkade\Apparel21\Entities\Payment;
use Arkade\Apparel21\Entities\Variant;
use Illuminate\Support\Collection;

class OrderFactory
{

    /**
     * Make an order entity.
     *
     * @return Order
     *
     */
    public function make()
    {
        $order = (new Order)->setIdentifiers(new Collection([
            'ap21_order_id' => 123456,
            'ap21_order_number' => 7894567,
            'ap21_person_id' => 101451
        ]));

        $order->getContacts()->push(
            (new Contact)
                ->setType('email')
                ->setValue('john.smith@test.com.au')
        );

        $order->getAddresses()->push(
            (new Address)->setType('billing')
                ->setLine1('101 Cremorne St')
                ->setCity('')
                ->setState('')
                ->setCountry('')
                ->setPostcode('')
        );

        $order->getAddresses()->push(
            (new Address)->setType('delivery')
                ->setLine1('37 Swan Street')
                ->setCity('')
                ->setState('')
                ->setCountry('')
                ->setPostcode('')
        );

        $order->getPayments()->push(
            (new Payment)
                ->setIdentifiers(new Collection([
                    'payment_id' => '7781'
                ]))
                ->setOrigin('CreditCard')
                ->setCardType('TEST')
                ->setStan('986516')
                ->setAmount('59.90')
                ->setReference('Ref1')
                ->setMessage('payment_statusCURRENTbank_')
        );

        $order->getVariants()->push((new Variant)
            ->setTitle('Item')
            ->setOptions(
                new Collection([
                    'quantity'    => '1',
                    'value'       => '59.90',
                    'tax_percent' => '10.00'
                ])
            )
            ->setSKU('21503')
            ->setPrice('59.90')
        );

        return $order;
    }

}