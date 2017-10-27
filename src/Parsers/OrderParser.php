<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

class OrderParser
{
    /**
     * Parse the given SimpleXmlElement to a Order entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Order
     */
    public function parse(SimpleXMLElement $payload)
    {
        $order = (new Entities\Order)
            ->setDateTime(Carbon::parse((string) $payload->OrderDateTime))
            ->setTotal((int) (string) ((float) $payload->TotalDue * 100))
            ->setTotalTax((int) (string) ((float) $payload->TotalTax * 100))
            ->setTotalDiscount((int) (string) ((float) $payload->TotalDiscount * 100))
            ->setIdentifiers(new Collection([
                'ap21_id'     => (integer) $payload->Id,
                'ap21_number' => (integer) $payload->OrderNumber
            ]))
            ->setCustomer(
                (new Entities\Person)->setIdentifiers(collect([
                    'ap21_id' => (integer) $payload->PersonId
                ]))
            )
            ->setContacts(
                (new ContactParser)->parseCollection($payload->Contacts)
            )
            ->setAddresses(
                (new AddressParser)->parseCollection($payload->Addresses)
            )
            ->setFreightOption(
                (new Entities\FreightOption)
                    ->setId((integer) $payload->SelectedFreightOption->Id)
                    ->setName((integer) $payload->SelectedFreightOption->Name)
                    ->setValue((integer) (string) ((float) $payload->SelectedFreightOption->Value * 100))
            );

        foreach ($payload->Payments->PaymentDetail as $payment) {
            $order->getPayments()->push(
                (new PaymentParser)->parse($payment)
            );
        }

        foreach ($payload->OrderDetails->OrderDetail as $lineItem) {
            $order->getLineItems()->push(
                (new LineItemParser)->parse($lineItem)
            );
        }

        return $order;
    }
}