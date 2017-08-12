<?php

namespace SteffenBrand\DmnDecisionTables;

use SteffenBrand\DmnDecisionTables\Model\DecisionTable;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\Output;

interface DecisionTableBuilderInterface
{
    /**
     * DecisionTableBuilder constructor.
     */
    public function __construct();

    /**
     * @return DecisionTable
     */
    public function build();

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
    public function getId();

    /**
     * @param string $id
     * @return DecisionTableBuilderInterface
     */
    public function setId($id);

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
     * @param string $label
     * @param string $name
     * @param string $type
     * @return DecisionTableBuilderInterface
     */
    public function addInput($label, $name, $type);

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
     * @param string $label
     * @param string $name
     * @param string $type
     * @return DecisionTableBuilderInterface
     */
    public function addOutput($label, $name, $type);
}