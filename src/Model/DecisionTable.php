<?php

namespace SteffenBrand\DmnDecisionTables\Model;

use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Exception\DmnConversionException;

/**
 * Class DecisionTable
 * @package SteffenBrand\DmnDecisionTables\Model
 */
class DecisionTable implements DmnConvertibleInterface
{
    use ArrayToDmnTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $definitionKey;

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
     * DecisionTable constructor.
     * @param DecisionTableBuilder $builder
     */
    public function __construct($builder)
    {
        $this->name = $builder->getName();
        $this->definitionKey = $builder->getDefinitionKey();
        $this->hitPolicy = $builder->getHitPolicy();
        $this->collectOperator = $builder->getCollectOperator();
        $this->inputs = $builder->getInputs();
        $this->outputs = $builder->getOutputs();
        $this->rules = $builder->getRules();
    }

    /**
     * Returns an XML representation of the decision table.
     *
     * @return string
     * @throws DmnConversionException
     */
    public function toDMN()
    {
        $dom = $this->getDomDocument();

        return $dom->saveXML();
    }

    /**
     * Saves decision table as .DMN-file to filesystem.
     *
     * @param $fileNameAndPath
     * @return int
     * @throws DmnConversionException
     */
    public function saveFile($fileNameAndPath)
    {
        $dom = $this->getDomDocument();

        return $dom->save($fileNameAndPath);
    }

    /**
     * Returns a DOMDocument representation of the decision table.
     *
     * @return \DOMDocument
     * @throws DmnConversionException
     */
    private function getDomDocument()
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $dom->loadXML(
            '<?xml version="1.0" encoding="UTF-8"?>' .
            '<definitions xmlns="http://www.omg.org/spec/DMN/20151101/dmn.xsd" id="definitions" name="definitions" namespace="http://camunda.org/schema/1.0/dmn">' .
                '<decision id="' . $this->definitionKey . '" name="' . $this->name . '">' .
                    '<decisionTable id="' . uniqid('decisionTable') . '" ' . $this->getHitPolicy() . '>' .
                        $this->getDmnFromArray($this->inputs) .
                        $this->getDmnFromArray($this->outputs) .
                        $this->getDmnFromArray($this->rules) .
                    '</decisionTable>' .
                '</decision>' .
            '</definitions>'
        );

        if (empty($errors = libxml_get_errors()) === false) {
            libxml_clear_errors();
            throw new DmnConversionException($errors);
        }

        return $dom;
    }

    /**
     * Returns a hit policy xml string and adds aggregation in case of collect hit policy.
     *
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