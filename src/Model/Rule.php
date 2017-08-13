<?php

namespace SteffenBrand\DmnDecisionTables\Model;

/**
 * Class Rule
 * @package SteffenBrand\DmnDecisionTables\Model
 */
class Rule implements DmnConvertibleInterface
{
    use ArrayToDmnTrait;

    /**
     * @var string
     */
    private $description;

    /**
     * @var InputEntry[]
     */
    private $inputEntries;

    /**
     * @var OutputEntry[]
     */
    private $outputEntries;

    /**
     * Rule constructor.
     * @see https://docs.camunda.org/manual/latest/reference/dmn11/feel/
     * @param InputEntry[] $inputEntries
     * @param OutputEntry[] $outputEntries
     * @param string|null $description
     */
    public function __construct($inputEntries, $outputEntries, $description = null)
    {
        $this->inputEntries = $inputEntries;
        $this->outputEntries = $outputEntries;
        $this->description = $description;
    }

    /**
     * Returns an XML representation of a rule.
     *
     * @return string
     */
    public function toDMN()
    {
        return
            '<rule id="' . uniqid('rule') . '">' .
                $this->getDescriptionXml() .
                $this->getDmnFromArray($this->inputEntries) .
                $this->getDmnFromArray($this->outputEntries) .
            '</rule>';
    }

    /**
     * @return string
     */
    private function getDescriptionXml()
    {
        if (isset($this->description) === false || trim($this->description) === '') {
            return '';
        }
        return '<description>' . $this->description . '</description>';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return InputEntry[]
     */
    public function getInputEntries()
    {
        return $this->inputEntries;
    }

    /**
     * @return OutputEntry[]
     */
    public function getOutputEntries()
    {
        return $this->outputEntries;
    }
}