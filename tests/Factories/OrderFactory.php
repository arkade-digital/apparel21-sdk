<?php

namespace Arkade\Apparel21\Factories;

use Arkade\Apparel21\Entities;

class OrderFactory
{
    /**
     * Make an order entity.
     *
     * @return Entities\Order
     */
    public function make()
    {
        $order = (new Entities\Order)
            ->setTotalDiscount(1050)
            ->setCustomer(
                (new Entities\Person)->setIdentifiers(collect([
                    'ap21_id' => 745619
                ]))
            );

        $order->getContacts()->push(
            (new Entities\Contact)
                ->setType('email')
                ->setValue('bob@example.com')
        );

        $order->getAddresses()->push(
            (new Entities\Address)
                ->setType('billing')
                ->setLine1('101 Cremorne St')
                ->setCity('Melbourne')
                ->setState('VIC')
                ->setPostcode('3183')
                ->setCountry('AU')
        );

        $order->getAddresses()->push(
            (new Entities\Address)
                ->setType('delivery')
                ->setLine1('200 Swan St')
                ->setCity('Melbourne')
                ->setState('VIC')
                ->setPostcode('3183')
                ->setCountry('AU')
        );

        $order->getPayments()->push(
            (new Entities\Payment)
                ->setIdentifiers(collect([
                    'ap21_settlement' => '20111129',
                    'ap21_reference'  => 'Ref1',
                ]))
                ->setAttributes(collect([
                    'card_type' => 'Visa',
                    'auth_code' => '1234',
                    'message'   => 'payment_statusCURRENTbank_'
                ]))
                ->setType('CreditCard')
                ->setAmount(6190)
        );

        $order->getLineItems()->push(
            (new Entities\LineItem)
                ->setQuantity(1)
                ->setTotal(5990)
                ->setDiscount(
                    collect([
                        'DiscountTypeId' => 1,
                        'Value' => 1050
                    ])
                )
                ->setSellable(
                    (new Entities\Variant)
                        ->setIdentifiers(collect([
                            'ap21_sku_id' => 9876
                        ]))
                        ->setPrice(5990)
                )
        );

        $order->setFreightOption(
            (new Entities\FreightOption)
                ->setId(123)
                ->setName('Express Australia Post')
                ->setValue(1250)
        );

        return $order;
    }
}