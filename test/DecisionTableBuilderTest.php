<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use SteffenBrand\DmnDecisionTables\Constant\CollectOperator;
use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\Output;

class DecisionTableBuilderTest extends AbstractDmnDecisionTablesTest
{
    public function testXmlConversion()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->addInput(new Input('Season', 'season', VariableType::STRING_TYPE))
            ->addInput(new Input('How many guests', 'guests', VariableType::INTEGER_TYPE))
            ->addOutput(new Output('Dish', 'dish', VariableType::STRING_TYPE))
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
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->addInput(new Input('Season', 'season', VariableType::STRING_TYPE))
            ->addInput(new Input('How many guests', 'guests', VariableType::INTEGER_TYPE))
            ->addOutput(new Output('Dish', 'dish', VariableType::STRING_TYPE))
            ->build();

        libxml_use_internal_errors(true);
        $xmlElement = simplexml_load_string($decisionTable->toDMN());
        $errors = libxml_get_errors();
        libxml_clear_errors();

        $this->assertEmpty($errors);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
    }

    public function testXmlConversionWithCollectHitPolicyCollectAndCollectOperator()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::COLLECT_POLICY)
            ->setCollectOperator(CollectOperator::LIST_OPERATOR)
            ->addInput(new Input('Season', 'season', VariableType::STRING_TYPE))
            ->addInput(new Input('How many guests', 'guests', VariableType::INTEGER_TYPE))
            ->addOutput(new Output('Dish', 'dish', VariableType::STRING_TYPE))
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
        $decisionTable = $this->getDishExampleDecisionTable();

        libxml_use_internal_errors(true);
        $xmlElement = simplexml_load_string($decisionTable->toDMN());
        $errors = libxml_get_errors();
        libxml_clear_errors();

        $this->assertEmpty($errors);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlElement);
    }
}