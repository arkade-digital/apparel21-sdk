<?php

namespace Arkade\Apparel21\Serializers;

class XMLHelper
{
    /**
     * Append provided array to the given XML element.
     *
     * @param array $data
     * @param \SimpleXMLElement $element
     */
    public function appendXML(array $data, \SimpleXMLElement &$element)
    {
        foreach ($data as $key => $value)
        {
            if (is_array($value)) {

                if (! empty($value['@node'])) {
                    $key = $value['@node'];
                    unset($value['@node']);
                }

                $child = $element->addChild($key);
                $this->appendXML($value, $child);

                continue;

            }

            $element->addChild($key, htmlspecialchars($value));
        }
    }
}