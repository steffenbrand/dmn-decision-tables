<?php

namespace SteffenBrand\DmnDecisionTables\Model;

interface DmnConvertible
{
    /**
     * @return string
     */
    public function toDMN();
}