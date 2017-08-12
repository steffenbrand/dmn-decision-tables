<?php

namespace SteffenBrand\DmnDecisionTables\Model;

interface DmnConvertibleInterface
{
    /**
     * @return string
     */
    public function toDMN();
}