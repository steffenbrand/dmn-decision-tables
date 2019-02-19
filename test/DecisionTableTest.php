<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\Output;

class DecisionTableTest extends AbstractDmnDecisionTablesTest
{
    public function testSaveDmnFile()
    {
        $decisionTable = $this->getDishExampleDecisionTable();
        $bytesWritten = $decisionTable->saveFile(__DIR__ . '/../resources/generated_with_dmn_decision_tables.dmn');

        $this->assertEquals(3848, $bytesWritten);
    }

    /**
     * @expectedException \SteffenBrand\DmnDecisionTables\Exception\DmnConversionException
     */
    public function testXmlConversionWithInvalidXmlStringThrowsException()
    {
        DecisionTableBuilder::getInstance()
            ->setName('Dish " DOUBLE QUOTES WILL BREAK IT')
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->addInput(new Input('Season', 'season', VariableType::STRING_TYPE))
            ->addInput(new Input('How many guests', 'guests', VariableType::INTEGER_TYPE))
            ->addOutput(new Output('Dish', 'dish', VariableType::STRING_TYPE))
            ->build()
            ->toDMN();
    }
}