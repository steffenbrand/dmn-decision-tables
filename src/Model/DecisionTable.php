<?php

namespace SteffenBrand\DmnDecisionTables\Model;

use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Exception\DmnConversionException;

class DecisionTable implements DmnConvertible
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
     * DecisionTable constructor.
     * @param DecisionTableBuilder $builder
     */
    public function __construct($builder)
    {
        $this->name = $builder->getName();
        $this->id = $builder->getId();
        $this->hitPolicy = $builder->getHitPolicy();
        $this->collectOperator = $builder->getCollectOperator();
        $this->inputs = $builder->getInputs();
        $this->outputs = $builder->getOutputs();
    }

    /**
     * @return string
     * @throws DmnConversionException
     */
    public function toDMN()
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $dom->loadXML(
            '<?xml version="1.0" encoding="UTF-8"?>' .
            '<definitions xmlns="http://www.omg.org/spec/DMN/20151101/dmn11.xsd" id="definitions" name="definitions" namespace="http://camunda.org/schema/1.0/dmn">' .
                '<decision id="' . $this->id . '" name="' . $this->name . '">' .
                    '<decisionTable id="' . uniqid('decisionTable') . '" ' . $this->getHitPolicy() . '>' .
                        $this->getInputs() .
                        $this->getOutputs() .
                    '</decisionTable>' .
                '</decision>' .
            '</definitions>'
        );

        if (empty($errors = libxml_get_errors()) === false) {
            libxml_clear_errors();
            throw new DmnConversionException($errors);
        }

        return $dom->saveXML();
    }

    /**
     * @return string
     */
    private function getInputs()
    {
        $xml = '';

        foreach ($this->inputs as $input) {
            $xml .= $input->toDMN();
        }

        return $xml;
    }

    /**
     * @return string
     */
    private function getOutputs()
    {
        $xml = '';

        foreach ($this->outputs as $output) {
            $xml .= $output->toDMN();
        }

        return $xml;
    }

    /**
     * @return string
     */
    private function getHitPolicy()
    {
        $xml = 'hitPolicy="' . $this->hitPolicy . '"';

        if (HitPolicy::COLLECT_POLICY === $this->hitPolicy) {
            $xml .= ' aggregation="' . $this->collectOperator . '"';
        }

        return $xml;
    }
}