<?php

namespace SteffenBrand\DmnDecisionTables;

use SteffenBrand\DmnDecisionTables\Exception\DmnValidationException;
use SteffenBrand\DmnDecisionTables\Model\DecisionTable;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\Output;
use SteffenBrand\DmnDecisionTables\Model\Rule;

interface DecisionTableBuilderInterface
{
    /**
     * DecisionTableBuilder constructor.
     */
    public function __construct();

    /**
     * @param bool $validation
     * @param DecisionTableValidatorInterface
     * @return DecisionTable
     * @throws DmnValidationException
     */
    public function build($validation = true, $decisionTableValidator = null);

    /**
     * @return DecisionTableBuilderInterface
     */
    public static function getInstance();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return DecisionTableBuilderInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getDefinitionKey();

    /**
     * @param string $definitionKey
     * @return DecisionTableBuilderInterface
     */
    public function setDefinitionKey($definitionKey);

    /**
     * @return string
     */
    public function getHitPolicy();

    /**
     * @param $hitPolicy
     * @return DecisionTableBuilderInterface
     */
    public function setHitPolicy($hitPolicy);

    /**
     * @return string
     */
    public function getCollectOperator();

    /**
     * @param $collectOperator
     * @return DecisionTableBuilderInterface
     */
    public function setCollectOperator($collectOperator);

    /**
     * @return Input[]
     */
    public function getInputs();

    /**
     * @param Input[] $inputs
     * @return DecisionTableBuilderInterface
     */
    public function setInputs($inputs);

    /**
     * @param Input $input
     * @return DecisionTableBuilderInterface
     */
    public function addInput($input);

    /**
     * @return Output[]
     */
    public function getOutputs();

    /**
     * @param Output[] $outputs
     * @return DecisionTableBuilderInterface
     */
    public function setOutputs($outputs);

    /**
     * @param Output $output
     * @return DecisionTableBuilderInterface
     */
    public function addOutput($output);

    /**
     * @return Rule[]
     */
    public function getRules();

    /**
     * @param Rule[] $rules
     * @return DecisionTableBuilderInterface
     */
    public function setRules($rules);

    /**
     * @param array $inputEntries
     * @param array $outputEntries
     * @param string|null $description
     * @return DecisionTableBuilderInterface
     */
    public function addRule($inputEntries, $outputEntries, $description = null);
}