<?php

namespace SteffenBrand\DmnDecisionTables\Model;

class Rule implements DmnConvertibleInterface
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $inputEntries;

    /**
     * @var array
     */
    private $outputEntries;

    /**
     * Rule constructor.
     * @see https://docs.camunda.org/manual/latest/reference/dmn11/feel/
     * @param array $inputEntries Array of valid FEEL expressions
     * @param array $outputEntries Array of valid FEEL expressions
     * @param string|null $description
     */
    public function __construct($inputEntries, $outputEntries, $description = null)
    {
        $this->description = $description;
        $this->inputEntries = $inputEntries;
        $this->outputEntries = $outputEntries;
    }

    /**
     * @return string
     */
    public function toDMN()
    {
        return
            '<rule id="' . uniqid('rule') . '">' .
                $this->getDescription() .
                $this->getInputEntries() .
                $this->getOutputEntries() .
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

    /**
     * @return string
     */
    private function getInputEntries()
    {
        $xml = '';

        foreach ($this->inputEntries as $inputEntry) {
            if (isset($inputEntry) === false || trim($inputEntry) === '') {
                $xml .= '<inputEntry id="' . uniqid('inputEntry') . '"><text/></inputEntry>';
            } else {
                $xml .= '<inputEntry id="' . uniqid('inputEntry') . '"><text><![CDATA[' . $inputEntry . ']]></text></inputEntry>';
            }
        }

        return $xml;
    }

    /**
     * @return string
     */
    private function getOutputEntries()
    {
        $xml = '';

        foreach ($this->outputEntries as $outputEntry) {
            if (isset($outputEntry) === false || trim($outputEntry) === '') {
                $xml .= '<outputEntry id="' . uniqid('inputEntry') . '"><text/></outputEntry>';
            } else {
                $xml .= '<outputEntry id="' . uniqid('inputEntry') . '"><text><![CDATA[' . $outputEntry . ']]></text></outputEntry>';
            }
        }

        return $xml;
    }
}