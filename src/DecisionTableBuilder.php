<?php

namespace SteffenBrand\DmnDecisionTables;

use SteffenBrand\DmnDecisionTables\Model\DecisionTable;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\Output;
use SteffenBrand\DmnDecisionTables\Model\Rule;

class DecisionTableBuilder implements DecisionTableBuilderInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $hitPolicy;

    /**
     * @var string
     */
    private $collectOperator;

    /**
     * @var Input[]
     */
    private $inputs;

    /**
     * @var Output[]
     */
    private $outputs;

    /**
     * @var Rule[]
     */
    private $rules;

    /**
     * DecisionTableBuilder constructor.
     */
    public function __construct() {}

    /**
     * @return DecisionTable
     */
    public function build()
    {
        return new DecisionTable($this);
    }

    /**
     * @return DecisionTableBuilder
     */
    public static function getInstance()
    {
        return new DecisionTableBuilder();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DecisionTableBuilderInterface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return DecisionTableBuilderInterface
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getHitPolicy()
    {
        return $this->hitPolicy;
    }

    /**
     * @param $hitPolicy
     * @return DecisionTableBuilderInterface
     */
    public function setHitPolicy($hitPolicy)
    {
        $this->hitPolicy = $hitPolicy;
        return $this;
    }

    /**
     * @return string
     */
    public function getCollectOperator()
    {
        return $this->collectOperator;
    }

    /**
     * @param $collectOperator
     * @return DecisionTableBuilderInterface
     */
    public function setCollectOperator($collectOperator)
    {
        $this->collectOperator = $collectOperator;
        return $this;
    }

    /**
     * @return Input[]
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * @param Input[] $inputs
     * @return DecisionTableBuilderInterface
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * @param Input $input
     * @return DecisionTableBuilderInterface
     */
    public function addInput($input)
    {
        $this->inputs[] = $input;
        return $this;
    }

    /**
     * @return Output[]
     */
    public function getOutputs()
    {
        return $this->outputs;
    }

    /**
     * @param Output[] $outputs
     * @return DecisionTableBuilderInterface
     */
    public function setOutputs($outputs)
    {
        $this->outputs = $outputs;
        return $this;
    }

    /**
     * @param Output $output
     * @return DecisionTableBuilderInterface
     */
    public function addOutput($output)
    {
        $this->outputs[] = $output;
        return $this;
    }

    /**
     * @return Rule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param Rule[] $rules
     * @return DecisionTableBuilderInterface
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @param array $inputEntries
     * @param array $outputEntries
     * @param string|null $description
     * @return DecisionTableBuilderInterface
     */
    public function addRule($inputEntries, $outputEntries, $description = null)
    {
        $this->rules[] = new Rule($inputEntries, $outputEntries, $description);
        return $this;
    }
}