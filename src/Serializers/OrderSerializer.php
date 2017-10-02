<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Apparel21\Entities\Payment;
use Arkade\Apparel21\Entities\Variant;
use Arkade\Support\Contracts\Order;

class OrderSerializer extends BaseSerializer
{
    /**
     * Serialize.
     *
     * @param  Order $order
     * @return string
     */
    public function serialize(Order $order)
    {
        $payload = new \SimpleXMLElement("<Order></Order>");

        $payloadArray = [
            'OrderNumber' => $order->getIdentifiers()->get('ap21_order_id'),
            'PersonId' => $order->getIdentifiers()->get('ap21_person_id'),
        ];

        $payloadArray = $this->mapPaymentToOrder($payloadArray, $order);
        $payloadArray = $this->mapVariantsToOrder($payloadArray, $order);

        $payload = $this->convert($order, $payload, $payloadArray);

        return $payload;
    }

    /**
     * @param array $payloadArray
     * @param Order $order
     *
     * @return array
     */
    protected function mapPaymentToOrder(array $payloadArray, Order $order)
    {
        collect([
            'payments' => 'Payments.PaymentDetail'
        ])->each(function($payloadKey) use ($order, &$payloadArray) {
            if ($payment = $order->getPayments()->first(function (Payment $payment) {
                return $payment;
            })) {
                array_set($payloadArray, $payloadKey, $this->serializePayment($payment));
            }
        });

        return $payloadArray;
    }

    /**
     * @param array $payloadArray
     * @param Order $order
     *
     * @return array
     */
    protected function mapVariantsToOrder(array $payloadArray, Order $order)
    {
        collect([
            'variants' => 'OrderDetails.OrderDetail'
        ])->each(function($payloadKey) use ($order, &$payloadArray) {
            if ($variant = $order->getVariants()->first(function (Variant $variant) {
                return $variant;
            })) {
                array_set($payloadArray, $payloadKey, $this->serializeVariant($variant));
            }
        });

        return $payloadArray;

    }

    /**
     * @param Payment $payment
     *
     * @return array
     */
    protected function serializePayment(Payment $payment)
    {
        return [
            'Id' => $payment->getIdentifiers()->get('payment_id'),
            'Origin' => $payment->getOrigin(),
            'CardType' => $payment->getCardType(),
            'Stan' => $payment->getStan(),
            'Reference' => $payment->getReference(),
            'Amount' => $payment->getAmount(),
            'Message' => $payment->getMessage()
        ];
    }

    /**
     * @param Variant $variant
     *
     * @return array
     */
    protected function serializeVariant(Variant $variant)
    {
        return [
            'SkuId' => $variant->getSKU(),
            'Quantity' => $variant->getOptions()->get('quantity'),
            'Price' => $variant->getPrice(),
            'Value' => $variant->getOptions()->get('value'),
            'TaxPercent' => $variant->getOptions()->get('tax_percent')
        ];
    }
}