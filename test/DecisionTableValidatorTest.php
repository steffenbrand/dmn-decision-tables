<?php

namespace SteffenBrand\DmnDecisionTables\Test;

use SteffenBrand\DmnDecisionTables\Constant\CollectOperator;
use SteffenBrand\DmnDecisionTables\Constant\ExpressionLanguage;
use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilder;
use SteffenBrand\DmnDecisionTables\Model\Input;
use SteffenBrand\DmnDecisionTables\Model\InputEntry;
use SteffenBrand\DmnDecisionTables\Model\Output;
use SteffenBrand\DmnDecisionTables\Model\OutputEntry;
use SteffenBrand\DmnDecisionTables\Validator\DecisionTableValidator;

class DmnDecisionTablesTest extends AbstractDmnDecisionTablesTest
{
    /**
     * @expectedException \SteffenBrand\DmnDecisionTables\Exception\DmnValidationException
     */
    public function testBuildOnFreshInstanceThrowsException()
    {
        DecisionTableBuilder::getInstance()->build();
    }

    /**
     * @expectedException \SteffenBrand\DmnDecisionTables\Exception\DmnValidationException
     */
    public function testValidatorInjection()
    {
        $builder = DecisionTableBuilder::getInstance();
        $builder->build(true, new DecisionTableValidator($builder));
    }

    public function testValidatorInitialState()
    {
        $builder = DecisionTableBuilder::getInstance();
        $validator = new DecisionTableValidator($builder);

        $this->assertFalse($validator->isValid());
        $this->assertEmpty($validator->getErrors());
    }

    public function testValidatorGetErrorsOnFreshBuilderInstance()
    {
        $builder = DecisionTableBuilder::getInstance();
        $validator = new DecisionTableValidator($builder);
        $validator->validate();
        $errors = $validator->getErrors();

        $this->assertFalse($validator->isValid());
        $this->assertNotEmpty($errors);
        $this->assertEquals(5, count($errors));
        $this->assertEquals('name of decision table is required', $errors[0]);
        $this->assertEquals('definition key of decision table is required', $errors[1]);
        $this->assertEquals('hit policy of decision table is required', $errors[2]);
        $this->assertEquals('at least one input is required', $errors[3]);
        $this->assertEquals('at least one output is required', $errors[4]);
    }

    public function testValidatorGetErrorsOnComplexBuilderInstance1()
    {
        $builder = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::COLLECT_POLICY)
            ->addInput(new Input('', null, VariableType::STRING_TYPE))
            ->addInput(new Input('How many guests', 'guests', 'invalid'))
            ->addOutput(new Output(null, '', VariableType::STRING_TYPE))
            ->addRule(
                [
                    new InputEntry('"Fall"', 'invalid'),
                    new InputEntry('<= 8', ExpressionLanguage::FEEL_LANGUAGE)
                ],
                [new OutputEntry('"Spareribs"', null)]
            );

        $validator = new DecisionTableValidator($builder);
        $validator->validate();
        $errors = $validator->getErrors();

