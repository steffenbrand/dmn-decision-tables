<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use SteffenBrand\DmnDecisionTables\Constant\ExpressionLanguage;
use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Model\DecisionTable;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\InputEntry;
use SteffenBrand\DmnDecisionTables\Model\Output;
use SteffenBrand\DmnDecisionTables\Model\OutputEntry;

abstract class AbstractDmnDecisionTablesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DecisionTable
     */
    protected function getDishExampleDecisionTable()
    {
        $decisionTable = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::FIRST_POLICY)
            ->addInput(new Input('Season', 'season', VariableType::STRING_TYPE))
            ->addInput(new Input('How many guests', 'guests', VariableType::INTEGER_TYPE))
            ->addOutput(new Output('Dish', 'dish', VariableType::STRING_TYPE))
            ->addRule(
                [
                    new InputEntry('"Fall"', ExpressionLanguage::FEEL_LANGUAGE),
                    new InputEntry('<= 8', ExpressionLanguage::FEEL_LANGUAGE)
                ],
                [new OutputEntry('"Spareribs"', ExpressionLanguage::JUEL_LANGUAGE)]
            )
            ->addRule(
                [new InputEntry('"Winter"'), new InputEntry('<= 8')],
                [new OutputEntry('"Roastbeef"')]
            )
            ->addRule(
                [new InputEntry('"Spring"'), new InputEntry('<= 4')],
                [new OutputEntry('"Dry Aged Gourmet Steak"')]
            )
            ->addRule(
                [new InputEntry('"Spring"'), new InputEntry('[5..8]')],
                [new OutputEntry('"Steak"')],
                'Save money'
            )
            ->addRule(
                [new InputEntry('"Fall", "Winter", "Spring"'), new InputEntry('> 8')],
                [new OutputEntry('"Stew"')],
                'Less effort'
            )
            ->addRule(
                [new InputEntry('"Summer"'), new InputEntry(null)],
                [new OutputEntry('"Light Salad and a nice Steak"')],
                'Hey, why not!?'
            )
            ->build();

        return $decisionTable;
    }
}