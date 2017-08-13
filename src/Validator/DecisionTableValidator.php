<?php

namespace SteffenBrand\DmnDecisionTables\Validator;

use SteffenBrand\DmnDecisionTables\Constant\CollectOperator;
use SteffenBrand\DmnDecisionTables\Constant\ExpressionLanguage;
use SteffenBrand\DmnDecisionTables\Constant\HitPolicy;
use SteffenBrand\DmnDecisionTables\Constant\VariableType;
use SteffenBrand\DmnDecisionTables\DecisionTableBuilderInterface;
use SteffenBrand\DmnDecisionTables\Model\Rule;

/**
 * Class DecisionTableValidator
 * @package SteffenBrand\DmnDecisionTables\Validator
 */
class DecisionTableValidator implements DecisionTableValidatorInterface
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var DecisionTableBuilderInterface
     */
    private $builder;

    /**
     * DmnTableValidator constructor.
     * @param DecisionTableBuilderInterface $builder
     */
    public function __construct($builder)
    {
        $this->valid = false;
        $this->errors = [];
        $this->builder = $builder;
    }

    /**
     * Validates a DecisionTableBuilder instance.
     *
     * @return DecisionTableValidator
     */
    public function validate()
    {
        $this->validateName();
        $this->validateDefinitionKey();
        $this->validateHitPolicy();
        $this->validateInputs();
        $this->validateOutputs();
        $this->validateRules();
        
        if (empty($this->errors) === true) {
            $this->valid = true;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return void
     */
    private function validateName()
    {
        if (empty($this->builder->getName()) === true) {
            $this->errors[] = 'name of decision table is required';
        }
    }

    /**
     * @return void
     */
    private function validateDefinitionKey()
    {
        if (empty($this->builder->getDefinitionKey()) === true) {
            $this->errors[] = 'definition key of decision table is required';
        }
    }

    /**
     * @return void
     */
    private function validateHitPolicy()
    {
        if (empty($this->builder->getHitPolicy()) === true) {
            $this->errors[] = 'hit policy of decision table is required';
        } else if (in_array($this->builder->getHitPolicy(), HitPolicy::ALLOWED_HIT_POLICIES) === false) {
            $this->errors[] = sprintf(
                'hit policy of decision table must be one of: %s',
                implode(', ', HitPolicy::ALLOWED_HIT_POLICIES)
            );
        }

        if (HitPolicy::COLLECT_POLICY === $this->builder->getHitPolicy() &&
            empty($this->builder->getCollectOperator()) === true)
        {
            $this->errors[] = 'hit policy COLLECT requires a collect operator.';
        } else if (HitPolicy::COLLECT_POLICY === $this->builder->getHitPolicy() &&
            in_array($this->builder->getCollectOperator(), CollectOperator::ALLOWED_COLLECT_OPERATORS) === false)
        {
            $this->errors[] = sprintf(
                'collect operator must be one of: %s',
                implode(', ', CollectOperator::ALLOWED_COLLECT_OPERATORS)
            );
        }
    }

    /**
     * @return void
     */
    private function validateInputs()
    {
        if (empty($this->builder->getInputs()) === true) {
            $this->errors[] = 'at least one input is required';
            return;
        }
        
        $i = 1;
        foreach ($this->builder->getInputs() as $input) {
            if (empty($input->getLabel()) === true) {
                $this->errors[] = sprintf('input no. %s: label is required', (string) $i);
            }
            
            if (empty($input->getName()) === true) {
                $this->errors[] = sprintf('input no. %s: name is required', (string) $i);
            }
            
            if (empty($input->getType()) === true) {
                $this->errors[] = sprintf('input no. %s: type is required', (string) $i);
            } else if (in_array($input->getType(), VariableType::ALLOWED_VARIABLE_TYPES) === false) {
                $this->errors[] = sprintf(
                    'input no. %s: type must be one of: %s',
                    (string) $i,
                    implode(', ', VariableType::ALLOWED_VARIABLE_TYPES)
                );
            }
            
            $i++;
        }
    }

    /**
     * @return void
     */
    private function validateOutputs()
    {
        if (empty($this->builder->getOutputs()) === true) {
            $this->errors[] = 'at least one output is required';
            return;
        }
        
        $i = 1;
        foreach ($this->builder->getOutputs() as $output) {
            if (empty($output->getLabel()) === true) {
                $this->errors[] = sprintf('output no. %s: label is required', (string) $i);
            }
            
            if (empty($output->getName()) === true) {
                $this->errors[] = sprintf('output no. %s: name is required', (string) $i);
            }
            
            if (empty($output->getType()) === true) {
                $this->errors[] = sprintf('output no. %s: type is required', (string) $i);
            } else if (in_array($output->getType(), VariableType::ALLOWED_VARIABLE_TYPES) === false) {
                $this->errors[] = sprintf(
                    'output no. %s: type must be one of: %s',
                    (string) $i,
                    implode(', ', VariableType::ALLOWED_VARIABLE_TYPES)
                );
            }
            
            $i++;
        }
    }

    /**
     * @return void
     */
    private function validateRules()
    {
        if (empty($this->builder->getRules()) === true) {
            return;
        }
        
        $i = 1;
        foreach ($this->builder->getRules() as $rule) {
            $this->validateInputEntries($rule, $i);
            $i++;
        }

        $i = 1;
        foreach ($this->builder->getRules() as $rule) {
            $this->validateOutputEntries($rule, $i);
            $i++;
        }
    }

    /**
     * @param Rule $rule
     * @param $i
     * @return void
     */
    private function validateInputEntries($rule, $i)
    {
        if (empty($rule->getInputEntries()) === true) {
            $this->errors[] = sprintf('rule no. %s: at least one input entry is required', (string) $i);
            return;
        }

        $k = 1;
        foreach ($rule->getInputEntries() as $inputEntry) {
            if (empty($inputEntry->getExpressionLanguage()) === true) {
                $this->errors[] = sprintf(
                    'rule no. %s, input entry no. %s: expression language is required',
                    (string) $i,
                    (string) $k
                );
            } else if (in_array($inputEntry->getExpressionLanguage(), ExpressionLanguage::ALLOWED_EXPRESSION_LANGUAGES) === false) {
                $this->errors[] = sprintf(
                    'rule no. %s, input entry no. %s: expression language must be one of: %s',
                    (string) $i,
                    (string) $k,
                    implode(', ', ExpressionLanguage::ALLOWED_EXPRESSION_LANGUAGES)
                );
            }

            $k++;
        }
    }

    /**
     * @param Rule $rule
     * @param $i
     * @return void
     */
    private function validateOutputEntries($rule, $i)
    {
        if (empty($rule->getOutputEntries()) === true) {
            $this->errors[] = sprintf('rule no. %s: at least one output entry is required', (string) $i);
            return;
        }

        $k = 1;
        foreach ($rule->getOutputEntries() as $outputEntry) {
            if (empty($outputEntry->getExpressionLanguage()) === true) {
                $this->errors[] = sprintf(
                    'rule no. %s, output entry no. %s: expression language is required',
                    (string) $i,
                    (string) $k
                );
            } else if (in_array($outputEntry->getExpressionLanguage(), ExpressionLanguage::ALLOWED_EXPRESSION_LANGUAGES) === false) {
                $this->errors[] = sprintf(
                    'rule no. %s, output entry no. %s: expression language must be one of: %s',
                    (string) $i,
                    (string) $k,
                    implode(', ', ExpressionLanguage::ALLOWED_EXPRESSION_LANGUAGES)
                );
            }

            $k++;
        }
    }
}