        $this->assertEquals(8, count($errors));
        $this->assertFalse($validator->isValid());
        $this->assertNotEmpty($errors);
        $this->assertEquals('hit policy COLLECT requires a collect operator.', $errors[0]);
        $this->assertEquals('input no. 1: label is required', $errors[1]);
        $this->assertEquals('input no. 1: name is required', $errors[2]);
        $this->assertEquals('input no. 2: type must be one of: string, boolean, integer, long, double, date', $errors[3]);
        $this->assertEquals('output no. 1: label is required', $errors[4]);
        $this->assertEquals('output no. 1: name is required', $errors[5]);
        $this->assertEquals('rule no. 1, input entry no. 1: expression language must be one of: feel, javascript, groovy, python, jruby, juel', $errors[6]);
        $this->assertEquals('rule no. 1, output entry no. 1: expression language is required', $errors[7]);
    }

    public function testValidatorGetErrorsOnComplexBuilderInstance2()
    {
        $builder = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setDefinitionKey('decision')
            ->setHitPolicy('invalid')
            ->addInput(new Input('Season', null, null))
            ->addInput(new Input('How many guests', 'guests', 'invalid'))
            ->addOutput(new Output('Dish', '', VariableType::STRING_TYPE))
            ->addRule(
                [
                    new InputEntry('"Fall"', 'invalid'),
                    new InputEntry('<= 8', ExpressionLanguage::FEEL_LANGUAGE)
                ],
                [new OutputEntry('"Spareribs"', null)]
            )
            ->addRule(
                [],
                []
            );

        $validator = new DecisionTableValidator($builder);
        $validator->validate();
        $errors = $validator->getErrors();

        $this->assertEquals(9, count($errors));
        $this->assertFalse($validator->isValid());
        $this->assertNotEmpty($errors);
        $this->assertEquals('hit policy of decision table must be one of: UNIQUE, FIRST, PRIORITY, ANY, COLLECT, RULE ORDER, OUTPUT ORDER', $errors[0]);
        $this->assertEquals('input no. 1: name is required', $errors[1]);
        $this->assertEquals('input no. 1: type is required', $errors[2]);
        $this->assertEquals('input no. 2: type must be one of: string, boolean, integer, long, double, date', $errors[3]);
        $this->assertEquals('output no. 1: name is required', $errors[4]);
        $this->assertEquals('rule no. 1, input entry no. 1: expression language must be one of: feel, javascript, groovy, python, jruby, juel', $errors[5]);
        $this->assertEquals('rule no. 2: at least one input entry is required', $errors[6]);
        $this->assertEquals('rule no. 1, output entry no. 1: expression language is required', $errors[7]);
        $this->assertEquals('rule no. 2: at least one output entry is required', $errors[8]);
    }

    public function testValidatorGetErrorsOnComplexBuilderInstance3()
    {
        $builder = DecisionTableBuilder::getInstance()
            ->setName('Dish')
            ->setDefinitionKey('decision')
            ->setHitPolicy(HitPolicy::COLLECT_POLICY)
            ->setCollectOperator('invalid')
            ->addInput(new Input('Season', null, 'invalid'))
            ->addInput(new Input('How many guests', 'guests', 'invalid'))
            ->addOutput(new Output('Dish', '', 'invalid'))
            ->addOutput(new Output('Dish2', 'dish2', null))
            ->addRule(
                [
                    new InputEntry('"Fall"', 'invalid'),
                    new InputEntry('<= 8', ExpressionLanguage::FEEL_LANGUAGE)
                ],
                [new OutputEntry('"Spareribs"', null)]
            )
            ->addRule(
                [
                    new InputEntry('"Fall"', null),
                    new InputEntry('<= 8', '')
                ],
                [new OutputEntry('"Spareribs"', 'invalid')]
            );

        $validator = new DecisionTableValidator($builder);
        $validator->validate();
        $errors = $validator->getErrors();

        $this->assertEquals(12, count($errors));
        $this->assertEquals('collect operator must be one of: LIST, SUM, MIN, MAX, COUNT', $errors[0]);
        $this->assertEquals('input no. 1: name is required', $errors[1]);
        $this->assertEquals('input no. 1: type must be one of: string, boolean, integer, long, double, date', $errors[2]);
        $this->assertEquals('input no. 2: type must be one of: string, boolean, integer, long, double, date', $errors[3]);
        $this->assertEquals('output no. 1: name is required', $errors[4]);
        $this->assertEquals('output no. 1: type must be one of: string, boolean, integer, long, double, date', $errors[5]);
        $this->assertEquals('output no. 2: type is required', $errors[6]);
        $this->assertEquals('rule no. 1, input entry no. 1: expression language must be one of: feel, javascript, groovy, python, jruby, juel', $errors[7]);
        $this->assertEquals('rule no. 2, input entry no. 1: expression language is required', $errors[8]);
        $this->assertEquals('rule no. 2, input entry no. 2: expression language is required', $errors[9]);
        $this->assertEquals('rule no. 1, output entry no. 1: expression language is required', $errors[10]);
        $this->assertEquals('rule no. 2, output entry no. 1: expression language must be one of: feel, javascript, groovy, python, jruby, juel', $errors[11]);
    }
}