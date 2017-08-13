<?php

namespace SteffenBrand\DmnDecisionTables\Exception;

/**
 * Class DmnValidationException
 * @package SteffenBrand\DmnDecisionTables\Exception
 */
class DmnValidationException extends \UnexpectedValueException
{
    /**
     * DmnValidationException constructor.
     * @param array $errors
     */
    public function __construct($errors)
    {
        parent::__construct(sprintf('Errors while building decision table: %s', json_encode($errors)));
    }
}