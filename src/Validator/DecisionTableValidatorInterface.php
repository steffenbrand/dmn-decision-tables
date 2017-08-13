<?php

namespace SteffenBrand\DmnDecisionTables\Validator;

use SteffenBrand\DmnDecisionTables\DecisionTableBuilderInterface;

interface DecisionTableValidatorInterface
{
    /**
     * DecisionTableValidatorInterface constructor.
     * @param DecisionTableBuilderInterface$builder
     */
    public function __construct($builder);

    /**
     * @return DecisionTableValidator
     */
    public function validate();
}