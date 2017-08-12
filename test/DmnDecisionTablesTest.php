<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use PHPUnit_Framework_TestCase;
use SteffenBrand\DmnDecisionTables\Constant\CollectOperator;
use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
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
            ->addInput('Season', 'season', VariableType::STRING_TYPE)
            ->addInput('How many guests', 'guests', VariableType::INTEGER_TYPE)
            ->addOutput('Dish', 'dish', VariableType::STRING_TYPE)
            ->build();

        libxml_use_internal_errors(true);
        $xmlElement = simplexml_load_string($decisionTable->toDMN());
        $errors = libxml_get_errors();
        libxml_clear_errors();

        $this->assertEmpty($errors);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
    }

    public function testXmlConversionWithHitPolicy()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setId('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->addInput('Season', 'season', VariableType::STRING_TYPE)
            ->addInput('How many guests', 'guests', VariableType::INTEGER_TYPE)
            ->addOutput('Dish', 'dish', VariableType::STRING_TYPE)
            ->build();

        libxml_use_internal_errors(true);
        $xmlElement = simplexml_load_string($decisionTable->toDMN());
        $errors = libxml_get_errors();
        libxml_clear_errors();

        $this->assertEmpty($errors);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
    }

    public function testXmlConversionWithHitPolicyCollectAndCollectOperator()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setId('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->setCollectOperator(CollectOperator::LIST_OPERATOR)
            ->addInput('Season', 'season', VariableType::STRING_TYPE)
            ->addInput('How many guests', 'guests', VariableType::INTEGER_TYPE)
            ->addOutput('Dish', 'dish', VariableType::STRING_TYPE)
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
            ->addInput('Season', 'season', VariableType::STRING_TYPE)
            ->addInput('How many guests', 'guests', VariableType::INTEGER_TYPE)
            ->addOutput('Dish', 'dish', VariableType::STRING_TYPE)
            ->build()
            ->toDMN();
    }
}