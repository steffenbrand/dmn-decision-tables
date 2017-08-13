<?php

namespace SteffenBrand\DmnDecisionTables\Validator;

use SteffenBrand\DmnDecisionTables\DecisionTableBuilderInterface;

/**
 * Interface DecisionTableValidatorInterface
 * @package SteffenBrand\DmnDecisionTables\Validator
 */
interface DecisionTableValidatorInterface
{
    /**
     * DecisionTableValidatorInterface constructor.
     * @param DecisionTableBuilderInterface$builder
     */
    public function __construct($builder);

    /**
     * Validates a DecisionTableBuilder instance.
     *
     * @return DecisionTableValidator
     */
    public function validate();
}