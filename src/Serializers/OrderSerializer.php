<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Apparel21\Entities;

class OrderSerializer
{
    use Concerns\MapContacts,
        Concerns\MapAddresses,
        Concerns\MapPayments,
        Concerns\MapLineItems;

    /**
     * Serialize.
     *
     * @param  Entities\Order $order
     * @return string
     */
    public function serialize(Entities\Order $order)
    {
        $payload = new \SimpleXMLElement("<Order></Order>");

        (new XMLHelper)->appendXML(
            $this->buildXMLArray($order),
            $payload
        );

        return (new XMLHelper)->stripHeader($payload->asXML());
    }

    /**
     * Build an array of data to be converted to XML.
     *
     * @param  Entities\Order $order
     * @return array
     */
    protected function buildXMLArray(Entities\Order $order)
    {
        $payload = array_filter([
            'Id'          => $order->getIdentifiers()->get('ap21_id'),
            'OrderNumber' => $order->getIdentifiers()->get('ap21_number'),
            'PersonId'    => $order->getCustomer()->getIdentifiers()->get('ap21_id'),
            'TotalDiscount' => $order->getTotalDiscount() / 100
        ]);

        $payload = $this->mapContacts($payload, $order->getContacts());
        $payload = $this->mapAddresses($payload, $order->getAddresses());
        $payload = $this->mapPayments($payload, $order->getPayments());
        $payload = $this->mapLineItems($payload, $order->getLineItems());

        if ($freightOption = $order->getFreightOption()) {
            $payload['SelectedFreightOption'] = array_filter([
                'Id'    => $freightOption->getId(),
                'Name'  => $freightOption->getName(),
                'Value' => $freightOption->getValue() / 100
            ]);
        }

        return $payload;
    }
}