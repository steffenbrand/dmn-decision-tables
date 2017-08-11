<?php

namespace SteffenBrand\DmnDecisionTables;

class DecisionTableBuilder
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
     * @var Input[]
     */
    private $inputs;

    /**
     * @var Output[]
     */
    private $outputs;

    /**
     * @return Input[]
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * @param string $label
     * @param string $name
     * @param string $type
     * @return $this
     */
    public function addInput($label, $name, $type)
    {
        $this->inputs[] = new Input($label, $name, $type);
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
     * @param string $label
     * @param string $name
     * @param string $type
     * @return $this
     */
    public function addOutput($label, $name, $type)
    {
        $this->outputs[] = new Output($label, $name, $type);
        return $this;
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
     * @return $this
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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

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
}