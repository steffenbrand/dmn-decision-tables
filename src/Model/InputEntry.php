<?php

namespace SteffenBrand\DmnDecisionTables\Model;

use SteffenBrand\DmnDecisionTables\Constant\ExpressionLanguage;

/**
 * Class InputEntry
 * @package SteffenBrand\DmnDecisionTables\Model
 */
class InputEntry implements DmnConvertibleInterface
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
     * InputEntry constructor.
     * @param string $expression
     * @param string $expressionLanguage
     */
    public function __construct($expression, $expressionLanguage = ExpressionLanguage::FEEL_LANGUAGE)
    {
        $this->expression = $expression;
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * Returns an XML representation of an input entry.
     *
     * @return string
     */
    public function toDMN()
    {
        $xml = '';

        if (isset($this->expression) === false || trim($this->expression) === '') {
            $xml .=
                '<inputEntry id="' . uniqid('inputEntry') . '"><text/></inputEntry>';
        } else {
            $xml .=
                '<inputEntry id="' . uniqid('inputEntry') . '" expressionLanguage="' . $this->expressionLanguage . '">' .
                    '<text><![CDATA[' . $this->expression . ']]></text>' .
                '</inputEntry>';
        }

        return $xml;
    }

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @return string
     */
    public function getExpressionLanguage()
    {
        return $this->expressionLanguage;
    }
}