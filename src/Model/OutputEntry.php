<?php

namespace SteffenBrand\DmnDecisionTables\Model;

use SteffenBrand\DmnDecisionTables\Constant\ExpressionLanguage;

class OutputEntry implements DmnConvertibleInterface
{
    /**
     * @var string
     */
    private $expression;

    /**
     * @var string
     */
    private $expressionLanguage;

    /**
     * OutputEntry constructor.
     * @param string $expression
     * @param string $expressionLanguage
     */
    public function __construct($expression, $expressionLanguage = ExpressionLanguage::JUEL_LANGUAGE)
    {
        $this->expression = $expression;
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * @return string
     */
    public function toDMN()
    {
        $xml = '';

        if (isset($this->expression) === false || trim($this->expression) === '') {
            $xml .= '<outputEntry id="' . uniqid('outputEntry') . '"><text/></outputEntry>';
        } else {
            $xml .=
                '<outputEntry id="' . uniqid('outputEntry') . '" expressionLanguage="' . $this->expressionLanguage . '">' .
                    '<text><![CDATA[' . $this->expression . ']]></text>' .
                '</outputEntry>';
        }

        return $xml;
    }
}