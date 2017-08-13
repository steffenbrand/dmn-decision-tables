<?php

namespace SteffenBrand\DmnDecisionTables\Model;

/**
 * Class Output
 * @package SteffenBrand\DmnDecisionTables\Model
 */
class Output implements DmnConvertibleInterface
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * Input constructor.
     * @param string $label
     * @param string $name
     * @param string $type
     */
    public function __construct($label, $name, $type)
    {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Returns an XML representation of an output.
     *
     * @return string
     */
    public function toDMN()
    {
        return '<output id="' . uniqid('output') . '" label="' . $this->label . '" name="' . $this->name . '" typeRef="' . $this->type . '"/>';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}