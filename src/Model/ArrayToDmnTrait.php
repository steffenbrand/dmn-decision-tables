<?php

namespace SteffenBrand\DmnDecisionTables\Model;

trait ArrayToDmnTrait
{
    /**
     * Converts an array of objects (that implement DmnConvertibleInterface) to an XML string.
     *
     * @param DmnConvertibleInterface[] $items
     * @return string
     */
    private function getDmnFromArray($items)
    {
        $xml = '';

        if (empty($items) === false) {
            foreach ($items as $item) {
                $xml .= $item->toDMN();
            }
        }

        return $xml;
    }
}