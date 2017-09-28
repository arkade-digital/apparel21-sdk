<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities\Order;
use Arkade\Apparel21\Entities\Payment;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class OrderParser
{

    public function parse(SimpleXMLElement $payload)
    {
        $order = (new Order)->setIdentifiers(new Collection([
            'ap21_order_id' => (string) $payload->OrderNumber,
            'ap21_person_id' => (string) $payload->PersonId
        ]));

        $order = (new HelperParser)->parseContactsToEntity($payload->Contacts, $order);
        $order = (new HelperParser)->parseAddressesToEntity($payload->Addresses, $order);

        $order = $this->parsePaymentToOrder($payload->Payments, $order);
        return $order;
    }

    /**
     * TODO:CARLOS continue here monday 02/10
     * @param $payments
     * @param Order $order
     *
     * @return Order
     */
    protected function parsePaymentToOrder($payments, Order $order)
    {
        foreach ($payments as $payment) {
            foreach ($payment->PaymentDetail as $item) {
                $order->getPayments()->push((new Payment)
                    ->setIdentifiers(new Collection([
                        'payment_id' => (string)$item->Id
                    ]))
                    ->setOrigin((string)$item->Origin)
                    ->setCardType((string)$item->CardType)
                    ->setStan((string)$item->Stan)
                    ->setAmount((string)$item->Amount)
                    ->setMessage((string)$item->Message)
                );
            }
        }

        return $order;
    }

}