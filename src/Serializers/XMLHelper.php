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
        foreach ($data as $key => $node)
        {
            $value = $node;
            if(isset($node['@value'])){
                $value = $node['@value'];
                unset($value['@value']);
            }

            $name = $key;
            if(isset($node['@node'])){
                $name = $node['@node'];
                unset($value['@node']);
            }

            $attributes = [];
            if(isset($node['@attributes'])){
                $attributes = $node['@attributes'];
                unset($value['@attributes']);
            }

            if (is_array($value)) {
                $child = $element->addChild($name);
                $this->appendXML($value, $child);
            } else {
                $child = $element->addChild($key, htmlspecialchars($value));
            }

            foreach ($attributes as $aKey => $aValue) {
                $child->addAttribute($aKey, $aValue);
            }
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