<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities\Order;
use Arkade\Apparel21\Entities\Payment;
use Arkade\Apparel21\Entities\Variant;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class OrderParser
{
    /**
     * @param SimpleXMLElement $payload
     * @return Order $order
     */
    public function parse(SimpleXMLElement $payload)
    {
        $order = (new Order)->setIdentifiers(new Collection([
            'ap21_order_id' => (string) $payload->OrderNumber,
            'ap21_person_id' => (string) $payload->PersonId
        ]));

        $order = (new HelperParser)->parseContactsToEntity($payload->Contacts, $order);
        $order = (new HelperParser)->parseAddressesToEntity($payload->Addresses, $order);

        $order = $this->parsePaymentToOrder($payload->Payments, $order);
        $order = $this->parseVariantsToOrder($payload->OrderDetails, $order);
        return $order;
    }

    /**
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
                    ->setReference((string)$item->Reference)
                    ->setMessage((string)$item->Message)
                );
            }
        }

        return $order;
    }

    /**
     * @param $orderDetails
     * @param Order $order
     *
     * @return Order
     */
    protected function parseVariantsToOrder($orderDetails, Order $order)
    {
        foreach ($orderDetails as $orderDetail) {
            foreach ($orderDetail->OrderDetail as $item) {
                $order->getVariants()->push((new Variant)
                    ->setTitle('Item')
                    ->setSKU((string) $item->SkuId)
                    ->setOptions(new Collection([
                        'quantity'    => (string) $item->Quantity,
                        'value'       => (string) $item->Value,
                        'tax_percent' => (string) $item->TaxPercent
                    ]))
                    ->setPrice((string) $item->Price)
                );
            }
        }
        return $order;
    }
}