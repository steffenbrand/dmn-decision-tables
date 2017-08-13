[![Build](https://travis-ci.org/steffenbrand/dmn-decision-tables.svg?branch=master)](https://travis-ci.org/steffenbrand/dmn-decision-tables)
[![Coverage](https://codecov.io/github/steffenbrand/dmn-decision-tables/coverage.svg)](https://codecov.io/gh/steffenbrand/dmn-decision-tables)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/steffenbrand/dmn-decision-tables/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/steffenbrand/dmn-decision-tables/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/steffenbrand/dmn-decision-tables/version)](https://packagist.org/packages/steffenbrand/dmn-decision-tables)
[![Total Downloads](https://poser.pugx.org/steffenbrand/dmn-decision-tables/downloads)](https://packagist.org/packages/steffenbrand/dmn-decision-tables)
[![License](https://poser.pugx.org/steffenbrand/dmn-decision-tables/license)](https://github.com/steffenbrand/dmn-decision-tables/blob/master/LICENSE.md)

# DMN Decision Tables
PHP library to programmatically create DMN decision tables

## Limitations

- Generated tables have been tested with [Camunda BPM platform](https://camunda.com/) and [Camunda Cloud](https://dmn.camunda.cloud/), but have __NOT__ been tested
with any other BPMN engine
- Only [FEEL](https://docs.camunda.org/manual/latest/reference/dmn11/feel/) and JUEL expressions have been tested yet
- Only one decision table is supported per .dmn-file
- No DRD features are supported
- IDs are generated randomly, as you can see from the examples below

## How to install

```
composer require steffenbrand/dmn-decision-tables
```

## How to use

These examples show how to build the [Camunda Cloud](https://dmn.camunda.cloud/) example table

### Build decision table

```php
try {
    $decisionTable = DecisionTableBuilder::getInstance()
        ->setName('Dish')
        ->setDefinitionKey('decision')
        ->setHitPolicy(HitPolicy::UNIQUE_POLICY)
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
} catch (DmnValidationException $e) {
    // Build method validates before it creates the DecisionTable.
    // Can be disabled, so feel free to validate yourself.
    // Use the DecisionTableValidator or inject your own validator.
} catch (DmnConversionException $e) {
    // Conversion to XML might fail because of invalid expressions or whatever.
}
```

### Convert to DMN string (XML)

```php
$decisionTable->toDMN();

```

### Save to filesystem

```php
$decisionTable->saveFile('/my/path/and/filename.dmn');
```

### What the result looks like

```xml
<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://www.omg.org/spec/DMN/20151101/dmn11.xsd" id="definitions" name="definitions" namespace="http://camunda.org/schema/1.0/dmn">
  <decision id="decision" name="Dish">
    <decisionTable id="decisionTable5990364503747" hitPolicy="UNIQUE">
      <input id="input599036450376b" label="Season">
        <inputExpression id="inputExpression5990364503774" typeRef="string">
          <text>season</text>
        </inputExpression>
      </input>
      <input id="input5990364503786" label="How many guests">
        <inputExpression id="inputExpression5990364503790" typeRef="integer">
          <text>guests</text>
        </inputExpression>
      </input>
      <output id="output59903645037c4" label="Dish" name="dish" typeRef="string"/>
      <rule id="rule59903645037de">
        <inputEntry id="inputEntry59903645037fb" expressionLanguage="feel">
          <text><![CDATA["Fall"]]></text>
        </inputEntry>
        <inputEntry id="inputEntry5990364503816" expressionLanguage="feel">
          <text><![CDATA[<= 8]]></text>
        </inputEntry>
        <outputEntry id="outputEntry5990364503833" expressionLanguage="juel">
          <text><![CDATA["Spareribs"]]></text>
        </outputEntry>
      </rule>
      <rule id="rule5990364503847">
        <inputEntry id="inputEntry5990364503880" expressionLanguage="feel">
          <text><![CDATA["Winter"]]></text>
        </inputEntry>
        <inputEntry id="inputEntry59903645038bf" expressionLanguage="feel">
          <text><![CDATA[<= 8]]></text>
        </inputEntry>
        <outputEntry id="outputEntry59903645038ee" expressionLanguage="juel">
          <text><![CDATA["Roastbeef"]]></text>
        </outputEntry>
      </rule>
      <rule id="rule59903645038fc">
        <inputEntry id="inputEntry599036450390a" expressionLanguage="feel">
          <text><![CDATA["Spring"]]></text>
        </inputEntry>
        <inputEntry id="inputEntry5990364503916" expressionLanguage="feel">
          <text><![CDATA[<= 4]]></text>
        </inputEntry>
        <outputEntry id="outputEntry5990364503922" expressionLanguage="juel">
          <text><![CDATA["Dry Aged Gourmet Steak"]]></text>
        </outputEntry>
      </rule>
      <rule id="rule5990364503930">
        <description>Save money</description>
        <inputEntry id="inputEntry599036450393e" expressionLanguage="feel">
          <text><![CDATA["Spring"]]></text>
        </inputEntry>
        <inputEntry id="inputEntry599036450394d" expressionLanguage="feel">
          <text><![CDATA[[5..8]]]></text>
        </inputEntry>
        <outputEntry id="outputEntry5990364503961" expressionLanguage="juel">
          <text><![CDATA["Steak"]]></text>
        </outputEntry>
      </rule>
      <rule id="rule599036450396e">
        <description>Less effort</description>
        <inputEntry id="inputEntry599036450397b" expressionLanguage="feel">
          <text><![CDATA["Fall", "Winter", "Spring"]]></text>
        </inputEntry>
        <inputEntry id="inputEntry5990364503985" expressionLanguage="feel">
          <text><![CDATA[> 8]]></text>
        </inputEntry>
        <outputEntry id="outputEntry5990364503991" expressionLanguage="juel">
          <text><![CDATA["Stew"]]></text>
        </outputEntry>
      </rule>
      <rule id="rule599036450399d">
        <description>Hey, why not!?</description>
        <inputEntry id="inputEntry59903645039ab" expressionLanguage="feel">
          <text><![CDATA["Summer"]]></text>
        </inputEntry>
        <inputEntry id="inputEntry59903645039b4">
          <text/>
        </inputEntry>
        <outputEntry id="outputEntry59903645039c0" expressionLanguage="juel">
          <text><![CDATA["Light Salad and a nice Steak"]]></text>
        </outputEntry>
      </rule>
    </decisionTable>
  </decision>
</definitions>

```

## Try it

Feel free to download [generated_with_dmn_decision_tables.dmn](https://github.com/steffenbrand/dmn-decision-tables/blob/master/resources/generated_with_dmn_decision_tables.dmn)
and try it in the [Camunda Cloud](https://dmn.camunda.cloud/)