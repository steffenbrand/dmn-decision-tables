<?php

namespace SteffenBrand\DmnDecisionTables\Model;

/**
 * Interface DmnConvertibleInterface
 * @package SteffenBrand\DmnDecisionTables\Model
 */
interface DmnConvertibleInterface
{
    /**
     * Returns an XML representation of a decision table or its properties.
     *
     * @return string
     */
    public function toDMN();
}