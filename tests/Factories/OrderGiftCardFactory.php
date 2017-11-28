<?php

namespace Arkade\Apparel21\Factories;

use Arkade\Apparel21\Entities;

class OrderGiftCardFactory
{
    /**
     * Make an order entity.
     *
     * @return Entities\Order
     */
    public function make()
    {
        $order = (new Entities\Order)
            ->setCustomer(
                (new Entities\Person)->setIdentifiers(collect([
                    'ap21_id' => 1122
                ]))
            );

        $order->getContacts()->push(
            (new Entities\Contact)
                ->setType('email')
                ->setValue('foo@bar.com.au')
        );

        $order->getAddresses()->push(
            (new Entities\Address)
                ->setType('billing')
                ->setLine1('Adelaide')
                ->setCity('ADELAIDE')
                ->setState('SA')
                ->setPostcode('5000')
                ->setCountry('AU')
        );

        $order->getAddresses()->push(
            (new Entities\Address)
                ->setType('delivery')
                ->setLine1('Adelaide')
                ->setCity('ADELAIDE')
                ->setState('SA')
                ->setPostcode('5000')
                ->setCountry('AU')
        );

        $order->getPayments()->push(
            (new Entities\Payment)
                ->setAttributes(collect([
                    'card_type' => 'CC',
                ]))
                ->setType('CreditCard')
                ->setAmount(10000)
        );

        $order->getLineItems()->push(
            (new Entities\LineItem)
                ->setQuantity(1)
                ->setTotal(10000)
                ->setSellable(
                    (new Entities\Variant)
                        ->setIdentifiers(collect([
                            'ap21_sku_id' => 177464
                        ]))
                        ->setPrice(10000)
                )
                ->setGiftCard(
                    collect([
                        'VoucherType'         => 'EmailVoucher',
                        'EmailSubject'        => 'Decjuba GV Test Voucher 01',
                        'Email'               => 'foo@bar.com.au',
                        'PersonalisedMessage' => 'Decjuba GV Test Voucher for Capcom Team',
                        'RecieverName'        => 'Arkade Capcom team'
                    ])
                )
        );

        return $order;
    }
}
