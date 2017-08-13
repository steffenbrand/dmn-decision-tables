<?php

namespace SteffenBrand\DmnDecisionTables\Model;

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
     * @return string
     */
    public function toDMN()
    {
        return
            '<rule id="' . uniqid('rule') . '">' .
                $this->getDescription() .
                $this->getDmnFromArray($this->inputEntries) .
                $this->getDmnFromArray($this->outputEntries) .
            '</rule>';
    }

    /**
     * @return string
     */
    private function getDescription()
    {
        if (null === $this->description) {
            return '';
        }
        return '<description>' . $this->description . '</description>';
    }
}