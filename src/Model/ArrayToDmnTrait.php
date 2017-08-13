<?php

namespace SteffenBrand\DmnDecisionTables\Model;

trait ArrayToDmnTrait
{
    /**
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