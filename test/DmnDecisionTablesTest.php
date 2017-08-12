<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use PHPUnit_Framework_TestCase;
use SteffenBrand\DmnDecisionTables\Constant\CollectOperator;
use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;

class DmnDecisionTablesTest extends PHPUnit_Framework_TestCase
{
    public function testXmlConversion()
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
            ->setHitPolicy(HitPolicy::COLLECT_POLICY)
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

    public function testXmlConversionWithRules()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setId('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->addInput('Season', 'season', VariableType::STRING_TYPE)
            ->addInput('How many guests', 'guests', VariableType::INTEGER_TYPE)
            ->addOutput('Dish', 'dish', VariableType::STRING_TYPE)
            ->addRule(
                ['"Fall"', '<= 8'],
                ['"Spareribs"']
            )
            ->addRule(
                ['"Winter"', '<= 8'],
                ['"Roastbeef"']
            )
            ->addRule(
                ['"Spring"', '<= 4'],
                ['"Dry Aged Gourmet Steak"']
            )
            ->addRule(
                ['"Spring"', '[5..8]'],
                ['"Steak"'],
                'Save money'
            )
            ->addRule(
                ['"Fall", "Winter", "Spring"', '> 8'],
                ['"Stew"'],
                'Less effort'
            )
            ->addRule(
                ['"Summer"', null],
                ['"Light Salad and a nice Steak"'],
                'Hey, why not!?'
            )
            ->build();

        echo $decisionTable->toDMN();

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