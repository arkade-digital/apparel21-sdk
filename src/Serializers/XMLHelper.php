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

    /**
     * Compare two XML strings.
     *
     * @param  string $expected
     * @param  string $actual
     * @return bool
     */
    public function compare($expected, $actual)
    {
        return $this->normalize($expected) === $this->normalize($actual);
    }

    /**
     * Normalize XML string for comparison.
     *
     * @param  string $xml
     * @return string
     */
    public function normalize($xml)
    {
        return str_replace(["\r", "\n", " "], '', $xml);
    }

    /**
     * Strip header from given XML string.
     *
     * @param  string $xml
     * @return string
     */
    public function stripHeader($xml)
    {
        return str_replace('<?xml version="1.0"?>', '', $xml);
    }
}