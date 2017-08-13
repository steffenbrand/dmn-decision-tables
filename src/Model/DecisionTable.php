<?php

namespace SteffenBrand\DmnDecisionTables\Model;

use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Exception\DmnConversionException;

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
     * @return string
     * @throws DmnConversionException
     */
    public function toDMN()
    {
        $dom = $this->getDomDocument();

        return $dom->saveXML();
    }

    /**
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
            '<definitions xmlns="http://www.omg.org/spec/DMN/20151101/dmn11.xsd" id="definitions" name="definitions" namespace="http://camunda.org/schema/1.0/dmn">' .
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