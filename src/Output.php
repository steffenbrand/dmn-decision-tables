<?php

namespace SteffenBrand\DmnDecisionTables;

class Output
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
     * @return string
     */
    public function toDMN()
    {
        return '<output id="' . uniqid('output') . '" label="' . $this->label . '" name="' . $this->name . '" typeRef="' . $this->type . '"/>';
    }
}