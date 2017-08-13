<?php

namespace SteffenBrand\DmnDecisionTables\Model;

class Input implements DmnConvertibleInterface
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
        return
            '<input id="' . uniqid('input') . '" label="' . $this->label . '">' .
                '<inputExpression id="' . uniqid('inputExpression') . '" typeRef="' . $this->type . '">' .
                    '<text>' . $this->name . '</text>' .
                '</inputExpression>' .
            '</input>';
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