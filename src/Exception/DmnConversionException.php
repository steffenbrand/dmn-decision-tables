<?php

namespace SteffenBrand\DmnDecisionTables\Exception;

class DmnConversionException extends \UnexpectedValueException
{
    /**
     * DmnConversionException constructor.
     * @param array $errors
     */
    public function __construct($errors)
    {
        parent::__construct(sprintf('Errors while generating DMN file: %s', json_encode($errors)));
    }
}