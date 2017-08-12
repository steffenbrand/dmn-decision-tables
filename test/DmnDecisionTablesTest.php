<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use PHPUnit_Framework_TestCase;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Model\DecisionTable;

class DmnDecisionTablesTest extends PHPUnit_Framework_TestCase
{
    public function testBuildMethodReturnsDecisionTable()
    {
        $decisionTable = DecisionTableBuilder::getInstance()->build();

        $this->assertInstanceOf(DecisionTable::class, $decisionTable);
    }

    public function testXmlConversion()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setId('decision')
            ->addInput('Season', 'season', 'string')
            ->addInput('How many guests', 'guests', 'integer')
            ->addOutput('Dish', 'dish', 'string')
            ->build();

        libxml_use_internal_errors(true);
        $xmlElement = simplexml_load_string($decisionTable->toDMN());
        $errors = libxml_get_errors();
        libxml_clear_errors();

        $this->assertEmpty($errors);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
    }

    /**
     * @expectedException \SteffenBrand\DmnDecisionTables\Exception\DmnConversionException
     */
    public function testXmlConversionWithInvalidXmlStringThrowsException()
    {
        DecisionTableBuilder::getInstance()
            ->setName('Dish " DOUBLE QUOTES WILL BREAK IT')
            ->setId('decision')
            ->addInput('Season', 'season', 'string')
            ->addInput('How many guests', 'guests', 'integer')
            ->addOutput('Dish', 'dish', 'string')
            ->build()
            ->toDMN();
    }
}