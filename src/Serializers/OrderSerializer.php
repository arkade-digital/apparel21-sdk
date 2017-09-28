<?php

namespace Arkade\Apparel21\Serializers;

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
        return $this->convert($order, $payload);
    }
}