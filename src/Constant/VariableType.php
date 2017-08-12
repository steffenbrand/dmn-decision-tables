<?php

namespace SteffenBrand\DmnDecisionTables\Constant;

class VariableType
{
    const STRING_TYPE = 'string';
    const BOOLEAN_TYPE = 'boolean';
    const INTEGER_TYPE = 'integer';
    const LONG_TYPE = 'long';
    const DOUBLE_TYPE = 'double';
    const DATE_TYPE = 'date';

    const ALLOWED_VARIABLE_TYPES = [
        self::STRING_TYPE,
        self::BOOLEAN_TYPE,
        self::INTEGER_TYPE,
        self::LONG_TYPE,
        self::DOUBLE_TYPE,
        self::DATE_TYPE
    ];
}